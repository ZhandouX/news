<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // MEMASTIKAN ROLE PADA MASING-MASING AKUN YANG AKAN DI TAMBAHKAN KE DALAM TABEL USERS
        $superAdminRole = Role::firstOrCreate(['name' => 'super-admin', 'guard_name' => 'web']);
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);

        // SEEDER UNTUK MEMBUAT AKUN SUPER (ADMIN)
        $superAdmin = User::firstOrCreate(
            ['email' => 'superadmin@gmail.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('superadmin1234'),
                'email_verified_at' => now(),
                'role_id' => $superAdminRole->id,
            ]
        );
        $superAdmin->assignRole($superAdminRole);

        // SEEDER UNTUK MEMBUAT AKUN ADMIN (PETUGAS)
        $admin = User::firstOrCreate(
            ['email' => 'adminpetugas@gmail.com'],
            [
                'name' => 'Petugas',
                'password' => Hash::make('petugas1234'),
                'email_verified_at' => now(),
                'role_id' => $adminRole->id,
            ]
        );
        $admin->assignRole($adminRole);
    }
}
