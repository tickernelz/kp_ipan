<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'kelola user']);
        Permission::create(['name' => 'kelola kategori buku']);
        Permission::create(['name' => 'kelola buku']);
        Permission::create(['name' => 'kelola transaksi']);
        Permission::create(['name' => 'melakukan peminjaman']);

        $role1 = Role::create([
            'name' => 'Admin',
            'guard_name' => 'web',
        ]);
        $role1->givePermissionTo('kelola user');
        $role1->givePermissionTo('kelola buku');
        $role1->givePermissionTo('kelola kategori buku');
        $role1->givePermissionTo('kelola transaksi');
        $role1->givePermissionTo('melakukan peminjaman');

        $role2 = Role::create([
            'name' => 'Pegawai',
            'guard_name' => 'web',
        ]);
        $role2->givePermissionTo('kelola buku');
        $role2->givePermissionTo('kelola kategori buku');
        $role2->givePermissionTo('kelola transaksi');
        $role2->givePermissionTo('melakukan peminjaman');

        $role3 = Role::create([
            'name' => 'Anggota',
            'guard_name' => 'web',
        ]);
        $role3->givePermissionTo('melakukan peminjaman');
    }
}
