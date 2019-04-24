<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Department;
use App\City;
use App\Address;
use App\BranchOffice;

class BranchOfficesController extends Controller
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
        $branchOffices = DB::table('branch_offices')
        ->join('addresses', 'branch_offices.address_id', '=', 'addresses.id')
        ->select(
            'branch_offices.id', 
            'branch_offices.name', 
            'branch_offices.abbreviation', 
            'addresses.description as address', 
            'addresses.city_id',
            'addresses.id as addressId',
            'branch_offices.deleted_at'
        );

        $branchOfficesCities = DB::table('cities')
        ->joinSub($branchOffices, 'branch_offices', function($join) {
            $join->on('cities.id', '=', 'branch_offices.city_id');
        })
        ->select(
            'branch_offices.id', 
            'branch_offices.name', 
            'branch_offices.abbreviation', 
            'branch_offices.address', 
            'cities.name as city', 
            'cities.department_id', 
            'branch_offices.city_id',
            'branch_offices.addressId',
            'branch_offices.deleted_at'
        );

        $branchOfficesDepartments = DB::table('departments')
        ->joinSub($branchOfficesCities, 'cities', function($join) {
            $join->on('departments.id', '=', 'cities.department_id');
        })
        ->select(
            'cities.id', 
            'cities.name', 
            'cities.abbreviation', 
            'cities.address', 
            'cities.city', 
            'departments.name as department',
            'cities.city_id',
            'cities.addressId',
            'cities.deleted_at'
        )
        ->where('cities.deleted_at', '=', null)
        ->paginate(5);

        $cities = DB::table('cities')
        ->join('departments', 'cities.department_id', '=', 'departments.id')
        ->select('cities.id', 'cities.name as nameCity', 'departments.name as nameDepartment')
        ->get();

        return view('branchOffices', compact('branchOfficesDepartments', 'cities'));
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
            'abbreviationCreate' => 'required',
            'cityCreate' => 'required|min:1|numeric',
            'addressCreate' => 'required|min:20',
        ]);

        if($validator->fails()) {
            $validator->errors()->add('create', 'some error');
            return redirect('/branch-offices')
                ->withErrors($validator)
                ->withInput();
        } else {
            $address = new Address();
            $address->description = $request->addressCreate;
            $address->city_id = $request->cityCreate;
            $address->save();

            $branchOffice = new BranchOffice();
            $branchOffice->name = $request->nameCreate;
            $branchOffice->abbreviation = $request->abbreviationCreate;
            $branchOffice->address_id = $address->id;
            $branchOffice->save();
            return redirect('branch-offices');
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
            'abbreviationUpdate' => 'required',
            'addressUpdate' => 'required|min:20',
            'currentBranchOfficeUpdate' => 'required|numeric',
            'currentAddressUpdate' => 'required|numeric'
        ]);

        if($validator->fails()) {
            $validator->errors()->add('update', 'some error');
            return redirect('/branch-offices')
                ->withErrors($validator)
                ->withInput();
        } else {
            $address = Address::findOrFail($request->currentAddressUpdate);
            $address->description = $request->addressUpdate;
            $address->save();

            $branchOffice = BranchOffice::findOrFail($request->currentBranchOfficeUpdate);
            $branchOffice->name = $request->nameUpdate;
            $branchOffice->abbreviation = $request->abbreviationUpdate;
            $branchOffice->save();
            return redirect('branch-offices');
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
        BranchOffice::destroy($id);
        return redirect('/branch-offices');
    }
}
