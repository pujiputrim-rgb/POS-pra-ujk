<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);
        $cashierRole = Role::firstOrCreate(['name' => 'Kasir']);
        $leaderRole = Role::firstOrCreate(['name' => 'Pimpinan']);

        $admin = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin Utama',
                'password' => Hash::make('12345678'),
                'role_id' => $adminRole->id,
            ]
        );
        $admin->update(['role_id' => $adminRole->id]);

        $cashier = User::firstOrCreate(
            ['email' => 'cashier@gmail.com'],
            [
                'name' => 'Kasir 1',
                'password' => Hash::make('12345678'),
                'role_id' => $cashierRole->id,
            ]
        );
        $cashier->update(['role_id' => $cashierRole->id]);
    }
}
