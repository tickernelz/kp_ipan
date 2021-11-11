<?php

namespace App\Http\Controllers;

use App\Models\Booking;

class BookingController extends Controller
{
    public function index()
    {
        // Get Data
        $data = Booking::with('anggota','buku')->get();

        return view('kelola.booking.index', [
            'data' => $data,
        ]);
    }

    public function terima(int $id)
    {
        // Get Data
        $data = Booking::find($id);

        // Ubah Status
        $data->status = 'Tersedia';
        $data->save();

        return back()->with('success', 'Buku Berhasil Diterima!');
    }

    public function tolak(int $id)
    {
        // Get Data
        $data = Booking::find($id);

        // Ubah Status
        $data->status = 'Tidak Tersedia';
        $data->save();

        return back()->with('success', 'Buku Berhasil Ditolak!');
    }
}
