<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserManagementTest extends TestCase
{
    /**
     * Helper untuk mendapatkan user Admin.
     */
    protected function getAdminUser(): User
    {
        $role = Role::firstOrCreate(['name' => 'Admin']);

        return User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            ['name' => 'Admin Utama', 'password' => Hash::make('12345678'), 'role_id' => $role->id]
        );
    }

    /**
     * Test form create user menampilkan dropdown pilihan role.
     */
    public function test_user_create_page_displays_role_dropdown(): void
    {
        Role::firstOrCreate(['name' => 'Admin']);
        Role::firstOrCreate(['name' => 'Kasir']);
        Role::firstOrCreate(['name' => 'Pimpinan']);

        $admin = $this->getAdminUser();

        $response = $this->actingAs($admin)->get('/admin/user/create');

        $response->assertStatus(200);
        $response->assertSee('Nama Lengkap / Label Akun');
        $response->assertSee('Role / Hak Akses');
        $response->assertSee('Admin');
        $response->assertSee('Kasir');
        $response->assertSee('Pimpinan');
    }

    /**
     * Test menyimpan user baru beserta role.
     */
    public function test_store_user_with_role_successfully(): void
    {
        $kasirRole = Role::firstOrCreate(['name' => 'Kasir']);
        $admin = $this->getAdminUser();

        $email = 'kasir_test_' . rand(100, 999) . '@gmail.com';

        $response = $this->actingAs($admin)->post('/admin/user', [
            'name' => 'Kasir Test',
            'email' => $email,
            'password' => '12345678',
            'role_id' => $kasirRole->id,
        ]);

        $response->assertRedirect(route('user.index'));
        $this->assertDatabaseHas('users', [
            'name' => 'Kasir Test',
            'email' => $email,
            'role_id' => $kasirRole->id,
        ]);
    }

    /**
     * Test tabel index user menampilkan badge role.
     */
    public function test_user_index_displays_role_badges(): void
    {
        $pimpinanRole = Role::firstOrCreate(['name' => 'Pimpinan']);
        $user = User::firstOrCreate(
            ['email' => 'pimpinan_test@gmail.com'],
            [
                'name' => 'Manajer Operasional',
                'password' => Hash::make('12345678'),
                'role_id' => $pimpinanRole->id,
            ]
        );
        $admin = $this->getAdminUser();

        $response = $this->actingAs($admin)->get('/admin/user');

        $response->assertStatus(200);
        $response->assertSee('Manajer Operasional');
        $response->assertSee('Pimpinan');
    }
}
