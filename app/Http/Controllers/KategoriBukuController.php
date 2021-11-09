<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\KategoriBuku;
use Illuminate\Http\Request;

class KategoriBukuController extends Controller
{
    public function index()
    {
        // Get Data
        $data = KategoriBuku::get();

        return view('kelola.kategori.index', [
            'data' => $data,
        ]);
    }

    public function tambah_index()
    {
        return view('kelola.kategori.tambah', [
        ]);
    }

    public function edit_index(int $id)
    {
        // Get Data
        $data = KategoriBuku::find($id);

        return view('kelola.kategori.edit', [
            'data' => $data,
        ]);
    }

    public function tambah(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|unique:kategori_bukus',
        ]);

        // Kirim Data ke Database
        $data = new KategoriBuku;
        $data->nama = $request->input('nama');
        $data->save();

        return back()->with('success', 'Data Berhasil Ditambahkan!');
    }

    public function edit(Request $request, int $id)
    {
        $data = KategoriBuku::find($id);

        $request->validate([
            'nama' => 'required|string|unique:kategori_bukus,nama,'.$data->id,
        ]);

        // Edit Data
        $data->nama = $request->input('nama');
        $data->save();

        return back()->with('success', 'Data Berhasil Diubah!');
    }

    public function hapus(int $id)
    {
        KategoriBuku::find($id)->delete();
        foreach (Buku::where('kategori_buku_id', $id)->get() as $buku) {
            $buku->delete();
        }

        return redirect()->route('index.kategori');
    }
}
