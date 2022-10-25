<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRequestProduct;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class ProductsController extends Controller
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
        
        $products = Product::simple()->defaultSort()->params($request->all())->paginate(5);

        if ($request->ajax()) {

            return view('frontend.ajaxProduct', compact('products'))->render();
        }

        return view('frontend.product', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequestProduct $request)
    {

        $qualityProduct = Product::count();

        $autoIdProduct = strtoupper(
            substr($request->name, 0, 1)
        ) . str_pad(
            $qualityProduct + 1,
            11 - strlen($qualityProduct + 1),
            '0',
            STR_PAD_LEFT
        );

        $nameImage = null;

        if ($request->hasFile('fileImage')) {
            $nameImage = time() . "_" . $request->file('fileImage')->getClientOriginalName();
            $request->file('fileImage')->move(public_path('images'), $nameImage);
        }

        $store = Product::create([
            'product_id' => $autoIdProduct,
            'product_name' => $request->name,
            'product_image' => $nameImage,
            'product_price' => $request->price,
            'is_sales' => $request->sale,
            'description' => $request->description
        ]);

        $html = null;

        if ($store) {
            $products = Product::simple()->defaultSort()->params($request->all())->paginate(5);
            $html = view('frontend.ajaxProduct', compact('products'))->render();
        }

        return response()->json([
            'message' => $store ? 'Save Successful!' : 'Save Failure',
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
        //
        $product = Product::id($id)->get();
        return $product;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, $id)
    {
        
        $nameImage = $request->imageName;

        if ($request->hasFile('fileImage')) {
            $nameImage = time() . "_" . $request->file('fileImage')->getClientOriginalName();
            $request->file('fileImage')->move(public_path('images'), $nameImage);
        }

        // dd($request->all());

        $data = [
            'product_name' => $request->name,
            'product_image' => $nameImage,
            'product_price' => $request->price,
            'description' => $request->description,
            'is_sales' => $request->sale
        ];

        $update = Product::id($request->productId)->updateProduct($data);

        if (!$update) {
            return response()->json([
                'status' => $update
            ]);
        }


        return response()->json([
            'status' => $update,
            'product' => $request->all(),
            'productJson' => json_encode($data) 
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
        $delete = Product::id($id)->delete();

        if (!$delete) {
            return response()->json([
                'mess' => 'Delete không thành công'
            ]);
        }

        return response()->json([
            'mess' => 'Delete thành công'
        ]);
    }
}
