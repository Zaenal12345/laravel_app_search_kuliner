<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Validation\Rules\Password;
use App\Http\Resources\APIResource;
use App\Models\User;
use App\Models\Store;
use Validator;
use App\Traits\StoreTrait;

class UserController extends Controller
{
    use StoreTrait;

    public function index(){

        $user = User::orderBy('id','DESC')->get();
        return new APIResource(true, 'List of user', $user);
    }

    public function registerUser(Request $request){

        //define validation rules
        $validator = Validator::make($request->all(), [
            'name'      => 'required',
            'email'     => 'required|unique:users|email',
            'phone'     => 'required|numeric',
            'password'  => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $data = [
            'name'      => $request->name,
            'email'     => $request->email,
            'phone'     => $request->phone,
            'role'      => 'User',
            'password'  => bcrypt($request->password),
        ];

        // create user
        User::create($data);

        //return response
        return new APIResource(true, 'Registration success', []);
    }

    public function registerStoreOwner(Request $request){

        //define validation rules
        $validator = Validator::make($request->all(), [
            'name'      => 'required',
            'email'     => 'required|unique:users|email',
            'phone'     => 'required|numeric',
            'password'  => 'required',
            'store_name'  => 'required',
            'address'  => 'required',
            'latitude'  => 'required',
            'longitude'  => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $data_user = [
            'name'      => $request->name,
            'email'     => $request->email,
            'phone'     => $request->phone,
            'role'      => 'Store Owner',
            'password'  => bcrypt($request->password),
        ];

        // create user
        $user = User::create($data_user);
        // create store from trait
        $this->createStore($request, $user->id);


        return new APIResource(true, 'Registration success', []);
    }

    public function registerAdmin(Request $request){

        //define validation rules
        $validator = Validator::make($request->all(), [
            'name'      => 'required',
            'email'     => 'required|unique:users|email',
            'phone'     => 'required|numeric',
            'password'  => 'required'
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $data_user = [
            'name'      => $request->name,
            'email'     => $request->email,
            'phone'     => $request->phone,
            'role'      => 'Admin',
            'password'  => bcrypt($request->password),
        ];

        // create user
        $user = User::create($data_user);

        //return response
        return new APIResource(true, 'Registration success', []);
    }

}
