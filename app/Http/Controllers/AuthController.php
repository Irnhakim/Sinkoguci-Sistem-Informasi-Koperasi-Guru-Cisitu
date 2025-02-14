<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function index()
    {
        $title = 'Masuk';
        
        return view('login', compact('title'));
    }

    public function isLogin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        if(auth()->guard('petugas')->attempt($credentials)){
            $user = auth()->guard('petugas')->user();
            return response()->json(['status' => 'success', 'message' => 'Login berhasil, anda akan dialihkan ke halaman dashboard.', 'redirect' => route($user->level.'.dashboard')]);
           
        }else {
            return response()->json(['status' => 'error', 'message' => 'Login gagal, silahkan cek email dan password anda.']);
        }
    }

    public function logout()
    {
       if(auth()->guard('petugas')->check()){
           auth()->guard('petugas')->logout();
       }
       return redirect(route('login'))->with('success', 'Anda berhasil keluar.');
    }

    public function lupaPassword()
    {
        $title = 'Lupa Password';
        return view('lupa-password', compact('title'));
    }
}
