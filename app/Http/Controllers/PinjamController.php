<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Buku;
use Auth;

class PinjamController extends Controller
{
    public function index()
    {
        // Get Data
        $anggota = Auth::user()->anggota;
        $data = Buku::with('kategori_buku')->get();
        $booking = Booking::with('anggota','buku')->where('anggota_id', $anggota->id)->get();

        return view('anggota.index', [
            'data' => $data,
            'booking' => $booking,
            'anggota' => $anggota,
        ]);
    }

    public function tambah(int $id_buku)
    {
        // Kirim Data ke Database
        $data = new Booking;
        $data->anggota_id = Auth::user()->anggota->id;
        $data->buku_id = $id_buku;
        $data->status = 'Menunggu';
        $data->save();

        return back()->with('success', 'Buku Berhasil Dibooking!');
    }

    public function cancel(int $id)
    {
        // Hapus Data
        Booking::find($id)->delete();

        return back()->with('success', 'Booking Berhasil Dicancel!');
    }

    public function index_booking()
    {
        //User
        $user = Auth::user()->anggota;

        // Get Data
        $data = Booking::with('anggota','buku')->where('anggota_id', $user->id)->get();

        return view('anggota.booking', [
            'data' => $data,
            'user' => $user,
        ]);
    }
}
