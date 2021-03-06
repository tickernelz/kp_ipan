<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Auth;
use Illuminate\Http\Request;

class PinjamController extends Controller
{
    public function index()
    {
        // Config
        $conf_tgl = [
            'format' => 'DD MMMM YYYY',
            'locale' => 'id',
            'minDate' => "js:moment().startOf('day')",
        ];

        // Get Data
        $anggota = Auth::user()->anggota;

        return view('pinjam.index', [
            'anggota' => $anggota,
            'conf_tgl' => $conf_tgl,
        ]);
    }

    public function list()
    {
        // Get Data
        $anggota = Auth::user()->anggota;
        $data = Transaksi::with('anggota')->where('anggota_id', $anggota->id)->get();

        $heads = [
            '#',
            'ISBN',
            'Judul Buku',
            'Tanggal Pinjam',
            'Tanggal Kembali',
            'Status',
            'Terlambat',
            'Aksi',
        ];

        $config = [
            'order' => [[0, 'asc']],
            'columns' => [null, null, null, null, null, null, null, ['orderable' => false]],
        ];

        return view('pinjam.pinjam', [
            'data' => $data,
            'anggota' => $anggota,
            'heads' => $heads,
            'config' => $config,
        ]);
    }

    public function pinjam(Request $request)
    {
        $request->validate([
            'isbn' => 'required|numeric',
            'buku' => 'string|nullable',
            'tanggal_kembali' => 'required|string',
        ]);

        // Kirim Data ke Database
        $data = new Transaksi;
        $data->anggota_id = Auth::user()->anggota->id;
        $data->isbn = $request->input('isbn');
        $data->buku = $request->input('buku');
        $data->tanggal_pinjam = now();
        $data->tanggal_kembali = $request->input('tanggal_kembali');
        $data->status = 'Pinjam';
        $data->save();

        return back()->with('success', 'Data Berhasil Ditambahkan!');
    }

    public function kembali(int $id)
    {
        $data = Transaksi::find($id);
        $data->status = 'Kembali';
        $data->save();

        return redirect()->route('list.pinjam');
    }
}
