<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\KategoriBuku;
use App\Models\Rak;
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
        $rak = Rak::get();

        return view('kelola.kategori.tambah', [
            'rak' => $rak,
        ]);
    }

    public function edit_index(int $id)
    {
        // Get Data
        $data = KategoriBuku::find($id);
        $rak = Rak::get();

        return view('kelola.kategori.edit', [
            'data' => $data,
            'rak' => $rak,
        ]);
    }

    public function tambah(Request $request)
    {
        $request->validate([
            'rak' => 'required|numeric',
            'nama' => 'required|string|unique:kategori_bukus',
        ]);

        // Kirim Data ke Database
        $data = new KategoriBuku;
        $data->rak_id = $request->input('rak');
        $data->nama = $request->input('nama');
        $data->save();

        return back()->with('success', 'Data Berhasil Ditambahkan!');
    }

    public function edit(Request $request, int $id)
    {
        $data = KategoriBuku::find($id);

        $request->validate([
            'rak' => 'required|numeric',
            'nama' => 'required|string|unique:kategori_bukus,nama,'.$data->id,
        ]);

        // Edit Data
        $data->rak_id = $request->input('rak');
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
