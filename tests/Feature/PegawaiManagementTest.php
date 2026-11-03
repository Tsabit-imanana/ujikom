<?php

namespace Tests\Feature;

use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PegawaiManagementTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'name' => 'Admin Penguji',
            'email' => 'admin@ujikom.test',
            'password' => bcrypt('password'),
        ]);
    }

    public function test_guest_is_redirected_to_login(): void
    {
        $response = $this->get('/dashboard');
        $response->assertRedirect('/login');

        $response = $this->get('/pegawai');
        $response->assertRedirect('/login');
    }

    public function test_admin_can_login_with_credentials(): void
    {
        $response = $this->post('/login', [
            'email' => 'admin@ujikom.test',
            'password' => 'password',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($this->admin);
    }

    public function test_admin_can_login_via_demo_button(): void
    {
        $response = $this->post('/login-demo');

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticated();
    }

    public function test_admin_can_view_dashboard_with_all_three_charts(): void
    {
        // Seed some pegawai
        Pegawai::factory()->create([
            'jenis_kelamin' => 'Laki-laki',
            'pendidikan_terakhir' => 'S1',
            'tanggal_lahir' => '1995-05-15',
        ]);
        Pegawai::factory()->create([
            'jenis_kelamin' => 'Perempuan',
            'pendidikan_terakhir' => 'D3',
            'tanggal_lahir' => '2000-01-10',
        ]);

        $response = $this->actingAs($this->admin)->get('/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Rasio Jenis Kelamin');
        $response->assertSee('Pendidikan Terakhir');
        $response->assertSee('Distribusi Usia');
        $response->assertSee('genderChartCanvas');
        $response->assertSee('educationChartCanvas');
        $response->assertSee('ageChartCanvas');
    }

    public function test_admin_can_view_pegawai_list_and_search(): void
    {
        $pegawaiA = Pegawai::factory()->create(['nama' => 'Budi Santoso']);
        $pegawaiB = Pegawai::factory()->create(['nama' => 'Siti Nurhaliza']);

        $response = $this->actingAs($this->admin)->get('/pegawai');
        $response->assertStatus(200);
        $response->assertSee('Budi Santoso');
        $response->assertSee('Siti Nurhaliza');

        // Test search
        $searchResponse = $this->actingAs($this->admin)->get('/pegawai?search=Budi');
        $searchResponse->assertStatus(200);
        $searchResponse->assertSee('Budi Santoso');
        $searchResponse->assertDontSee('Siti Nurhaliza');
    }

    public function test_admin_can_create_new_pegawai_with_minimal_four_attributes(): void
    {
        // Ketentuan: Minimal empat atribut: Nama Pegawai, Jenis Kelamin, Pendidikan Terakhir, Tanggal Lahir
        $payload = [
            'nama' => 'Ahmad Dahlan',
            'jenis_kelamin' => 'Laki-laki',
            'pendidikan_terakhir' => 'S1',
            'tanggal_lahir' => '1992-04-12',
            'jabatan' => 'System Analyst',
            'email' => 'ahmad.dahlan@example.com',
            'telepon' => '081234567890',
            'alamat' => 'Jl. Merdeka No. 10',
        ];

        $response = $this->actingAs($this->admin)->post('/pegawai', $payload);

        $response->assertRedirect('/pegawai');
        $this->assertDatabaseHas('pegawais', [
            'nama' => 'Ahmad Dahlan',
            'jenis_kelamin' => 'Laki-laki',
            'pendidikan_terakhir' => 'S1',
            'tanggal_lahir' => '1992-04-12',
        ]);
    }

    public function test_validation_fails_when_minimal_attributes_are_missing(): void
    {
        $response = $this->actingAs($this->admin)->post('/pegawai', [
            'nama' => '',
            'jenis_kelamin' => '',
            'pendidikan_terakhir' => '',
            'tanggal_lahir' => '',
        ]);

        $response->assertSessionHasErrors(['nama', 'jenis_kelamin', 'pendidikan_terakhir', 'tanggal_lahir']);
    }

    public function test_admin_can_view_pegawai_detail_and_ajax_json_modal(): void
    {
        $pegawai = Pegawai::factory()->create([
            'nama' => 'Dewi Sartika',
            'jenis_kelamin' => 'Perempuan',
            'pendidikan_terakhir' => 'S2',
            'tanggal_lahir' => '1990-08-20',
        ]);

        // Standard HTML view
        $response = $this->actingAs($this->admin)->get("/pegawai/{$pegawai->id}");
        $response->assertStatus(200);
        $response->assertSee('Dewi Sartika');

        // JSON response for quick detail modal
        $jsonResponse = $this->actingAs($this->admin)->getJson("/pegawai/{$pegawai->id}");
        $jsonResponse->assertStatus(200);
        $jsonResponse->assertJsonFragment([
            'nama' => 'Dewi Sartika',
            'jenis_kelamin' => 'Perempuan',
            'pendidikan_terakhir' => 'S2',
        ]);
    }

    public function test_admin_can_update_pegawai_data(): void
    {
        $pegawai = Pegawai::factory()->create([
            'nama' => 'Dimas Anggara',
            'jenis_kelamin' => 'Laki-laki',
            'pendidikan_terakhir' => 'SMA/SMK',
            'tanggal_lahir' => '1998-03-22',
        ]);

        $updatedPayload = [
            'nama' => 'Dimas Anggara, S.Kom.',
            'jenis_kelamin' => 'Laki-laki',
            'pendidikan_terakhir' => 'S1',
            'tanggal_lahir' => '1998-03-22',
            'jabatan' => 'Fullstack Developer',
        ];

        $response = $this->actingAs($this->admin)->put("/pegawai/{$pegawai->id}", $updatedPayload);

        $response->assertRedirect('/pegawai');
        $this->assertDatabaseHas('pegawais', [
            'id' => $pegawai->id,
            'nama' => 'Dimas Anggara, S.Kom.',
            'pendidikan_terakhir' => 'S1',
            'jabatan' => 'Fullstack Developer',
        ]);
    }

    public function test_admin_can_delete_pegawai(): void
    {
        $pegawai = Pegawai::factory()->create([
            'nama' => 'Pegawai Yang Akan Dihapus',
        ]);

        $response = $this->actingAs($this->admin)->delete("/pegawai/{$pegawai->id}");

        $response->assertRedirect('/pegawai');
        $this->assertDatabaseMissing('pegawais', [
            'id' => $pegawai->id,
        ]);
    }

    public function test_admin_can_export_pegawai_csv(): void
    {
        Pegawai::factory()->create(['nama' => 'Pegawai Export Test']);

        $response = $this->actingAs($this->admin)->get('/pegawai/export');

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/csv; charset=UTF-8');
        $this->assertStringContainsString('Pegawai Export Test', $response->streamedContent());
    }
}
