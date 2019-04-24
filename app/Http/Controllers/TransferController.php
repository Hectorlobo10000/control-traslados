<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\BranchOffice;
use App\User;
use App\TransferState;
use Illuminate\Support\Facades\Validator;
use App\Transfer;
use Illuminate\Support\Facades\Auth;

class TransferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        
        $branchOffices = DB::table('transfers')
        ->join('branch_offices', 'transfers.branch_office_receive_id', '=', 'branch_offices.id')
        ->select(
            'transfers.id as transferId',
            'transfers.branch_office_receive_id as branchReceiveId',
            'transfers.user_receive_id as userReceiveId',
            'transfers.transfer_state_id as stateId',
            'transfers.user_send_id as userSendId',
            'transfers.branch_office_send_id as branchSendId',
            'branch_offices.name as branchName',
            'transfers.deleted_at as transferDeleted'
        );

        $transfersState = DB::table('transfer_states')
        ->joinSub($branchOffices, 'branchOffices', function($join) {
            $join->on('branchOffices.stateId', '=', 'transfer_states.id');
        })
        ->select(
            'branchOffices.transferId',
            'branchOffices.branchReceiveId',
            'branchOffices.userReceiveId',
            'branchOffices.stateId',
            'branchOffices.userSendId',
            'branchOffices.branchSendId',
            'branchOffices.branchName',
            'transfer_states.name as stateName',
            'branchOffices.transferDeleted'
        );

        $boxes = DB::table('users')
        ->joinSub($transfersState, 'transfersState', function($join) {
            $join->on('users.id', '=', 'transfersState.userReceiveId');
        })
        ->select(
            'transfersState.transferId',
            'transfersState.branchReceiveId',
            'transfersState.userReceiveId',
            'transfersState.stateId',
            'transfersState.userSendId',
            'transfersState.branchSendId',
            'transfersState.branchName',
            'transfersState.stateName', 
            'users.name as userName',
            'transfersState.transferDeleted'
        )->where([
            'transfersState.transferDeleted' => null,
        ])
        ->paginate(5);

        /* boxes */

        $boxesT = DB::table('users')
        ->joinSub($transfersState, 'transfersState', function($join) {
            $join->on('users.id', '=', 'transfersState.userReceiveId');
        })
        ->select(
            'transfersState.transferId',
            'transfersState.branchReceiveId',
            'transfersState.userReceiveId',
            'transfersState.stateId',
            'transfersState.userSendId',
            'transfersState.branchSendId',
            'transfersState.branchName',
            'transfersState.stateName', 
            'users.name as userName',
            'transfersState.transferDeleted'
        );

        $transfersUser = DB::table('transfer_details')
        ->joinSub($boxesT, 'boxes', function($join) {
            $join->on('boxes.transferId', '=', 'transfer_details.transfer_id');
        })
        ->select(
            'boxes.transferId',
            'boxes.branchReceiveId',
            'boxes.userReceiveId',
            'boxes.stateId',
            'boxes.userSendId',
            'boxes.branchSendId',
            'boxes.branchName',
            'boxes.stateName', 
            'boxes.userName',
            'boxes.transferDeleted',
            'transfer_details.id as detailId',
            'transfer_details.box_id as boxId'
        )
        ->where([
            'boxes.stateId' => 1,
            'boxes.transferDeleted' => null,
        ])
        ->paginate(5);

        $branchOfficesR = BranchOffice::all();
        $usersR = User::where([
            [ 'enable', '=', true ],
            [ 'id', '<>', '1' ]
            ])->get();
        $states = TransferState::all();

       /*  return dd($boxes); */
        
        return view('transfers', compact('boxes', 'transfersUser', 'branchOfficesR', 'usersR', 'states'));
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
            'userR' => 'required|min:1|numeric',
        ]);

        if($validator->fails()) {
            $validator->errors()->add('create', 'error');
            return redirect('/transfers')
                ->withErrors($validator)
                ->withInput();
        } else {
            $transfer = new Transfer();
            $transfer->transfer_state_id = 1;
            $transfer->user_receive_id = $request->userR;
            $transfer->branch_office_receive_id = User::find($request->userR)->branch_office_id;
            $transfer->user_send_id = Auth::user()->id;
            $transfer->branch_office_send_id = Auth::user()->branch_office_id;
            $transfer->save();
            return redirect('/transfers');
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
    }
}
