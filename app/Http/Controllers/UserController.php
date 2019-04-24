<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\Role;
use App\BranchOffice;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
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
        $users = DB::table('users')
            ->join('branch_offices', 'users.branch_office_id', '=', 'branch_offices.id')
            ->join('roles', 'users.role_id', '=', 'roles.id')
            ->select('users.id', 
                'users.name', 
                'users.avatar', 
                'branch_offices.name as nameBranchOffice', 
                'users.email', 
                'users.enable', 
                'users.role_id as roleId', 
                'users.branch_office_id as branchOfficeId', 
                'roles.name as roleName', 
                'users.password')
            ->where('users.deleted_at', '=', null)
            ->paginate(5);

        /* $roles = Role::where('id', '<>', '1')->get();
        $branchOffices = BranchOffice::where('id', '<>', '1')->get(); */
        $roles = Role::all();
        $branchOffices = BranchOffice::all();
        return view('users', compact('users', 'roles', 'branchOffices'));
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

        /* $messages = [
            'required' => 'El :attribute es requerido',
            'string' => 'El :attribute debe ser una cadena de caracteres',
            'email' => 'El :attribute no es valido',
            'image' => 'El :attribute no es valida',
            'mimes' => 'El :attribute debe ser en formato'. ':'. 'jpeg, png, jpg, gif, svg',
            'max' => 'El :attribute debe ser un maximo de 2MB',
        ]; 
            Validator::make($inputs, $rules, $messages);
        */

        $validator = Validator::make($request->all(), [
            'nameCreate' => 'required',
            'emailCreate' => 'required|email|unique:users,email',
            'avatarCreate' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'roleCreate' => 'required|min:1|numeric',
            'branchOfficeCreate' => 'required|min:1|numeric',
        ]);

        if($validator->fails()) {
            $validator->errors()->add('create', 'Some error');
            return redirect('/users')
                ->withErrors($validator)
                ->withInput();
        } else {
            $user = new User();
            $user->name = $request->nameCreate;
            $user->email = $request->emailCreate;
            $avatarName =  $request->has('avatarCreate') ? now(). '.'.request()->avatarCreate->getClientOriginalExtension() : 'avatar.svg';
            $user->avatar = $avatarName;
            $user->password = Hash::make(str_replace(' ', '', $request->nameCreate));
            $user->enable = $request->has('enableCreate') ? true : false;
            $user->role_id = $request->roleCreate;
            $user->branch_office_id = $request->branchOfficeCreate;

            if($request->has('avatarCreate')) 
                $request->avatarCreate->storeAs('avatars', $avatarName);

            $user->save();
            return redirect('/users');
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
            'avatarUpdate' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'roleUpdate' => 'min:1|numeric',
            'branchOfficeUpdate' => 'min:1|numeric',
            'currentUserUpdate' => 'required|numeric'
        ]);

        if($validator->fails()) {
            $validator->errors()->add('update', 'Some error');
            return redirect('/users')
                ->withErrors($validator)
                ->withInput();
        } else {
            $user = User::findOrFail($request->currentUserUpdate);
            $user->name = $request->nameUpdate;

            if($request->has('avatarUpdate')) {
                $avatarName = now(). '.'.request()->avatarCreate->getClientOriginalExtension();
                $user->avatar = $avatarName;
            }

            $user->enable = $request->has('enableUpdate') ? true : false;
            $user->role_id = $request->roleUpdate;
            $user->branch_office_id = $request->branchOfficeUpdate;

            $user->save();
            return redirect('/users');
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
        User::destroy($id);
        return redirect('/users');
    }
}
