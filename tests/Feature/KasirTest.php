<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class KasirTest extends TestCase
{
    /**
     * Helper untuk mendapatkan user Kasir.
     */
    protected function getCashierUser(): User
    {
        return User::firstOrCreate(
            ['email' => 'cashier@gmail.com'],
            ['name' => 'Kasir POS', 'password' => Hash::make('12345678')]
        );
    }

    /**
     * Helper untuk mendapatkan user Admin.
     */
    protected function getAdminUser(): User
    {
        return User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            ['name' => 'Admin Utama', 'password' => Hash::make('12345678')]
        );
    }

    /**
     * Test halaman kasir sebagai standalone page yang dapat diakses oleh user Kasir.
     */
    public function test_kasir_standalone_page_can_be_rendered_for_cashier(): void
    {
        $cashier = $this->getCashierUser();

        $response = $this->actingAs($cashier)->get('/kasir');

        $response->assertStatus(200);
        $response->assertSee('Kasir POS');
        $response->assertSee('Ringkasan Pesanan');
        $response->assertSee('Proses Pembayaran');
        // Pastikan tidak menggunakan layout admin (tidak ada sidebar admin)
        $response->assertDontSee('id="sidebar"', false);
        // Akun kasir tidak melihat tombol "Kembali ke Admin"
        $response->assertDontSee('Kembali ke Admin');
    }

    /**
     * Test halaman kasir menampilkan pesan kosong jika produk di database belum ada.
     */
    public function test_kasir_displays_empty_state_when_no_products(): void
    {
        Product::query()->delete();
        $cashier = $this->getCashierUser();

        $response = $this->actingAs($cashier)->get('/kasir');
        $response->assertStatus(200);
        $response->assertSee('Belum ada produk');
    }

    /**
     * Test halaman kasir menampilkan produk dari database.
     */
    public function test_kasir_displays_products_from_database(): void
    {
        $category = Category::firstOrCreate(['name' => 'Minuman']);
        $product = Product::create([
            'name' => 'Kopi Susu Gula Aren',
            'category_id' => $category->id,
            'price' => 20000,
            'stock' => 15,
        ]);
        $cashier = $this->getCashierUser();

        $response = $this->actingAs($cashier)->get('/kasir');
        $response->assertStatus(200);
        $response->assertSee('Kopi Susu Gula Aren');
        $response->assertSee('Rp 20.000');
    }

    /**
     * Test login sebagai cashier@gmail.com langsung di-redirect ke /kasir.
     */
    public function test_cashier_login_redirects_directly_to_kasir(): void
    {
        $this->getCashierUser();

        $response = $this->post('/action-login', [
            'email' => 'cashier@gmail.com',
            'password' => '12345678',
        ]);

        $response->assertRedirect(route('kasir.index'));
    }

    /**
     * Test menu Kasir tampil di sidebar admin dan mengarah ke route kasir.
     */
    public function test_admin_sidebar_has_kasir_menu(): void
    {
        $admin = $this->getAdminUser();

        $response = $this->actingAs($admin)->get('/admin/dashboard');

        $response->assertStatus(200);
        $response->assertSee('id="menu-kasir"', false);
        $response->assertSee(route('kasir.index'));
    }

    /**
     * Test Admin bisa membuka /kasir dan melihat tombol 'Kembali ke Admin'.
     */
    public function test_admin_can_access_kasir_page_and_see_back_button(): void
    {
        $admin = $this->getAdminUser();

        $response = $this->actingAs($admin)->get('/kasir');

        $response->assertStatus(200);
        $response->assertSee('Kembali ke Admin');
        $response->assertSee(url('/admin/dashboard'));
    }

    /**
     * Test proteksi middleware: Kasir tidak bisa mengakses halaman admin (/admin/*).
     */
    public function test_cashier_cannot_access_admin_pages(): void
    {
        $cashier = $this->getCashierUser();

        $response = $this->actingAs($cashier)->get('/admin/dashboard');
        $response->assertRedirect(route('kasir.index'));

        $responseProducts = $this->actingAs($cashier)->get('/admin/products');
        $responseProducts->assertRedirect(route('kasir.index'));
    }

    /**
     * Test user belum login di-redirect ke login page saat mengakses /kasir.
     */
    public function test_unauthenticated_user_redirected_to_login(): void
    {
        $response = $this->get('/kasir');
        $response->assertRedirect('/admin/login');
    }
}
