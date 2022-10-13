<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRequestProduct;
use App\Models\Product;
use Illuminate\Http\Request;


class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $products = Product::simple()->defaultSort()->params($request->all())->paginate(1);
        // dd($products);
        if($request->ajax()){

            return view('frontend.ajaxProduct',compact('products'))->render();
        }

        return view('frontend.product',compact('products'));
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
        //
        
        // dd($request->all());

        $nameImage = null;
        
        $autoIdProduct = strtoupper(
            substr($request->name,0,1)
            ).str_pad(
                Product::count()+1,10-strlen(Product::count()+1),'0',STR_PAD_LEFT
            );

        if($request->hasFile('fileImage')) {
            $nameImage = time()."_".$request->file('fileImage')->getClientOriginalName();
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
        
        if($store){
            $products = Product::simple()->defaultSort()->params($request->all())->paginate(1);
            $html = view('frontend.ajaxProduct',compact('products'))->render();
        }
        
        return response()->json([
            asset("images/$nameImage"),
            201,
            'message' => asset("images/$nameImage") ? 'Image saved' : 'Image failed to save',
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
    public function update(Request $request, $id)
    {
        //
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
        
        if(!$delete){
            return response()->json([
                'mess' => 'Delete không thành công'
            ]);
        }

        return response()->json([
            'mess' => 'Delete thành công'
        ]);
    }
}
