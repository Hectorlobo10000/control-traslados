<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Inventory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Product;
use Illuminate\Support\Facades\Validator;

class InventoryController extends Controller
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
        $products = DB::table('inventories')
        ->join('products', 'inventories.product_id', '=', 'products.id')
        ->select(
            'inventories.id as inventoryId',
            'inventories.movement_id as movementId',
            'inventories.balance',
            'inventories.deleted_at as inventoryDeleted',
            'inventories.branch_office_id as branchOfficeId',
            'products.id as productId',
            'products.name as productName',
            'products.code as productCode',
            'products.enable'
        );

        $inventories = DB::table('movements')
        ->joinSub($products, 'products', function($join) {
            $join->on('products.movementId', '=', 'movements.id');
        })
        ->select(
            'products.inventoryId',
            'products.movementId',
            'products.balance',
            'products.inventoryDeleted',
            'products.branchOfficeId',
            'products.productId',
            'products.productName',
            'products.productCode',
            'products.enable',
            'movements.name as movementName'
        )
        ->where([
            'products.inventoryDeleted' => null,
            'products.movementId' => 1,
            'products.branchOfficeId' => Auth::user()->branch_office_id,
        ])
        ->paginate(5);

        return view('inventories', compact('inventories'));

        
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
        $product = Product::find($request->productCreate);

        if($product != null && $product->enable)
            $request->request->add(['enableProductCreate' => 1]);
        else
            $request->request->add(['enableProductCreate' => 0]);

        $validator = Validator::make($request->all(), [
            'productCreate' => 'required|numeric|exists:products,id',
            'balanceCreate' => 'required|min:1|numeric',
            'enableProductCreate' => 'required|min:1|numeric',
        ]);

        if($validator->fails()) {
            $validator->errors()->add('create', 'some error');
            return redirect('/inventories')
                ->withErrors($validator)
                ->withInput();
        } else {
            $inventory = new Inventory();
            $inventory->product_id = $request->productCreate;
            $inventory->movement_id = 1;
            $inventory->branch_office_id = Auth::user()->branch_office_id;
            $inventory->balance = $request->balanceCreate;
            $inventory->save();
            return redirect('/inventories');
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
            'currentInventoryUpdate' => 'required|numeric',
            'balanceUpdate' => 'required|min:1|numeric',
        ]);

        if($validator->fails()) {
            $validator->errors()->add('update', 'some error');
            return redirect('/inventories')
                ->withErrors($validator)
                ->withInput();
        } else {
            $inventory = Inventory::find($request->currentInventoryUpdate);
            $inventory->balance = $request->balanceUpdate;
            $inventory->save();
            return redirect('/inventories');
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
        Inventory::destroy($id);
        return redirect('/inventories');
    }
}
