<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Hash;
use Session;
use App\Models\User;

class UserController extends Controller
{
    public function index(){
        return view('pages.login');
    }

    public function login(Request $request){

        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
   
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            
            $user = Auth::user();
            if ($user->role == 'Admin') {
                Session::put('user', $user);
                return redirect()->route('dashboard');
            }else{
                return redirect()->route('user')->with('messageDanger','Anda tidak diberikan akses untuk masuk');
            }
            
        }else {
            
            return redirect()->route('user')->with('messageInfo','Email atau password salah');

        }

    }

    public function logout() {
        Session::flush();
        Auth::logout();
  
        return Redirect('/');
    }

    public function user()
    {
        return view('pages.user');
    }

    public function verifyUser($token)
    {
        $verifyUser = Verify::where('token', $token)->first();

        if(isset($verifyUser) ){
            
            $user = User::find($verifyUser->user_id);
            if ($user != null) {
                
                if ($user->email_verified_at == null) {
                    
                    $user->email_verified_at = date("Y-m-d");
                    $user->save();
                    $status = true;  

                } 
                
            }

        } else {
            $status = false;
        }

        $data = ['status' => $status];
        return view('pages.after_verify',$data);
    }

}

