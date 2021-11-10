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
            'user_id' => '1',
            'nip' => '432435',
            'nama' => 'Ipandri',
            'hp' => '08123345678',
        ]);
    }
}
