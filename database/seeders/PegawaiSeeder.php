<?php

namespace Database\Seeders;

use App\Models\Pegawai;
use Illuminate\Database\Seeder;

class PegawaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Pegawai::create([
            'user_id' => '2',
            'nip' => '4324352',
            'nama' => 'Yanto',
            'hp' => '08123452678',
        ]);
    }
}
