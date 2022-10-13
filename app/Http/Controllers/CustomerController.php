<?php

namespace App\Http\Controllers;

use App\Exports\CustomersExport;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Imports\CustomersImport;
use Illuminate\Http\Request;
use App\Models\Customer;
use Exception;
use Maatwebsite\Excel\Facades\Excel;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        
        $customers = Customer::active()->simple()->defaultSort()->params($request->all())->paginate(5);
        
        if ($request->ajax()) {
            // dd($customers, $request->all());
            return view('frontend.ajaxCustomer', compact('customers'))->render();
        }


        // list 
        return view('frontend.customer',compact('customers'));
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

        if($request->active)    $request->active = $ACTIVE;
        else    $request->active = $DEACTIVE;

        $store = Customer::create([
            'customer_name' => $request->name,
            'email' => $request->email,
            'tel_num' => $request->phone,
            'address' => $request->address,
            'is_active' => $request->active
        ]);

        $html = null;
        
        if($store){
            $customers = Customer::active()->simple()->defaultSort()->paginate(5);
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



        if(!$update){
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
  
    public function import(){
        try{
            Excel::import(new CustomersImport, request()->file('file'));
            return redirect()->back()->with('success','Thêm file CSV thành công!');
        }catch(Exception $e){
            return redirect()->back()->with('fail','Không thể thêm file CSV!');
        }
        
    }

    public function exportCsv()
    {
        # code...
        return Excel::download(new CustomersExport,"customers.csv");
    }
}
