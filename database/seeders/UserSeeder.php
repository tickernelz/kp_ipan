<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'username' => 'ipan1',
            'password' => bcrypt('123'),
        ])->assignRole('Admin');

        User::create([
            'username' => 'ipan2',
            'password' => bcrypt('123'),
        ])->assignRole('Pegawai');

        User::create([
            'username' => 'ipan3',
            'password' => bcrypt('123'),
        ])->assignRole('Anggota');
    }
}
