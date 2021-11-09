<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index()
    {
        // Get Data
        $data = Transaksi::with('anggota')->get();

        return view('kelola.transaksi.index', [
            'data' => $data,
        ]);
    }

    public function tambah_index()
    {
        // Config
        $conf_tgl = [
            'format' => 'DD MMMM YYYY',
            'locale' => 'id',
            'minDate' => "js:moment().startOf('day')",
        ];

        // Get Data
        $anggota = Anggota::get();

        return view('kelola.transaksi.tambah', [
            'anggota' => $anggota,
            'conf_tgl' => $conf_tgl,
        ]);
    }

    public function edit_index(int $id)
    {
        // Config
        $conf_tgl = [
            'format' => 'DD MMMM YYYY',
            'locale' => 'id',
            'minDate' => "js:moment().startOf('day')",
        ];

        // Get Data
        $data = Transaksi::with('anggota')->find($id);
        $anggota = Anggota::get();

        // Konversi Tanggal
        $tanggal_pinjam = Carbon::parse($data->tanggal_pinjam)->formatLocalized('%d %B %Y');
        $tanggal_kembali = Carbon::parse($data->tanggal_kembali)->formatLocalized('%d %B %Y');

        return view('kelola.transaksi.edit', [
            'data' => $data,
            'anggota' => $anggota,
            'conf_tgl' => $conf_tgl,
            'tanggal_pinjam' => $tanggal_pinjam,
            'tanggal_kembali' => $tanggal_kembali,
        ]);
    }

    public function tambah(Request $request)
    {
        $request->validate([
            'anggota' => 'required|string',
            'isbn' => 'required|numeric',
            'buku' => 'string|nullable',
            'tanggal_pinjam' => 'required|string',
            'tanggal_kembali' => 'required|string',
            'status' => 'required|string',
        ]);

        // Konversi Tanggal
        $tanggal_pinjam = Carbon::createFromLocaleIsoFormat('D MMMM Y', 'id', $request->input('tanggal_pinjam'))->format('Y-m-d');
        $tanggal_kembali = Carbon::createFromLocaleIsoFormat('D MMMM Y', 'id', $request->input('tanggal_kembali'))->format('Y-m-d');

        // Kirim Data ke Database
        $data = new Transaksi;
        $data->anggota_id = $request->input('anggota');
        $data->isbn = $request->input('isbn');
        $data->buku = $request->input('buku');
        $data->tanggal_pinjam = $tanggal_pinjam;
        $data->tanggal_kembali = $tanggal_kembali;
        $data->status = $request->input('status');
        $data->save();

        return back()->with('success', 'Data Berhasil Ditambahkan!');
    }

    public function edit(Request $request, int $id)
    {
        $data = Transaksi::find($id);

        $request->validate([
            'anggota' => 'required|string',
            'isbn' => 'required|numeric',
            'buku' => 'string|nullable',
            'tanggal_pinjam' => 'required|string',
            'tanggal_kembali' => 'required|string',
            'status' => 'required|string',
        ]);

        // Konversi Tanggal
        $tanggal_pinjam = Carbon::createFromLocaleIsoFormat('D MMMM Y', 'id', $request->input('tanggal_pinjam'))->format('Y-m-d');
        $tanggal_kembali = Carbon::createFromLocaleIsoFormat('D MMMM Y', 'id', $request->input('tanggal_kembali'))->format('Y-m-d');

        // Edit Data
        $data->anggota_id = $request->input('anggota');
        $data->isbn = $request->input('isbn');
        $data->buku = $request->input('buku');
        $data->tanggal_pinjam = $tanggal_pinjam;
        $data->tanggal_kembali = $tanggal_kembali;
        $data->status = $request->input('status');
        $data->save();

        return back()->with('success', 'Data Berhasil Diubah!');
    }

    public function hapus(int $id)
    {
        Transaksi::find($id)->delete();

        return redirect()->route('index.transaksi');
    }

    public function kembali(int $id)
    {
        $data = Transaksi::find($id);
        $data->status = 'Kembali';
        $data->save();

        return redirect()->route('index.transaksi');
    }
}
