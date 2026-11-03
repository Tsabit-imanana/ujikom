<?php

namespace Database\Seeders;

use App\Models\Pegawai;
use Illuminate\Database\Seeder;

class PegawaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $curated = [
            [
                'nip' => 'PEG-1988051201',
                'nama' => 'Raden Mas Arya Pratama, M.Kom.',
                'jenis_kelamin' => 'Laki-laki',
                'pendidikan_terakhir' => 'S2',
                'tanggal_lahir' => '1988-05-12',
                'jabatan' => 'Kepala Divisi Teknologi Informasi',
                'email' => 'arya.pratama@perusahaan.co.id',
                'telepon' => '081234567890',
                'alamat' => 'Jl. Sudirman No. 45, Jakarta Pusat',
            ],
            [
                'nip' => 'PEG-1992082402',
                'nama' => 'Siti Nurhaliza, S.E.',
                'jenis_kelamin' => 'Perempuan',
                'pendidikan_terakhir' => 'S1',
                'tanggal_lahir' => '1992-08-24',
                'jabatan' => 'Manajer Keuangan',
                'email' => 'siti.nurhaliza@perusahaan.co.id',
                'telepon' => '081398765432',
                'alamat' => 'Jl. Gatot Subroto No. 12, Bandung',
            ],
            [
                'nip' => 'PEG-1996031503',
                'nama' => 'Dimas Wahyu Saputra, S.Kom.',
                'jenis_kelamin' => 'Laki-laki',
                'pendidikan_terakhir' => 'S1',
                'tanggal_lahir' => '1996-03-15',
                'jabatan' => 'Senior Web Developer',
                'email' => 'dimas.wahyu@perusahaan.co.id',
                'telepon' => '082155667788',
                'alamat' => 'Jl. Diponegoro No. 88, Surabaya',
            ],
            [
                'nip' => 'PEG-2001110504',
                'nama' => 'Anisa Putri Maharani, A.Md.',
                'jenis_kelamin' => 'Perempuan',
                'pendidikan_terakhir' => 'D3',
                'tanggal_lahir' => '2001-11-05',
                'jabatan' => 'Staff Administrasi & HR',
                'email' => 'anisa.putri@perusahaan.co.id',
                'telepon' => '085712344321',
                'alamat' => 'Jl. Melati Indah No. 5, Sleman, Yogyakarta',
            ],
            [
                'nip' => 'PEG-1975021805',
                'nama' => 'Dr. Ir. Hendra Kusuma, M.Eng.',
                'jenis_kelamin' => 'Laki-laki',
                'pendidikan_terakhir' => 'S3',
                'tanggal_lahir' => '1975-02-18',
                'jabatan' => 'Direktur Operasional',
                'email' => 'hendra.kusuma@perusahaan.co.id',
                'telepon' => '081199887766',
                'alamat' => 'Jl. Bukit Hijau No. 21, Bogor',
            ],
            [
                'nip' => 'PEG-2003070906',
                'nama' => 'Fajar Sidik Ramadhan',
                'jenis_kelamin' => 'Laki-laki',
                'pendidikan_terakhir' => 'SMA/SMK',
                'tanggal_lahir' => '2003-07-09',
                'jabatan' => 'Teknisi Jaringan & Komputer',
                'email' => 'fajar.sidik@perusahaan.co.id',
                'telepon' => '089877665544',
                'alamat' => 'Jl. Veteran No. 17, Malang',
            ],
            [
                'nip' => 'PEG-1994121907',
                'nama' => 'Dewi Sartika Wijaya, S.Psi.',
                'jenis_kelamin' => 'Perempuan',
                'pendidikan_terakhir' => 'S1',
                'tanggal_lahir' => '1994-12-19',
                'jabatan' => 'Spesialis Rekrutmen SDM',
                'email' => 'dewi.sartika@perusahaan.co.id',
                'telepon' => '087812983476',
                'alamat' => 'Jl. Pahlawan No. 34, Semarang',
            ],
            [
                'nip' => 'PEG-2002042808',
                'nama' => 'Maya Anggraini',
                'jenis_kelamin' => 'Perempuan',
                'pendidikan_terakhir' => 'SMA/SMK',
                'tanggal_lahir' => '2002-04-28',
                'jabatan' => 'Customer Relations Officer',
                'email' => 'maya.anggraini@perusahaan.co.id',
                'telepon' => '083811223344',
                'alamat' => 'Jl. Anggrek No. 9, Solo',
            ],
            [
                'nip' => 'PEG-1982093009',
                'nama' => 'Bambang Eko Santoso, S.T., M.M.',
                'jenis_kelamin' => 'Laki-laki',
                'pendidikan_terakhir' => 'S2',
                'tanggal_lahir' => '1982-09-30',
                'jabatan' => 'Manajer Logistik & Rantai Pasok',
                'email' => 'bambang.eko@perusahaan.co.id',
                'telepon' => '081288776655',
                'alamat' => 'Jl. Ahmad Yani No. 102, Bekasi',
            ],
            [
                'nip' => 'PEG-1999061410',
                'nama' => 'Fitri Indah Lestari, A.Md.Kom.',
                'jenis_kelamin' => 'Perempuan',
                'pendidikan_terakhir' => 'D3',
                'tanggal_lahir' => '1999-06-14',
                'jabatan' => 'Junior UI/UX Designer',
                'email' => 'fitri.indah@perusahaan.co.id',
                'telepon' => '085233445566',
                'alamat' => 'Jl. Hayam Wuruk No. 56, Tangerang',
            ],
        ];

        foreach ($curated as $item) {
            Pegawai::create($item);
        }

        // Generate 25 additional randomized employee records
        Pegawai::factory(25)->create();
    }
}
