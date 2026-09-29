<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Siswa;
use App\Models\Pembayaran;

class WebKasTest extends TestCase
{
    public function test_login_page_renders_without_route_not_found_exception(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);

        // Also test root URL
        $response = $this->get('/');
        $response->assertRedirect('/login');

        // Test portal alias
        $this->assertTrue(\Illuminate\Support\Facades\Route::has('portal.index'));
        $response = $this->get(route('portal.index'));
        $response->assertRedirect(route('siswa.dashboard'));
    }

    public function test_guest_is_redirected_to_login(): void
    {
        $response = $this->get('/admin/dashboard');
        $response->assertRedirect('/login');

        $response = $this->get('/siswa/dashboard');
        $response->assertRedirect('/login');
    }

    public function test_student_cannot_access_admin_panel(): void
    {
        $siswaUser = User::where('role', 'siswa')->first() ?? User::factory()->create(['role' => 'siswa']);

        $response = $this->actingAs($siswaUser)->get('/admin/dashboard');
        // RoleMiddleware redirects student to siswa.dashboard with error flash
        $response->assertRedirect(route('siswa.dashboard'));
    }

    public function test_admin_can_access_all_admin_pages(): void
    {
        $adminUser = User::where('role', 'admin')->first() ?? User::factory()->create(['role' => 'admin']);

        $pages = [
            '/admin/dashboard',
            '/admin/siswa',
            '/admin/pembayaran',
            '/admin/pemasukan',
            '/admin/pengeluaran',
            '/admin/laporan',
        ];

        foreach ($pages as $page) {
            $response = $this->actingAs($adminUser)->get($page);
            $response->assertStatus(200);
        }
    }

    public function test_siswa_can_access_student_portal(): void
    {
        $siswaUser = User::where('role', 'siswa')->first() ?? User::factory()->create(['role' => 'siswa']);

        $response = $this->actingAs($siswaUser)->get('/siswa/dashboard');
        $response->assertStatus(200);

        $response = $this->actingAs($siswaUser)->get('/siswa/pembayaran');
        $response->assertStatus(200);
    }

    public function test_post_login_redirect_by_role(): void
    {
        // 1. Admin login redirects to admin.dashboard
        $response = $this->post('/login', [
            'identity' => 'salsabila@sekolah.sch.id',
            'password' => 'password',
            'role' => 'treasurer',
        ]);
        $response->assertRedirect(route('admin.dashboard'));

        // 2. Student login redirects to siswa.dashboard
        $response = $this->post('/login', [
            'identity' => '89201',
            'password' => 'password',
            'role' => 'student',
        ]);
        $response->assertRedirect(route('siswa.dashboard', ['nis' => '89201']));
    }
}
