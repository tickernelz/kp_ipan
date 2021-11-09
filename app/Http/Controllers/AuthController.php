<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Session;

class AuthController extends Controller
{
    public function formlogin()
    {
        if (Auth::check() && Auth::user()->hasAnyRole(['Super Admin', 'Admin'])) { // true sekalian session field di users nanti bisa dipanggil via Auth
            //Login Success
            return redirect()->route('admin.home');
        }

        if (Auth::check() && Auth::user()->hasAnyRole(['Siswa'])) {
            //Login Success
            return redirect()->route('index.pinjam');
        }

        return view('auth.new-login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string|exists:users,username',
            'password' => 'required|string',
        ]);

        $data = [
            'username' => $request->input('username'),
            'password' => $request->input('password'),
        ];
        $remember_me = $request->has('remember');

        Auth::attempt($data, $remember_me);

        if (Auth::check() && Auth::user()->hasAnyRole(['Super Admin', 'Admin'])) { // true sekalian session field di users nanti bisa dipanggil via Auth
            //Login Success
            return redirect()->route('admin.home');
        }

        if (Auth::check() && Auth::user()->hasAnyRole(['Siswa'])) {
            //Login Success
            return redirect()->route('index.pinjam');
        }

        // false
        Session::flash('error', 'Username atau password salah');

        return redirect()->route('auth.login');
    }

    public function logout()
    {
        Auth::logout(); // menghapus session yang aktif

        return redirect()->route('auth.login');
    }
}
