<?php

namespace App\Http\Controllers;

use App\Exports\CustomersExport;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Imports\CustomersImport;
use Illuminate\Http\Request;
use App\Models\Customer;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if (!Cookie::get('user') && !session()->has('users')) {
            return redirect()->route('login');
        }

        $customers = Customer::simple()->defaultSort()->params($request->all())->paginate(5);

        if ($request->ajax()) {
            return view('frontend.ajaxCustomer', compact('customers'))->render();
        }

        // list 
        return view('frontend.customer', compact('customers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCustomerRequest $request)
    {

        $ACTIVE = 1;
        $DEACTIVE = 0;

        if ($request->active)    $request->active = $ACTIVE;
        else    $request->active = $DEACTIVE;

        $store = Customer::create([
            'customer_name' => $request->name,
            'email' => $request->email,
            'tel_num' => $request->phone,
            'address' => $request->address,
            'is_active' => $request->active
        ]);

        $html = null;

        if ($store) {
            $customers = Customer::simple()->defaultSort()->paginate(5);
            $html = view('frontend.ajaxCustomer', compact('customers'))->render();
        }

        return response()->json([
            'status' => $store,
            'html' => $html
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCustomerRequest $request, $id)
    {

        $update = Customer::id($request->customerId)->updateCustomer($request->all());



        if (!$update) {
            return response()->json([
                'status' => false
            ]);
        }

        return response()->json([
            'status' => false,
            'customer' => $request->all()
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function duplicateEmail($fileCsv, $currentKey, $currentRow)
    {

        $rowDuplicate = [];

        foreach ($fileCsv as $keyCheck => $rowCheck) {

            if ($currentKey == $keyCheck)   continue;

            if ($currentRow[1] == $rowCheck[1]) {

                $mess_Duplicate = !empty($rowDuplicate[$currentKey]) ? $rowDuplicate[$currentKey] : '';

                $rowDuplicate[$currentKey] = trim($mess_Duplicate . ", D??ng " . $keyCheck + 2, ", ");
            }
        }

        return $rowDuplicate;
    }

    public function import()
    {
        try {

            request()->validate([
                'file' => 'required|mimes:csv,txt'
            ]);

            $fileCsv = Excel::toArray(new CustomersImport, request()->file('file'));

            $emailColumn = 1;

            $fileCsv = collect($fileCsv[0])->map(function ($row, $index) {
                $row['row'] = $index + 2;

                return $row;
            })
            ->groupBy($emailColumn)
            ->filter(function ($rows) {
                $isDuplicate = count($rows) >= 2;
                
                return $isDuplicate;
            })->map(function ($rows, $email) {
                return "D??ng {$rows->pluck("row")->implode(", ")} tr??ng {$email}";
            })->toArray();

            // $mess_Duplicate = [];

            // foreach ($fileCsv[0] as $key1 => $row1) {

            //     $emailCheck = $row1[1];

            //     $mess_Duplicate[$key1] = implode("",$this->duplicateEmail($fileCsv[0], $key1, $row1));

            // }

            if ($fileCsv) {
                return redirect()->back()->with(compact('fileCsv'));
            }

            Excel::import(new CustomersImport, request()->file('file'));

            return redirect()->route('customers.index')->with('success', 'Th??m file CSV th??nh c??ng!');
        } catch (ValidationException $e) {
            $failures = $e->failures();

            $arr_messFail = [];

            foreach ($failures as $failure) {

                Log::info("error", [
                    $failure->row(), // row that went wrong
                    $failure->attribute(), // either heading key (if using heading row concern) or column index
                    $failure->errors(), // Actual error messages from Laravel validator
                    $failure->values(), // The values of the row that has failed.
                ]);

                $msg_error = !empty($arr_messFail[$failure->row()]) ? $arr_messFail[$failure->row()] : '';

                $arr_messFail[$failure->row()] =  trim($msg_error . ', ' . implode(', ', $failure->errors()), ', ');
            }

            return redirect()->back()->with(compact('arr_messFail'));
        }
    }

    public function exportCsv()
    {
        # code...
        return Excel::download(new CustomersExport, "customers.csv");
    }
}
