<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\KategoriBuku;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    public function index()
    {
        // Get Data
        $data = Buku::with('kategori_buku')->get();

        return view('kelola.buku.index', [
            'data' => $data,
        ]);
    }

    public function tambah_index()
    {
        // Get Data
        $kategori = KategoriBuku::get();

        return view('kelola.buku.tambah', [
            'kategori' => $kategori,
        ]);
    }

    public function edit_index(int $id)
    {
        // Get Data
        $data = Buku::with('kategori_buku')->find($id);
        $kategori = KategoriBuku::get();

        return view('kelola.buku.edit', [
            'data' => $data,
            'kategori' => $kategori,
        ]);
    }

    public function tambah(Request $request)
    {
        $request->validate([
            'isbn' => 'required|string|unique:bukus',
            'judul' => 'required|string',
            'pengarang' => 'string|nullable',
            'penerbit' => 'string|nullable',
            'kategori' => 'string|nullable',
        ]);

        // Kirim Data ke Database
        $data = new Buku;
        $data->isbn = $request->input('isbn');
        $data->judul = $request->input('judul');
        $data->pengarang = $request->input('pengarang');
        $data->penerbit = $request->input('penerbit');
        $data->kategori_buku_id = $request->input('kategori');
        $data->save();

        return back()->with('success', 'Data Berhasil Ditambahkan!');
    }

    public function edit(Request $request, int $id)
    {
        $data = Buku::find($id);

        $request->validate([
            'isbn' => 'required|string|unique:bukus,isbn,'.$data->id,
            'judul' => 'required|string',
            'pengarang' => 'string|nullable',
            'penerbit' => 'string|nullable',
            'kategori' => 'string|nullable',
        ]);

        // Edit Data
        $data->isbn = $request->input('isbn');
        $data->judul = $request->input('judul');
        $data->pengarang = $request->input('pengarang');
        $data->penerbit = $request->input('penerbit');
        $data->kategori_buku_id = $request->input('kategori');
        $data->save();

        return back()->with('success', 'Data Berhasil Diubah!');
    }

    public function hapus(int $id)
    {
        Buku::find($id)->delete();

        return redirect()->route('index.buku');
    }
}
