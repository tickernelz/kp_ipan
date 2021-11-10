<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Http\Request;

class PegawaiController extends Controller
{
    public function index()
    {
        // Get Data
        $data = Pegawai::with('user')->get();

        return view('kelola.users.pegawai.index', [
            'data' => $data,
        ]);
    }

    public function tambah_index()
    {

        return view('kelola.users.pegawai.tambah', [
            'roles' => $roles,
        ]);
    }

    public function edit_index(int $id)
    {
        // Get Data
        $data = Pegawai::with('user')->find($id);

        return view('kelola.users.pegawai.edit', [
            'data' => $data,
        ]);
    }

    public function tambah(Request $request)
    {
        $request->validate([
            'nip' => 'required|numeric|unique:pegawais',
            'username' => 'required|string|unique:users',
            'nama' => 'required|string',
            'hp' => 'numeric|nullable',
            'password' => 'required|string',
        ]);

        // Kirim Data ke Database
        $user = new User;
        $user->username = $request->input('username');
        $user->password = bcrypt($request->input('password'));
        $user->save();
        $user->assignRole('Pegawai');

        $pegawai = new Pegawai;
        $pegawai->nip = $request->input('nip');
        $pegawai->nama = $request->input('nama');
        $pegawai->hp = $request->input('nama');
        $pegawai->user()->associate($user);
        $pegawai->save();

        return back()->with('success', 'Data Berhasil Ditambahkan!');
    }

    public function edit(Request $request, int $id)
    {
        $data = Pegawai::with('user')->find($id);

        $request->validate([
            'nip' => 'required|numeric|unique:pegawais,nip,'.$data->id,
            'username' => 'required|string|unique:users,username,'.$data->user->id,
            'nama' => 'required|string',
            'hp' => 'numeric|nullable',
            'password' => 'required|string',
        ]);

        // Edit Data
        $data->nip = $request->input('nip');
        $data->nama = $request->input('nama');
        $data->hp = $request->input('hp');
        $data->user->username = $request->input('username');
        if ($data->user->password !== $request->input('password')) {
            $data->user->password = bcrypt($request->input('password'));
        }
        $data->user->save();
        $data->save();
        $data->user->assignRole('Pegawai');

        return back()->with('success', 'Data Berhasil Diubah!');
    }

    public function hapus(int $id)
    {
        Pegawai::where('user_id', $id)->delete();
        User::find($id)->delete();

        return redirect()->route('index.user.pegawai');
    }
}
