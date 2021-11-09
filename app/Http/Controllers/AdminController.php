<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\User;
use Crypt;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    public function index()
    {
        // Get Data
        $data = Admin::with('user')->get();

        return view('kelola.users.admin.index', [
            'data' => $data,
        ]);
    }

    public function tambah_index()
    {
        // Get Data
        $roles = Role::whereIn('name', ['Super Admin', 'Admin'])->get();

        return view('kelola.users.admin.tambah', [
            'roles' => $roles,
        ]);
    }

    public function edit_index(int $id)
    {
        // Get Data
        $data = Admin::with('user')->find($id);
        $roles = Role::whereIn('name', ['Super Admin', 'Admin'])->get();

        return view('kelola.users.admin.edit', [
            'data' => $data,
            'roles' => $roles,
        ]);
    }

    public function tambah(Request $request)
    {
        $request->validate([
            'nip' => 'required|numeric|unique:admins',
            'username' => 'required|string|unique:users',
            'nama' => 'required|string',
            'peran' => 'required|string',
            'hp' => 'numeric|nullable',
            'password' => 'required|string',
        ]);

        // Get Request
        $get_status = Crypt::decrypt($request->input('peran'));

        // Kirim Data ke Database
        $user = new User;
        $user->username = $request->input('username');
        $user->password = bcrypt($request->input('password'));
        $user->save();
        $user->assignRole($get_status);

        $admin = new Admin;
        $admin->nip = $request->input('nip');
        $admin->nama = $request->input('nama');
        $admin->hp = $request->input('nama');
        $admin->user()->associate($user);
        $admin->save();

        return back()->with('success', 'Data Berhasil Ditambahkan!');
    }

    public function edit(Request $request, int $id)
    {
        $data = Admin::with('user')->find($id);

        $request->validate([
            'nip' => 'required|numeric|unique:admins,nip,'.$data->id,
            'username' => 'required|string|unique:users,username,'.$data->user->id,
            'nama' => 'required|string',
            'peran' => 'required|string',
            'hp' => 'numeric|nullable',
            'password' => 'required|string',
        ]);

        // Get Request
        $get_status = Crypt::decrypt($request->input('peran'));

        // Edit Data
        $data->nip = $request->input('nip');
        $data->nama = $request->input('nama');
        $data->hp = $request->input('hp');
        $data->user->username = $request->input('username');
        if ($data->user->password !== bcrypt($request->input('password'))) {
            $data->user->password = bcrypt($request->input('password'));
        }
        $data->user->save();
        $data->save();
        $data->user->assignRole($get_status);

        return back()->with('success', 'Data Berhasil Diubah!');
    }

    public function hapus(int $id)
    {
        Admin::where('user_id', $id)->delete();
        User::find($id)->delete();

        return redirect()->route('index.user.admin');
    }
}
