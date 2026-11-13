<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Modules\TitikKemacetan\Models\TitikKemacetan;
use Modules\LaporanInsiden\Models\LaporanInsiden;
use Tests\TestCase;

class HMVCModule8Test extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'name' => 'Admin Test',
            'email' => 'admin@test.com',
            'role' => UserRole::Admin,
        ]);

        $this->user = User::factory()->create([
            'name' => 'User Test',
            'email' => 'user@test.com',
            'role' => UserRole::User,
        ]);
    }

    public function test_guest_is_redirected_to_login_for_all_protected_routes(): void
    {
        $this->get('/dashboard')->assertRedirect('/login');
        $this->get('/titikkemacetan')->assertRedirect('/login');
        $this->get('/titikkemacetan/create')->assertRedirect('/login');
        $this->get('/laporaninsiden')->assertRedirect('/login');
        $this->get('/admin/users')->assertRedirect('/login');
    }

    public function test_user_is_forbidden_from_admin_only_routes(): void
    {
        // User cannot access admin User Management
        $this->actingAs($this->user)
            ->get('/admin/users')
            ->assertStatus(403);

        // User cannot access Titik Kemacetan Create form
        $this->actingAs($this->user)
            ->get('/titikkemacetan/create')
            ->assertStatus(403);
    }

    public function test_admin_can_access_all_routes(): void
    {
        $this->actingAs($this->admin)->get('/dashboard')->assertStatus(200);
        $this->actingAs($this->admin)->get('/admin/users')->assertStatus(200);
        $this->actingAs($this->admin)->get('/titikkemacetan')->assertStatus(200);
        $this->actingAs($this->admin)->get('/titikkemacetan/create')->assertStatus(200);
        $this->actingAs($this->admin)->get('/laporaninsiden')->assertStatus(200);
    }

    public function test_user_can_access_titikkemacetan_index_and_laporaninsiden(): void
    {
        $this->actingAs($this->user)->get('/titikkemacetan')->assertStatus(200);
        $this->actingAs($this->user)->get('/laporaninsiden')->assertStatus(200);
        $this->actingAs($this->user)->get('/laporaninsiden/data')->assertStatus(200);
    }

    public function test_titikkemacetan_synchronous_crud(): void
    {
        // 1. Admin Create
        $response = $this->actingAs($this->admin)->post('/titikkemacetan', [
            'nama_jalan' => 'Jl. Layang Pasupati',
            'wilayah' => 'Bandung Wetan',
            'kondisi_lalin' => 'Padat Merayap',
            'kecepatan_rata_rata' => 20,
            'panjang_antrian' => 600,
            'penyebab' => 'Volume kendaraan tinggi sore hari',
        ]);
        $response->assertRedirect('/titikkemacetan');
        $this->assertDatabaseHas('titik_kemacetans', ['nama_jalan' => 'Jl. Layang Pasupati']);

        $titik = TitikKemacetan::where('nama_jalan', 'Jl. Layang Pasupati')->first();

        // 2. Admin Update
        $updateRes = $this->actingAs($this->admin)->put("/titikkemacetan/{$titik->id}", [
            'nama_jalan' => 'Jl. Layang Pasupati (Updated)',
            'wilayah' => 'Bandung Wetan',
            'kondisi_lalin' => 'Macet Total',
            'kecepatan_rata_rata' => 10,
            'panjang_antrian' => 900,
            'penyebab' => 'Hambatan lajur',
        ]);
        $updateRes->assertRedirect('/titikkemacetan');
        $this->assertDatabaseHas('titik_kemacetans', ['nama_jalan' => 'Jl. Layang Pasupati (Updated)']);

        // 3. Admin Delete
        $deleteRes = $this->actingAs($this->admin)->delete("/titikkemacetan/{$titik->id}");
        $deleteRes->assertRedirect('/titikkemacetan');
        $this->assertDatabaseMissing('titik_kemacetans', ['id' => $titik->id]);
    }

    public function test_laporaninsiden_ajax_crud_with_file_upload(): void
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->create('bukti_insiden.png', 500, 'image/png');

        // 1. Store via AJAX
        $response = $this->actingAs($this->user)->postJson('/laporaninsiden', [
            'nama_pelapor' => 'Ahmad Pelapor',
            'lokasi_jalan' => 'Jl. Cihampelas No. 25',
            'kategori_insiden' => 'Pohon Tumbang',
            'tingkat_keparahan' => 'Tinggi',
            'keterangan' => 'Pohon menutupi sebagian jalan',
            'kontak_pelapor' => '081234567890',
            'berkas' => $file,
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['success']);

        $laporan = LaporanInsiden::first();
        $this->assertNotNull($laporan);
        $this->assertEquals('Ahmad Pelapor', $laporan->nama_pelapor);
        $this->assertNotNull($laporan->berkas);
        Storage::disk('public')->assertExists($laporan->berkas);

        // 2. Edit endpoint returns JSON
        $editRes = $this->actingAs($this->user)->getJson("/laporaninsiden/{$laporan->id}/edit");
        $editRes->assertStatus(200)->assertJsonPath('nama_pelapor', 'Ahmad Pelapor');

        // 3. Update with new file replaces old file
        $oldFile = $laporan->berkas;
        $newFile = UploadedFile::fake()->create('dokumen_laporan.pdf', 800, 'application/pdf');

        $updateRes = $this->actingAs($this->user)->putJson("/laporaninsiden/{$laporan->id}", [
            'nama_pelapor' => 'Ahmad Pelapor (Revisi)',
            'lokasi_jalan' => 'Jl. Cihampelas No. 25',
            'kategori_insiden' => 'Pohon Tumbang',
            'tingkat_keparahan' => 'Kritis',
            'keterangan' => 'Pohon tumbang telah dievakuasi sebagian',
            'kontak_pelapor' => '081234567890',
            'berkas' => $newFile,
        ]);

        $updateRes->assertStatus(200)->assertJsonStructure(['success']);
        $laporan->refresh();
        $this->assertEquals('Ahmad Pelapor (Revisi)', $laporan->nama_pelapor);
        Storage::disk('public')->assertMissing($oldFile);
        Storage::disk('public')->assertExists($laporan->berkas);

        // 4. Delete removes file from storage
        $currentFile = $laporan->berkas;
        $delRes = $this->actingAs($this->user)->deleteJson("/laporaninsiden/{$laporan->id}");
        $delRes->assertStatus(200)->assertJsonStructure(['success']);
        $this->assertDatabaseMissing('laporan_insidens', ['id' => $laporan->id]);
        Storage::disk('public')->assertMissing($currentFile);
    }

    public function test_laporaninsiden_validation_errors_returned_as_422_json(): void
    {
        $response = $this->actingAs($this->user)->postJson('/laporaninsiden', [
            'nama_pelapor' => '',
            'lokasi_jalan' => '',
            'kontak_pelapor' => 'bukan-angka',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['nama_pelapor', 'lokasi_jalan', 'kategori_insiden', 'tingkat_keparahan', 'keterangan', 'kontak_pelapor', 'berkas']);
    }

    public function test_invalid_file_type_is_rejected(): void
    {
        $zipFile = UploadedFile::fake()->create('arsip.zip', 500, 'application/zip');

        $response = $this->actingAs($this->user)->postJson('/laporaninsiden', [
            'nama_pelapor' => 'Budi',
            'lokasi_jalan' => 'Jl. Merdeka',
            'kategori_insiden' => 'Kemacetan Parah',
            'tingkat_keparahan' => 'Sedang',
            'keterangan' => 'Macet panjang',
            'kontak_pelapor' => '081234567890',
            'berkas' => $zipFile,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['berkas']);
    }

    public function test_admin_can_manage_users_via_usermanagement_module(): void
    {
        // 1. Admin create user
        $createRes = $this->actingAs($this->admin)->post('/admin/users', [
            'name' => 'Petugas Baru',
            'email' => 'petugas@test.com',
            'role' => 'admin',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);
        $createRes->assertRedirect('/admin/users');
        $this->assertDatabaseHas('users', ['email' => 'petugas@test.com']);

        $userBaru = User::where('email', 'petugas@test.com')->first();

        // 2. Admin update user
        $updateRes = $this->actingAs($this->admin)->put("/admin/users/{$userBaru->id}", [
            'name' => 'Petugas Lapangan',
            'email' => 'petugas@test.com',
            'role' => 'user',
        ]);
        $updateRes->assertRedirect('/admin/users');
        $this->assertDatabaseHas('users', ['name' => 'Petugas Lapangan']);

        // 3. Admin cannot demote self
        $selfDemoteRes = $this->actingAs($this->admin)->put("/admin/users/{$this->admin->id}", [
            'name' => $this->admin->name,
            'email' => $this->admin->email,
            'role' => 'user',
        ]);
        $selfDemoteRes->assertSessionHasErrors(['role']);

        // 4. Admin cannot delete self
        $selfDelRes = $this->actingAs($this->admin)->delete("/admin/users/{$this->admin->id}");
        $selfDelRes->assertSessionHas('error');
        $this->assertDatabaseHas('users', ['id' => $this->admin->id]);

        // 5. Admin can delete other user
        $delRes = $this->actingAs($this->admin)->delete("/admin/users/{$userBaru->id}");
        $delRes->assertRedirect('/admin/users');
        $this->assertDatabaseMissing('users', ['id' => $userBaru->id]);
    }
}
