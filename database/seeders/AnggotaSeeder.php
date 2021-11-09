<?php

namespace Database\Seeders;

use App\Models\Anggota;
use Illuminate\Database\Seeder;

class AnggotaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Anggota::create([
            'user_id' => '3',
            'nik' => '12345678',
            'email' => 'dede@gmail.com',
            'nama' => 'Dede',
            'hp' => '0812345678',
        ]);
    }
}
