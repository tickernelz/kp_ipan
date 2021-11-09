<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    protected $dates = [
        'tanggal_pinjam',
        'tanggal_kembali',
    ];

    public function anggota()
    {
        return $this->belongsTo(Anggota::class);
    }
}
