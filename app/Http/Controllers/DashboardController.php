<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Tampilkan dashboard utama data pegawai dengan ringkasan & 3 grafik statistik.
     */
    public function index(): View
    {
        $allPegawai = Pegawai::all();
        $totalPegawai = $allPegawai->count();

        // 1. Grafik Jenis Kelamin (Laki-laki vs Perempuan)
        $lakiLakiCount = $allPegawai->where('jenis_kelamin', 'Laki-laki')->count();
        $perempuanCount = $allPegawai->where('jenis_kelamin', 'Perempuan')->count();

        $lakiPercent = $totalPegawai > 0 ? round(($lakiLakiCount / $totalPegawai) * 100, 1) : 0;
        $perempuanPercent = $totalPegawai > 0 ? round(($perempuanCount / $totalPegawai) * 100, 1) : 0;

        $genderChart = [
            'labels' => ['Laki-laki', 'Perempuan'],
            'data' => [$lakiLakiCount, $perempuanCount],
            'percentages' => [$lakiPercent, $perempuanPercent],
        ];

        // 2. Grafik Pendidikan Terakhir
        $jenjangPendidikan = ['SD', 'SMP', 'SMA/SMK', 'D3', 'S1', 'S2', 'S3'];
        $pendidikanCounts = [];
        foreach ($jenjangPendidikan as $jenjang) {
            $pendidikanCounts[] = $allPegawai->where('pendidikan_terakhir', $jenjang)->count();
        }

        $educationChart = [
            'labels' => $jenjangPendidikan,
            'data' => $pendidikanCounts,
        ];

        // 3. Grafik Usia Pegawai (Distribusi Kelompok Usia)
        $ageCategories = [
            '< 25 Thn' => 0,
            '25 - 34 Thn' => 0,
            '35 - 44 Thn' => 0,
            '45 - 54 Thn' => 0,
            '≥ 55 Thn' => 0,
        ];

        $ages = [];
        foreach ($allPegawai as $pegawai) {
            $usia = $pegawai->usia;
            $ages[] = $usia;

            if ($usia < 25) {
                $ageCategories['< 25 Thn']++;
            } elseif ($usia <= 34) {
                $ageCategories['25 - 34 Thn']++;
            } elseif ($usia <= 44) {
                $ageCategories['35 - 44 Thn']++;
            } elseif ($usia <= 54) {
                $ageCategories['45 - 54 Thn']++;
            } else {
                $ageCategories['≥ 55 Thn']++;
            }
        }

        $ageChart = [
            'labels' => array_keys($ageCategories),
            'data' => array_values($ageCategories),
        ];

        // Statistik Tambahan
        $averageAge = count($ages) > 0 ? round(array_sum($ages) / count($ages), 1) : 0;
        $minAge = count($ages) > 0 ? min($ages) : 0;
        $maxAge = count($ages) > 0 ? max($ages) : 0;

        // Pegawai Terbaru
        $recentPegawai = Pegawai::latest()->take(5)->get();

        return view('dashboard', compact(
            'totalPegawai',
            'lakiLakiCount',
            'perempuanCount',
            'lakiPercent',
            'perempuanPercent',
            'genderChart',
            'educationChart',
            'ageChart',
            'averageAge',
            'minAge',
            'maxAge',
            'recentPegawai'
        ));
    }
}
