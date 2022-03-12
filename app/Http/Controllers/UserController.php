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

    public function logout(Request $request) {
        Session::flush();
        Auth::logout();
  
        return Redirect('/');
    }

    public function user(Type $var = null)
    {
        return view('pages.user');
    }

}
