<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Validation\Rules\Password;
use App\Http\Resources\APIResource;
use App\Models\User;
use App\Models\Store;
use App\Models\Verify;
use App\Traits\StoreTrait;
use App\Mail\verifyMail;
use Validator;
use Mail;

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
        $user = User::create($data);

        // create verify user and send email
        $verifyUser = Verify::create([
            'user_id' => $user->id,
            'token' => sha1(time())
        ]);

        $user['token'] = $verifyUser->token;
        Mail::to($user->email)->send(new VerifyMail($user));

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

        // create verify user and send email
        $verifyUser = Verify::create([
            'user_id' => $user->id,
            'token' => sha1(time())
        ]);
        \Mail::to($user->email)->send(new VerifyMail($user));


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

    public function verifyUser($token)
    {
        $verifyUser = Verify::where('token', $token)->first();

        if(isset($verifyUser) ){
            
            $user = User::find($verifyUser->user_id);
            if($user->email_verified_at == null && $user) {
            
                $user->email_verified_at = date("Y-m-d");
                $user->save();
                $message = "Your e-mail is verified. You can now login.";
                $status = true;

            } else {
            
                $message = "Your e-mail is already verified. You can now login.";
                $status = true;

            }

        } else {
            $message = "Sorry your email cannot be identified.";
            $status = false;
        }

        return new APIResource($status, $message, []);
    }

}
