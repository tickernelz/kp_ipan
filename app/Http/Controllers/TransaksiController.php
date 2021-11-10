<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index()
    {
        // Get Data
        $data = Transaksi::with('anggota','buku')->get();

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
        $buku = Buku::get();

        return view('kelola.transaksi.tambah', [
            'anggota' => $anggota,
            'buku' => $buku,
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
        $data = Transaksi::with('anggota','buku')->find($id);
        $anggota = Anggota::get();
        $buku = Buku::get();

        // Konversi Tanggal
        $tanggal_pinjam = Carbon::parse($data->tanggal_pinjam)->formatLocalized('%d %B %Y');
        $tanggal_kembali = Carbon::parse($data->tanggal_kembali)->formatLocalized('%d %B %Y');

        return view('kelola.transaksi.edit', [
            'data' => $data,
            'buku' => $buku,
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
            'buku' => 'required|string',
            'tanggal_pinjam' => 'required|string',
            'tanggal_kembali' => 'required|string',
            'status' => 'required|string',
            'jumlah' => 'required|numeric',
        ]);

        // Konversi Tanggal
        $tanggal_pinjam = Carbon::createFromLocaleIsoFormat('D MMMM Y', 'id', $request->input('tanggal_pinjam'))->format('Y-m-d');
        $tanggal_kembali = Carbon::createFromLocaleIsoFormat('D MMMM Y', 'id', $request->input('tanggal_kembali'))->format('Y-m-d');

        // Kirim Data ke Database
        $data = new Transaksi;
        $data->anggota_id = $request->input('anggota');
        $data->buku_id = $request->input('buku');
        $data->tanggal_pinjam = $tanggal_pinjam;
        $data->tanggal_kembali = $tanggal_kembali;
        $data->status = $request->input('status');
        $data->jumlah = $request->input('jumlah');
        $data->save();

        // Kurangi Stok Buku
        $buku = Buku::whereId($request->input('buku'))->first();
        $buku->stok -= ($request->input('jumlah'));
        $buku->save();

        return back()->with('success', 'Data Berhasil Ditambahkan!');
    }

    public function edit(Request $request, int $id)
    {
        $data = Transaksi::find($id);

        $request->validate([
            'anggota' => 'required|string',
            'buku' => 'required|string',
            'tanggal_pinjam' => 'required|string',
            'tanggal_kembali' => 'required|string',
            'status' => 'required|string',
            'jumlah' => 'required|numeric',
        ]);

        // Konversi Tanggal
        $tanggal_pinjam = Carbon::createFromLocaleIsoFormat('D MMMM Y', 'id', $request->input('tanggal_pinjam'))->format('Y-m-d');
        $tanggal_kembali = Carbon::createFromLocaleIsoFormat('D MMMM Y', 'id', $request->input('tanggal_kembali'))->format('Y-m-d');

        // Edit Data
        $data->anggota_id = $request->input('anggota');
        $data->buku_id = $request->input('buku');
        $data->tanggal_pinjam = $tanggal_pinjam;
        $data->tanggal_kembali = $tanggal_kembali;
        $data->status = $request->input('status');
        // Kurangi Stok Buku
        $buku = Buku::whereId($request->input('buku'))->first();
        $buku->stok += ($data->jumlah);
        $buku->stok -= ($request->input('jumlah'));
        $data->jumlah = $request->input('jumlah');
        $buku->save();
        $data->save();

        return back()->with('success', 'Data Berhasil Diubah!');
    }

    public function hapus(int $id)
    {
        $data = Transaksi::find($id);

        if($data->status !== 'Kembali')
        {
            // Kembalikan Stok Buku
            $buku = Buku::whereId($data->buku_id)->first();
            $buku->stok += ($data->jumlah);
            $buku->save();
        }

        // Hapus Data
        $data->delete();

        return redirect()->route('index.transaksi');
    }

    public function kembali(int $id)
    {
        $data = Transaksi::find($id);
        $data->status = 'Kembali';
        $data->save();

        // Kembalikan Stok Buku
        $buku = Buku::whereId($data->buku_id)->first();
        $buku->stok += ($data->jumlah);
        $buku->save();

        return redirect()->route('index.transaksi');
    }
}
