<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    public function kategori_buku()
    {
        return $this->belongsTo(KategoriBuku::class);
    }
}
