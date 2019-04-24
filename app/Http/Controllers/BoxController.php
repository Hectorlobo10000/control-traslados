<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Box;
use App\BoxState;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\BoxDetail;
use App\Product;
use App\Inventory;
use Illuminate\Support\Facades\Auth;

class BoxController extends Controller
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
        $boxes = DB::table('boxes')
        ->join('box_states', 'boxes.box_state_id', '=', 'box_states.id')
        ->select('boxes.id', 'boxes.code', 'boxes.box_state_id', 'box_states.name as state')
        ->paginate(5);

        $boxStates = BoxState::all();

        $productForBox = DB::table('boxes')
        ->join('box_details', 'boxes.id', '=', 'box_details.box_id')
        ->select(
            'boxes.id as boxId', 
            'boxes.code as boxCode', 
            'box_details.inventory_id as inventoryId',
            'box_details.id as boxDetailId'
        );

        $inventories = DB::table('inventories')
        ->joinSub($productForBox, 'productsForBox', function($join) {
            $join->on('inventories.id', '=', 'productsForBox.inventoryId');
        })
        ->select(
            'productsForBox.boxId',
            'productsForBox.boxCode',
            'productsForBox.inventoryId',
            'productsForBox.boxDetailId',
            'inventories.product_id as productId',
            'inventories.movement_id as movementId',
            'inventories.deleted_at'
        );

        $firstBox = Box::first();

        $products = DB::table('products')
        ->joinSub($inventories, 'inventories', function($join) {
            $join->on('products.id', '=', 'inventories.productId');
        })
        ->select(
            'inventories.boxId',
            'inventories.boxCode',
            'inventories.inventoryId',
            'inventories.productId',
            'inventories.movementId',
            'inventories.deleted_at',
            'inventories.boxDetailId',
            'products.id as productId',
            'products.code as productCode',
            'products.name as productName'
        )
        ->where([
            'inventories.deleted_at' => null,
            'inventories.boxId' => $firstBox->id,
            'inventories.movementId' => 1,
        ])
        ->paginate(5);
        return view('boxes', compact('boxes', 'boxStates', 'products', 'firstBox'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $product = Product::findOrFail($request->productAdd);
        $request->request->add(['enableProductAdd' => $product->enable]);

        $inventory = Inventory::where([
            'branch_office_id' => Auth::user()->branch_office_id,
            'product_id' => $request->productAdd,
            'deleted_at' => null,
        ])
        ->get();

        if($inventory->isEmpty())
            $request->request->add(['productInBranchOffice' => 0]);
        else
            $request->request->add(['productInBranchOffice' => 1]);


        $validator = Validator::make($request->all(), [
            'currentBoxAdd' => 'required|min:1|numeric|exists:boxes,id',
            'productAdd' => 'required|min:1|numeric|exists:inventories,id',
            'enableProductAdd' => 'min:1|numeric',
            'productInBranchOffice' => 'min:1|numeric'
        ]);

        if($validator->fails()) {
            $validator->errors()->add('add', 'some error');
            return redirect('/boxes')
                ->withErrors($validator)
                ->withInput();
        } else {
            $boxDetail = new BoxDetail();
            $boxDetail->box_id = $request->currentBoxAdd;
            $boxDetail->inventory_id = $inventory->first()->id;
            $boxDetail->save();
            return $this->show($request->currentBoxAdd);
            /* return dd($request->all()); */
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $box = new Box();
        $box->code = time();
        $box->box_state_id = 1;
        $box->save();
        return redirect('/boxes');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $boxes = DB::table('boxes')
        ->join('box_states', 'boxes.box_state_id', '=', 'box_states.id')
        ->select('boxes.id', 'boxes.code', 'boxes.box_state_id', 'box_states.name as state')
        ->paginate(5);

        $boxStates = BoxState::all();

        $productForBox = DB::table('boxes')
        ->join('box_details', 'boxes.id', '=', 'box_details.box_id')
        ->select(
            'boxes.id as boxId', 
            'boxes.code as boxCode', 
            'box_details.inventory_id as inventoryId',
            'box_details.id as boxDetailId'
        );

        $inventories = DB::table('inventories')
        ->joinSub($productForBox, 'productsForBox', function($join) {
            $join->on('inventories.id', '=', 'productsForBox.inventoryId');
        })
        ->select(
            'productsForBox.boxId',
            'productsForBox.boxCode',
            'productsForBox.inventoryId',
            'productsForBox.boxDetailId',
            'inventories.product_id as productId',
            'inventories.movement_id as movementId',
            'inventories.deleted_at'
        );

        $products = DB::table('products')
        ->joinSub($inventories, 'inventories', function($join) {
            $join->on('products.id', '=', 'inventories.productId');
        })
        ->select(
            'inventories.boxId',
            'inventories.boxCode',
            'inventories.inventoryId',
            'inventories.productId',
            'inventories.movementId',
            'inventories.deleted_at',
            'inventories.boxDetailId',
            'products.id as productId',
            'products.code as productCode',
            'products.name as productName'
        )
        ->where([
            'inventories.deleted_at' => null,
            'inventories.boxId' => $id,
            'inventories.movementId' => 1,
        ])
        ->paginate(5);

        $firstBox = Box::find($id);

        return view('boxes', compact('boxes', 'boxStates', 'products', 'firstBox'));
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
            'currentBoxUpdate' => 'required',
            'boxStateUpdate' => 'required|min:1|numeric',
        ]);

        if($validator->fails()) {
            $validator->errors()->add('updateBox', 'some error');
            return redirect('/boxes')
                ->withErrors($validator)
                ->withInput();
        } else {
            $box = Box::findOrFail($request->currentBoxUpdate);
            $box->box_state_id = $request->boxStateUpdate;
            $box->save();
            return redirect('/boxes');
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
        BoxDetail::destroy($id);
        return redirect('/boxes');
    }
}
