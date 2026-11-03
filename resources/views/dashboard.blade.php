@extends('layouts.app')

@section('title', 'Dashboard & Statistik Pegawai')
@section('page_heading', 'Dashboard Statistik')

@section('content')
<div class="space-y-8">
    <!-- Welcome Banner & Quick Action -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-indigo-900 via-indigo-800 to-slate-900 p-6 md:p-8 text-white shadow-xl">
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <span class="inline-flex items-center space-x-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-indigo-500/30 text-indigo-200 border border-indigo-400/30 mb-3">
                    <i data-lucide="award" class="w-3.5 h-3.5 text-amber-400"></i>
                    <span>Sistem Manajemen Kepegawaian (MUK)</span>
                </span>
                <h2 class="text-2xl md:text-3xl font-extrabold tracking-tight">Selamat Datang, {{ auth()->user()->name }}!</h2>
                <p class="text-sm text-indigo-200 mt-1 max-w-xl">
                    Pantau demografi pegawai secara komprehensif melalui grafik interaktif perbandingan jenis kelamin, jenjang pendidikan terakhir, dan distribusi usia.
                </p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('pegawai.create') }}" class="px-5 py-2.5 rounded-xl font-bold text-xs uppercase tracking-wider bg-white text-indigo-900 hover:bg-indigo-50 shadow-lg shadow-black/10 transition flex items-center space-x-2">
                    <i data-lucide="user-plus" class="w-4 h-4 text-indigo-600"></i>
                    <span>Tambah Pegawai Baru</span>
                </a>
            </div>
        </div>
        <!-- Decorative Glow -->
        <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-indigo-500/20 rounded-full blur-3xl pointer-events-none"></div>
    </div>

    <!-- Summary KPI Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <!-- Card 1: Total Pegawai -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Pegawai</p>
                    <h3 class="text-3xl font-black text-slate-800 mt-1">{{ $totalPegawai }}</h3>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                    <i data-lucide="users" class="w-6 h-6"></i>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                <span>Terdata aktif di sistem</span>
                <span class="font-semibold text-indigo-600">100%</span>
            </div>
        </div>

        <!-- Card 2: Laki-laki -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Laki-laki</p>
                    <h3 class="text-3xl font-black text-blue-600 mt-1">{{ $lakiLakiCount }}</h3>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center">
                    <i data-lucide="user" class="w-6 h-6"></i>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                <span>Proporsi pegawai pria</span>
                <span class="font-bold text-blue-600">{{ $lakiPercent }}%</span>
            </div>
        </div>

        <!-- Card 3: Perempuan -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Perempuan</p>
                    <h3 class="text-3xl font-black text-rose-500 mt-1">{{ $perempuanCount }}</h3>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-500 flex items-center justify-center">
                    <i data-lucide="user" class="w-6 h-6"></i>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                <span>Proporsi pegawai wanita</span>
                <span class="font-bold text-rose-500">{{ $perempuanPercent }}%</span>
            </div>
        </div>

        <!-- Card 4: Rata-rata Usia -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Rata-rata Usia</p>
                    <h3 class="text-3xl font-black text-emerald-600 mt-1">{{ $averageAge }} <span class="text-base font-semibold text-slate-400">Thn</span></h3>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    <i data-lucide="calendar" class="w-6 h-6"></i>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                <span>Rentang umur</span>
                <span class="font-semibold text-slate-700">{{ $minAge }} - {{ $maxAge }} Thn</span>
            </div>
        </div>
    </div>

    <!-- 3 GRAFIK UTAMA SESUAI KETENTUAN MUK (e) -->
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-bold text-slate-800">Visualisasi Grafik Demografi Pegawai</h3>
                <p class="text-xs text-slate-500">Memenuhi ketentuan Materi Uji Kompetensi poin (e)</p>
            </div>
            <span class="text-xs font-medium bg-indigo-50 text-indigo-700 px-3 py-1 rounded-full border border-indigo-200">
                3 Grafik Terpadu
            </span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Grafik 1: Perbandingan Jumlah Pegawai Laki-laki dan Perempuan -->
            <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center space-x-2">
                            <span class="w-3 h-3 rounded-full bg-blue-500"></span>
                            <h4 class="font-bold text-slate-800 text-sm">1. Rasio Jenis Kelamin</h4>
                        </div>
                        <span class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Donut Chart</span>
                    </div>
                    <p class="text-xs text-slate-500 mb-6">Grafik perbandingan jumlah pegawai laki-laki dan perempuan.</p>

                    <!-- Chart Container -->
                    <div class="relative h-64 flex items-center justify-center">
                        <canvas id="genderChartCanvas"></canvas>
                    </div>
                </div>

                <!-- Custom Stat Legend -->
                <div class="grid grid-cols-2 gap-3 mt-6 pt-4 border-t border-slate-100">
                    <div class="p-2.5 rounded-xl bg-blue-50/70 border border-blue-100 text-center">
                        <span class="text-[11px] text-blue-700 block font-semibold">Laki-laki</span>
                        <span class="text-lg font-black text-blue-800">{{ $lakiLakiCount }}</span>
                        <span class="text-xs text-blue-600 block">({{ $lakiPercent }}%)</span>
                    </div>
                    <div class="p-2.5 rounded-xl bg-rose-50/70 border border-rose-100 text-center">
                        <span class="text-[11px] text-rose-700 block font-semibold">Perempuan</span>
                        <span class="text-lg font-black text-rose-800">{{ $perempuanCount }}</span>
                        <span class="text-xs text-rose-600 block">({{ $perempuanPercent }}%)</span>
                    </div>
                </div>
            </div>

            <!-- Grafik 2: Pendidikan Terakhir Pegawai -->
            <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center space-x-2">
                            <span class="w-3 h-3 rounded-full bg-emerald-500"></span>
                            <h4 class="font-bold text-slate-800 text-sm">2. Pendidikan Terakhir</h4>
                        </div>
                        <span class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Bar Chart</span>
                    </div>
                    <p class="text-xs text-slate-500 mb-6">Grafik jenjang pendidikan formal terakhir seluruh pegawai.</p>

                    <!-- Chart Container -->
                    <div class="relative h-64">
                        <canvas id="educationChartCanvas"></canvas>
                    </div>
                </div>

                <div class="mt-6 pt-4 border-t border-slate-100 text-center text-xs text-slate-400">
                    Distribusi berdasar kualifikasi jenjang SD hingga S3
                </div>
            </div>

            <!-- Grafik 3: Grafik Usia Pegawai -->
            <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center space-x-2">
                            <span class="w-3 h-3 rounded-full bg-amber-500"></span>
                            <h4 class="font-bold text-slate-800 text-sm">3. Distribusi Usia</h4>
                        </div>
                        <span class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Age Group Chart</span>
                    </div>
                    <p class="text-xs text-slate-500 mb-6">Grafik kelompok usia pegawai dihitung dari tanggal lahir.</p>

                    <!-- Chart Container -->
                    <div class="relative h-64">
                        <canvas id="ageChartCanvas"></canvas>
                    </div>
                </div>

                <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500 px-2">
                    <span>Termuda: <strong class="text-slate-800">{{ $minAge }} Thn</strong></span>
                    <span>Tertua: <strong class="text-slate-800">{{ $maxAge }} Thn</strong></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel 5 Pegawai Terakhir Ditambahkan -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h3 class="text-base font-bold text-slate-800">Pegawai Terbaru Ditambahkan</h3>
                <p class="text-xs text-slate-400">5 data pegawai terakhir yang tersimpan dalam sistem</p>
            </div>
            <a href="{{ route('pegawai.index') }}" class="inline-flex items-center space-x-1.5 text-xs font-bold text-indigo-600 hover:text-indigo-800 transition">
                <span>Lihat Seluruh Pegawai</span>
                <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50 text-[11px] uppercase font-bold text-slate-400 border-b border-slate-100 tracking-wider">
                    <tr>
                        <th class="px-6 py-3.5">Pegawai</th>
                        <th class="px-6 py-3.5">Jenis Kelamin</th>
                        <th class="px-6 py-3.5">Pendidikan</th>
                        <th class="px-6 py-3.5">Tanggal Lahir / Usia</th>
                        <th class="px-6 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($recentPegawai as $p)
                        <tr class="hover:bg-slate-50/60 transition">
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-indigo-500 to-violet-500 text-white font-bold flex items-center justify-center text-xs shadow-sm">
                                        {{ $p->inisial }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-800 text-sm">{{ $p->nama }}</p>
                                        <p class="text-xs text-slate-400 font-mono">NIP: {{ $p->nip ?? '-' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if($p->jenis_kelamin === 'Laki-laki')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200">
                                        Laki-laki
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-200">
                                        Perempuan
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-700">
                                    {{ $p->pendidikan_terakhir }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-slate-700 text-xs font-medium">{{ $p->formatted_tanggal_lahir }}</p>
                                <p class="text-[11px] text-slate-400">{{ $p->usia }} Tahun</p>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="inline-flex items-center space-x-2">
                                    <button type="button" 
                                            onclick="openPegawaiModal({{ $p->id }})" 
                                            class="p-2 rounded-lg bg-indigo-50 text-indigo-600 hover:bg-indigo-100 transition"
                                            title="Lihat Detail">
                                        <i data-lucide="eye" class="w-4 h-4"></i>
                                    </button>
                                    <a href="{{ route('pegawai.edit', $p) }}" 
                                       class="p-2 rounded-lg bg-amber-50 text-amber-600 hover:bg-amber-100 transition"
                                       title="Ubah Data">
                                        <i data-lucide="pencil" class="w-4 h-4"></i>
                                    </a>
                                    <!-- Delete Button with SweetAlert Pop-up Konfirmasi (f) -->
                                    <form id="delete-form-recent-{{ $p->id }}" action="{{ route('pegawai.destroy', $p) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" 
                                                onclick="confirmDelete('delete-form-recent-{{ $p->id }}', '{{ addslashes($p->nama) }}')" 
                                                class="p-2 rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-100 transition"
                                                title="Hapus Pegawai">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-slate-400 text-sm">
                                Belum ada data pegawai. Silakan tambah data pegawai pertama Anda.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    // 1. Inisialisasi Grafik Rasio Jenis Kelamin (Donut Chart)
    const genderCtx = document.getElementById('genderChartCanvas');
    if (genderCtx) {
        new Chart(genderCtx, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($genderChart['labels']) !!},
                datasets: [{
                    data: {!! json_encode($genderChart['data']) !!},
                    backgroundColor: ['#3b82f6', '#f43f5e'],
                    hoverBackgroundColor: ['#2563eb', '#e11d48'],
                    borderWidth: 3,
                    borderColor: '#ffffff',
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 16,
                            usePointStyle: true,
                            pointStyle: 'circle',
                            font: { family: "'Plus Jakarta Sans', sans-serif", size: 12, weight: '600' }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const val = context.parsed;
                                const pct = total > 0 ? ((val / total) * 100).toFixed(1) : 0;
                                return ` ${context.label}: ${val} orang (${pct}%)`;
                            }
                        }
                    }
                },
                cutout: '68%',
            }
        });
    }

    // 2. Inisialisasi Grafik Pendidikan Terakhir (Bar Chart)
    const eduCtx = document.getElementById('educationChartCanvas');
    if (eduCtx) {
        new Chart(eduCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($educationChart['labels']) !!},
                datasets: [{
                    label: 'Jumlah Pegawai',
                    data: {!! json_encode($educationChart['data']) !!},
                    backgroundColor: [
                        '#64748b', '#0ea5e9', '#06b6d4', '#10b981', '#6366f1', '#8b5cf6', '#d946ef'
                    ],
                    borderRadius: 8,
                    maxBarThickness: 32,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: (ctx) => ` Jumlah: ${ctx.parsed.y} orang`
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1, precision: 0 },
                        grid: { color: '#f1f5f9' }
                    },
                    x: {
                        grid: { display: false }
                    }
                }
            }
        });
    }

    // 3. Inisialisasi Grafik Usia Pegawai (Bar Chart)
    const ageCtx = document.getElementById('ageChartCanvas');
    if (ageCtx) {
        new Chart(ageCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($ageChart['labels']) !!},
                datasets: [{
                    label: 'Jumlah Pegawai',
                    data: {!! json_encode($ageChart['data']) !!},
                    backgroundColor: '#f59e0b',
                    hoverBackgroundColor: '#d97706',
                    borderRadius: 8,
                    maxBarThickness: 36,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: (ctx) => ` Rentang Usia: ${ctx.parsed.y} orang`
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1, precision: 0 },
                        grid: { color: '#f1f5f9' }
                    },
                    x: {
                        grid: { display: false }
                    }
                }
            }
        });
    }
});
</script>
@endpush
