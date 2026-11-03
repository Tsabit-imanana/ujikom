@extends('layouts.app')

@section('title', 'Data Pegawai')
@section('page_heading', 'Kelola Data Pegawai')

@section('content')
<div class="space-y-6">
    <!-- Header Title & Action Buttons -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-black text-slate-800 tracking-tight">Daftar Data Pegawai</h2>
            <p class="text-xs text-slate-500 mt-1">Kelola informasi pegawai, lakukan pencarian, filtering, ubah dan hapus data.</p>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('pegawai.export') }}" 
               class="inline-flex items-center space-x-2 px-4 py-2.5 rounded-xl border border-slate-200 text-slate-700 bg-white hover:bg-slate-50 shadow-sm text-xs font-bold transition">
                <i data-lucide="download" class="w-4 h-4 text-slate-500"></i>
                <span>Unduh CSV</span>
            </a>
            <a href="{{ route('pegawai.create') }}" 
               class="inline-flex items-center space-x-2 px-4 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white shadow-md shadow-indigo-600/25 text-xs font-bold transition">
                <i data-lucide="plus" class="w-4 h-4"></i>
                <span>Tambah Pegawai Baru</span>
            </a>
        </div>
    </div>

    <!-- Search & Filter Card -->
    <div class="bg-white p-5 rounded-3xl border border-slate-200/80 shadow-sm">
        <form method="GET" action="{{ route('pegawai.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
            <!-- Search Keyword -->
            <div class="lg:col-span-2">
                <label for="search" class="block text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-1">Cari Pegawai</label>
                <div class="relative">
                    <input type="text" 
                           name="search" 
                           id="search" 
                           value="{{ request('search') }}" 
                           placeholder="Cari nama, NIP, jabatan..." 
                           class="w-full pl-9 pr-3 py-2 text-xs rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
                    <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3 top-2.5 pointer-events-none"></i>
                </div>
            </div>

            <!-- Filter Jenis Kelamin -->
            <div>
                <label for="jenis_kelamin" class="block text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-1">Jenis Kelamin</label>
                <select name="jenis_kelamin" id="jenis_kelamin" class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
                    <option value="">Semua Jenis Kelamin</option>
                    <option value="Laki-laki" {{ request('jenis_kelamin') === 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="Perempuan" {{ request('jenis_kelamin') === 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>

            <!-- Filter Pendidikan Terakhir -->
            <div>
                <label for="pendidikan_terakhir" class="block text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-1">Pendidikan</label>
                <select name="pendidikan_terakhir" id="pendidikan_terakhir" class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
                    <option value="">Semua Pendidikan</option>
                    @foreach($jenjangPendidikan as $jenjang)
                        <option value="{{ $jenjang }}" {{ request('pendidikan_terakhir') === $jenjang ? 'selected' : '' }}>
                            {{ $jenjang }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Filter Actions -->
            <div class="flex items-end space-x-2">
                <button type="submit" class="flex-1 py-2 px-3 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs transition flex items-center justify-center space-x-1">
                    <i data-lucide="filter" class="w-3.5 h-3.5"></i>
                    <span>Terapkan</span>
                </button>
                @if(request()->hasAny(['search', 'jenis_kelamin', 'pendidikan_terakhir', 'sort']))
                    <a href="{{ route('pegawai.index') }}" class="p-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 transition" title="Reset Filter">
                        <i data-lucide="rotate-ccw" class="w-4 h-4"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Data Table Container -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50 text-[11px] uppercase font-bold text-slate-400 border-b border-slate-100 tracking-wider">
                    <tr>
                        <th class="px-6 py-4">No</th>
                        <th class="px-6 py-4">NIP & Nama Pegawai</th>
                        <th class="px-6 py-4">Jenis Kelamin</th>
                        <th class="px-6 py-4">Pendidikan Terakhir</th>
                        <th class="px-6 py-4">Tanggal Lahir & Usia</th>
                        <th class="px-6 py-4">Jabatan</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($pegawaiList as $index => $pegawai)
                        <tr class="hover:bg-slate-50/70 transition duration-150">
                            <!-- Nomor Urut -->
                            <td class="px-6 py-4 font-mono text-xs text-slate-400">
                                {{ $pegawaiList->firstItem() + $index }}
                            </td>

                            <!-- NIP & Nama Pegawai (Atribut Wajib A) -->
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-indigo-500 to-violet-500 text-white font-bold flex items-center justify-center text-xs shadow-sm flex-shrink-0">
                                        {{ $pegawai->inisial }}
                                    </div>
                                    <div>
                                        <a href="{{ route('pegawai.show', $pegawai) }}" class="font-bold text-slate-800 hover:text-indigo-600 transition text-sm">
                                            {{ $pegawai->nama }}
                                        </a>
                                        <p class="text-xs text-slate-400 font-mono mt-0.5">NIP: {{ $pegawai->nip ?? '-' }}</p>
                                    </div>
                                </div>
                            </td>

                            <!-- Jenis Kelamin (Atribut Wajib B) -->
                            <td class="px-6 py-4">
                                @if($pegawai->jenis_kelamin === 'Laki-laki')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200">
                                        <i data-lucide="user" class="w-3 h-3 mr-1"></i>
                                        Laki-laki
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-200">
                                        <i data-lucide="user" class="w-3 h-3 mr-1"></i>
                                        Perempuan
                                    </span>
                                @endif
                            </td>

                            <!-- Pendidikan Terakhir (Atribut Wajib C) -->
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-700 border border-slate-200">
                                    {{ $pegawai->pendidikan_terakhir }}
                                </span>
                            </td>

                            <!-- Tanggal Lahir (Atribut Wajib D) -->
                            <td class="px-6 py-4">
                                <p class="text-slate-800 text-xs font-semibold">{{ $pegawai->formatted_tanggal_lahir }}</p>
                                <p class="text-[11px] text-slate-400 font-medium">Usia: <span class="text-indigo-600 font-bold">{{ $pegawai->usia }} Tahun</span></p>
                            </td>

                            <!-- Jabatan -->
                            <td class="px-6 py-4 text-xs font-medium text-slate-700">
                                {{ $pegawai->jabatan ?? '-' }}
                            </td>

                            <!-- Aksi (Detail, Ubah, Hapus dengan Pop-up Konfirmasi F) -->
                            <td class="px-6 py-4 text-center">
                                <div class="inline-flex items-center space-x-1.5">
                                    <!-- Modal Quick Detail -->
                                    <button type="button" 
                                            onclick="openPegawaiModal({{ $pegawai->id }})" 
                                            class="p-2 rounded-xl bg-slate-100 text-slate-600 hover:bg-indigo-50 hover:text-indigo-600 transition"
                                            title="Lihat Detail Singkat">
                                        <i data-lucide="eye" class="w-4 h-4"></i>
                                    </button>

                                    <!-- Ubah Data Pegawai -->
                                    <a href="{{ route('pegawai.edit', $pegawai) }}" 
                                       class="p-2 rounded-xl bg-slate-100 text-slate-600 hover:bg-amber-50 hover:text-amber-600 transition"
                                       title="Ubah Data">
                                        <i data-lucide="pencil" class="w-4 h-4"></i>
                                    </a>

                                    <!-- Hapus Data Pegawai dengan Pop-up Konfirmasi (Ketentuan F) -->
                                    <form id="delete-form-{{ $pegawai->id }}" action="{{ route('pegawai.destroy', $pegawai) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" 
                                                onclick="confirmDelete('delete-form-{{ $pegawai->id }}', '{{ addslashes($pegawai->nama) }}')" 
                                                class="p-2 rounded-xl bg-slate-100 text-slate-600 hover:bg-rose-50 hover:text-rose-600 transition"
                                                title="Hapus Pegawai">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-slate-400">
                                <div class="flex flex-col items-center justify-center space-y-3">
                                    <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center text-slate-400">
                                        <i data-lucide="inbox" class="w-6 h-6"></i>
                                    </div>
                                    <p class="text-sm font-semibold text-slate-600">Tidak ada data pegawai yang ditemukan.</p>
                                    <p class="text-xs text-slate-400">Coba ganti kata kunci pencarian atau reset filter Anda.</p>
                                    @if(request()->hasAny(['search', 'jenis_kelamin', 'pendidikan_terakhir']))
                                        <a href="{{ route('pegawai.index') }}" class="text-xs font-bold text-indigo-600 hover:underline">
                                            Reset Pencarian
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Controls -->
        @if($pegawaiList->hasPages() || $pegawaiList->total() > 0)
            <div class="p-6 border-t border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="text-xs text-slate-500">
                    Menampilkan <span class="font-bold text-slate-800">{{ $pegawaiList->firstItem() ?? 0 }}</span> sampai 
                    <span class="font-bold text-slate-800">{{ $pegawaiList->lastItem() ?? 0 }}</span> dari 
                    <span class="font-bold text-slate-800">{{ $pegawaiList->total() }}</span> total pegawai
                </div>
                <div>
                    {{ $pegawaiList->links() }}
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
