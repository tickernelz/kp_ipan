<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class AnggotaController extends Controller
{
    public function index()
    {
        // Get Data
        $data = Anggota::with('user')->get();

        return view('kelola.users.anggota.index', [
            'data' => $data,
        ]);
    }

    public function tambah_index()
    {
        // Get Data
        $roles = Role::whereIn('name', ['Anggota'])->get();

        return view('kelola.users.anggota.tambah', [
            'roles' => $roles,
        ]);
    }

    public function edit_index(int $id)
    {
        // Get Data
        $data = Anggota::with('user')->find($id);
        $roles = Role::whereIn('name', ['Anggota'])->get();

        return view('kelola.users.anggota.edit', [
            'data' => $data,
            'roles' => $roles,
        ]);
    }

    public function tambah(Request $request)
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

    public function edit(Request $request, int $id)
    {
        $data = Anggota::with('user')->find($id);

        $request->validate([
            'nik' => 'required|numeric|unique:anggotas,nik,'.$data->id,
            'username' => 'required|string|unique:users,username,'.$data->user->id,
            'nama' => 'required|string',
            'email' => 'email|nullable',
            'hp' => 'numeric|nullable',
            'password' => 'required|string',
        ]);

        // Edit Data
        $data->nik = $request->input('nik');
        $data->nama = $request->input('nama');
        $data->email = $request->input('email');
        $data->hp = $request->input('hp');
        $data->user->username = $request->input('username');
        if ($data->user->password !== $request->input('password')) {
            $data->user->password = bcrypt($request->input('password'));
        }
        $data->user->save();
        $data->save();
        $data->user->assignRole('Anggota');

        return back()->with('success', 'Data Berhasil Diubah!');
    }

    public function hapus(int $id)
    {
        Anggota::where('user_id', $id)->delete();
        User::find($id)->delete();

        return redirect()->route('index.user.anggota');
    }
}
