<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::where('deleted_at', '=', null)->paginate(5);
        return view('products', compact('products'));
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
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nameCreate' => 'required',
            'codeCreate' => 'required|min:13|unique:products,code',
            'descriptionCreate' => 'required',
        ]);

        if($validator->fails()) {
            $validator->errors()->add('create', 'some error');
            return redirect('/products')
                ->withErrors($validator)
                ->withInput();
        } else {
            $product = new Product();
            $product->name = $request->nameCreate;
            $product->code = $request->codeCreate;
            $product->enable = $request->has('enableCreate') ? true : false;
            $product->description = $request->descriptionCreate;

            $product->save();
            return redirect('/products');
        }
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
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nameUpdate' => 'required',
            'descriptionUpdate' => 'required',
            'currentProductUpdate' => 'required|numeric'
        ]);

        if($validator->fails()) {
            $validator->errors()->add('update', 'some error');
            return redirect('/products')
                ->withErrors($validator)
                ->withInput();
        } else {
            $product = Product::findOrFail($request->currentProductUpdate);
            $product->name = $request->nameUpdate;
            $product->enable = $request->has('enableUpdate') ? true : false;
            $product->description = $request->descriptionUpdate;

            $product->save();
            return redirect('/products');
        
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Product::destroy($id);
        return redirect('/products');
    }
}
