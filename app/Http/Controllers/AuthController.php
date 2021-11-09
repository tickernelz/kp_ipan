<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\User;
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

        if (Auth::check() && Auth::user()->hasAnyRole(['Anggota'])) {
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

    public function daftar_index()
    {
        return view('auth.daftar', [
        ]);
    }

    public function daftar(Request $request)
    {
        $request->validate([
            'nik' => 'required|numeric|unique:anggotas',
            'username' => 'required|string|unique:users',
            'nama' => 'required|string',
            'email' => 'email|nullable',
            'hp' => 'numeric|nullable',
            'password' => 'required|string',
        ]);

        // Kirim Data ke Database
        $user = new User;
        $user->username = $request->input('username');
        $user->password = bcrypt($request->input('password'));
        $user->save();
        $user->assignRole('Anggota');

        $anggota = new Anggota;
        $anggota->nik = $request->input('nik');
        $anggota->nama = $request->input('nama');
        $anggota->email = $request->input('email');
        $anggota->hp = $request->input('hp');
        $anggota->user()->associate($user);
        $anggota->save();

        return back()->with('success', 'Data Berhasil Ditambahkan!');
    }

    public function logout()
    {
        Auth::logout(); // menghapus session yang aktif

        return redirect()->route('auth.login');
    }
}
