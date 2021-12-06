<?php

namespace App\Http\Controllers;

use App\Models\KategoriBuku;
use App\Models\Rak;
use Illuminate\Http\Request;

class RakController extends Controller
{
    public function index()
    {
        // Get Data
        $data = Rak::with('kategori_buku')->get();

        return view('kelola.rak.index', [
            'data' => $data,
        ]);
    }

    public function tambah_index()
    {
        return view('kelola.rak.tambah', [
        ]);
    }

    public function edit_index(int $id)
    {
        // Get Data
        $data = Rak::with('kategori_buku')->find($id);

        return view('kelola.rak.edit', [
            'data' => $data,
        ]);
    }

    public function tambah(Request $request)
    {
        $request->validate([
            'nomor' => 'required|numeric|unique:raks',
        ]);

        // Kirim Data ke Database
        $data = new Rak;
        $data->nomor = $request->input('nomor');
        $data->save();

        return back()->with('success', 'Data Berhasil Ditambahkan!');
    }

    public function edit(Request $request, int $id)
    {
        $data = Rak::find($id);

        $request->validate([
            'nomor' => 'required|numeric|unique:raks,nomor,'.$data->id,
        ]);

        // Edit Data
        $data->nomor = $request->input('nomor');
        $data->save();

        return back()->with('success', 'Data Berhasil Diubah!');
    }

    public function hapus(int $id)
    {
        Rak::find($id)->delete();
        foreach (KategoriBuku::where('rak_id', $id)->get() as $kategori) {
            $kategori->delete();
        }

        return redirect()->route('index.rak');
    }
}
