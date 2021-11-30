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
            'jumlah' => 'numeric|nullable',
            'gambar' => 'file|nullable|mimes:jpeg,jpg,bmp,png,svg',
        ]);

        // Kirim Data ke Database
        $data = new Buku;
        $data->isbn = $request->input('isbn');
        $data->judul = $request->input('judul');
        $data->pengarang = $request->input('pengarang');
        $data->penerbit = $request->input('penerbit');
        $data->kategori_buku_id = $request->input('kategori');
        $data->jumlah = $request->input('jumlah');
        $data->stok = $request->input('jumlah');
        if ($request->hasFile('gambar')) {
            $fileName = time() . '_' . $request->gambar->getClientOriginalName();
            $request->gambar->move(public_path('gambar'), $fileName);
            $data->gambar = $fileName;
        }
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
            'jumlah' => 'numeric|nullable',
            'stok' => 'numeric|nullable',
            'gambar' => 'file|nullable|mimes:jpeg,jpg,bmp,png,svg',
        ]);

        // Edit Data
        $data->isbn = $request->input('isbn');
        $data->judul = $request->input('judul');
        $data->pengarang = $request->input('pengarang');
        $data->penerbit = $request->input('penerbit');
        $data->kategori_buku_id = $request->input('kategori');
        $data->jumlah = $request->input('jumlah');
        $data->stok = $request->input('stok');
        // Cek apakah ada berkas?
        if ($request->hasFile('gambar')) {
            // Hapus Berkas Lama (Jika Ada)
            $namaberkas = $data->gambar;
            if (is_file(public_path('gambar') . '/' . $namaberkas)) {
                unlink(public_path('gambar') . '/' . $namaberkas);
            }
            // Upload File Baru
            $fileName = time() . '_' . $request->gambar->getClientOriginalName();
            $request->gambar->move(public_path('gambar'), $fileName);
            $data->gambar = $fileName;
        }
        $data->save();

        return back()->with('success', 'Data Berhasil Diubah!');
    }

    public function hapus(int $id)
    {
        Buku::find($id)->delete();

        return redirect()->route('index.buku');
    }
}
