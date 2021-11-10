<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::create([
            'user_id' => '1',
            'nip' => '432435',
            'nama' => 'Dani',
            'hp' => '08123345678',
        ]);
    }
}
