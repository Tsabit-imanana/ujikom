<?php

namespace Database\Factories;

use App\Models\Pegawai;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Pegawai>
 */
class PegawaiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $gender = fake()->randomElement(['Laki-laki', 'Perempuan']);
        $firstName = $gender === 'Laki-laki'
            ? fake()->randomElement(['Ahmad', 'Budi', 'Dedi', 'Eko', 'Fajar', 'Hendra', 'Irfan', 'Joko', 'Rizky', 'Tri', 'Wahyu', 'Yoga', 'Zul'])
            : fake()->randomElement(['Anisa', 'Citra', 'Dewi', 'Endang', 'Fitri', 'Gita', 'Indah', 'Lestari', 'Maya', 'Nurul', 'Putri', 'Siti', 'Yuni']);
        $lastName = fake()->randomElement(['Pratama', 'Saputra', 'Wijaya', 'Kusuma', 'Santoso', 'Utami', 'Hidayat', 'Wibowo', 'Nugroho', 'Setiawan']);
        $name = "$firstName $lastName";

        $pendidikan = fake()->randomElement(['SMA/SMK', 'SMA/SMK', 'D3', 'S1', 'S1', 'S1', 'S2', 'S3']);
        $jabatanList = [
            'Software Engineer',
            'Staff Administrasi',
            'Manajer HRD',
            'Staff Keuangan',
            'Marketing Specialist',
            'UI/UX Designer',
            'Kepala Divisi Operasional',
            'Customer Support',
            'Analis Data',
            'Supervisor Logistik',
        ];

        // Usia antara 20 sampai 58 tahun
        $birthDate = fake()->dateTimeBetween('-58 years', '-20 years')->format('Y-m-d');

        return [
            'nip' => 'PEG-'.fake()->unique()->numerify('#####'),
            'nama' => $name,
            'jenis_kelamin' => $gender,
            'pendidikan_terakhir' => $pendidikan,
            'tanggal_lahir' => $birthDate,
            'jabatan' => fake()->randomElement($jabatanList),
            'email' => fake()->unique()->safeEmail(),
            'telepon' => '08'.fake()->numerify('##########'),
            'alamat' => fake()->streetAddress().', '.fake()->city(),
        ];
    }
}
