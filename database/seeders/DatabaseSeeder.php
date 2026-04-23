<?php

namespace Database\Seeders;

use App\Models\Departemen;
use App\Models\Jabatan;
use App\Models\Karyawan;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Livewire\Features\SupportConsoleCommands\Commands\MakeCommand;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name'=>'Admin',
            'email'=>'admin@example.com',
            'password' => Hash::make('password'),

        ]);
        // 2. BUAT DEPARTEMEN
$it = Departemen::create(['name' => 'Teknologi Informasi', 'kode' => 'IT']);
$hrd = Departemen::create(['name' => 'Human Resources', 'kode' => 'HRD']);
$fin = Departemen::create(['name' => 'Keuangan', 'kode' => 'FIN']);
$ops = Departemen::create(['name' => 'Operasional', 'kode' => 'OPS']);

// 3. BUAT JABATAN
$progr = Jabatan::create(['departemen_id' => $it->id, 'nama' => 'Programmer', 'gaji_pokok' => 8_000_000]);
$analyst = Jabatan::create(['departemen_id' => $it->id, 'nama' => 'System Analyst', 'gaji_pokok' => 10_000_000]);
$hrdStaff = Jabatan::create(['departemen_id' => $hrd->id, 'nama' => 'Staff HRD', 'gaji_pokok' => 6_000_000]);
$hrdmgr = Jabatan::create(['departemen_id' => $hrd->id, 'nama' => 'HRD Manager', 'gaji_pokok' => 15_000_000]);
$akuntan = Jabatan::create(['departemen_id' => $fin->id, 'nama' => 'Akuntan', 'gaji_pokok' => 12_000_000]);
$kasir = Jabatan::create(['departemen_id' => $fin->id, 'nama' => 'Kasir', 'gaji_pokok' => 7_000_000]);
$sopir = Jabatan::create(['departemen_id' => $ops->id, 'nama' => 'Sopir', 'gaji_pokok' => 5_000_000]);
$gudang = Jabatan::create(['departemen_id' => $ops->id, 'nama' => 'Staff Gudang', 'gaji_pokok' => 6_000_000]);

$karyawn = [
    ['nik' => 'KRY-001', 'nama' => 'Andi Pratama', 'email' => 'andi.pratama@example.com', 'dept' => $it, 'jabatan' => $progr, 'gaji' => 8_000_000],
    ['nik' => 'KRY-002', 'nama' => 'Budi Santoso', 'email' => 'budi.santoso@example.com', 'dept' => $it, 'jabatan' => $analyst, 'gaji' => 10_000_000],
    ['nik' => 'KRY-003', 'nama' => 'Citra Dewi', 'email' => 'citra.dewi@example.com', 'dept' => $hrd, 'jabatan' => $hrdStaff, 'gaji' => 6_000_000],
    ['nik' => 'KRY-004', 'nama' => 'Dewi Kartika', 'email' => 'dewi.kartika@example.com', 'dept' => $hrd, 'jabatan' => $hrdmgr, 'gaji' => 15_000_000],
    ['nik' => 'KRY-005', 'nama' => 'Eko Prasetyo', 'email' => 'eko.prasetyo@example.com', 'dept' => $fin, 'jabatan' => $akuntan, 'gaji' => 12_000_000],
    ['nik' => 'KRY-006', 'nama' => 'Fajar Nugroho', 'email' => 'fajar.nugroho@example.com', 'dept' => $fin, 'jabatan' => $kasir, 'gaji' => 7_000_000],
    ['nik' => 'KRY-007', 'nama' => 'Gina Puspita', 'email' => 'gina.puspita@example.com', 'dept' => $ops, 'jabatan' => $sopir, 'gaji' => 5_000_000],
    ['nik' => 'KRY-008', 'nama' => 'Hadi Prasetyo', 'email' => 'hadi.prasetyo@example.com', 'dept' => $ops, 'jabatan' => $gudang, 'gaji' => 6_000_000],

  ];

foreach ($karyawn as $data) {
    Karyawan::create([
        'nik' => $data['nik'],
        'nama' => $data['nama'],
        'email' => $data['email'],
        'telepon' => '08' . rand(100_000_000, 9999_999_999),
        'jenis_kelamin' => rand(0, 1) ? 'Laki-laki' : 'Perempuan',
        'tanggal_masuk' => now()->subYears(rand(6, 36))->toDateString(),
        'departemen_id' => $data['dept']->id,
        'jabatan_id' => $data['jabatan']->id,
        'gaji_pokok' => $data['gaji'],
        'tunjangan' => $data['tunj'],
        'status' => 'Aktif',
        'bank' => ['BCA', 'Mandiri', 'BNI', 'BRI'][rand(0, 3)],
        'no_rekening' => '1234' . rand(100_000_000, 999_999_999)
    ]);
    }
}

}