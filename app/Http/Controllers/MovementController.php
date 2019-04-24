<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Movement;

class MovementController extends Controller
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
        $movements = Movement::where('deleted_at', '=', null)->paginate(5);
        /* return die($movements); */
        return view('movements', compact('movements'));
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
            'abbreviationCreate' => 'required'
        ]);

        if($validator->fails()) {
            $validator->errors()->add('create', 'some error');
            return redirect('/movements')
                ->withErrors($validator)
                ->withInput();
        } else {
            $movement = new Movement();
            $movement->name = $request->nameCreate;
            $movement->abbreviation = $request->abbreviationCreate;
            $movement->save();
            return redirect('/movements');
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
            'currentMovementUpdate' => 'required|numeric'
        ]);

        if($validator->fails()) {
            $validator->errors()->add('update', 'some error');
            return redirect('/movements')
                ->withErrors($validator)
                ->withInput();
        } else {
            $movement = Movement::findOrFail($request->currentMovementUpdate);
            $movement->name = $request->nameUpdate;
            $movement->abbreviation = $request->abbreviationUpdate;
            $movement->save();
            return redirect('/movements');
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
        Movement::destroy($id);
        return redirect('/movements');
    }
}
