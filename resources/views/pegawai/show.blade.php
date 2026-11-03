@extends('layouts.app')

@section('title', 'Detail Pegawai: ' . $pegawai->nama)
@section('page_heading', 'Detail Informasi Pegawai')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header Back Navigation -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-black text-slate-800 tracking-tight">Profil Lengkap Pegawai</h2>
            <p class="text-xs text-slate-500 mt-1">Informasi detail dan biodata pegawai dalam sistem.</p>
        </div>
        <div class="flex items-center space-x-2">
            <a href="{{ route('pegawai.edit', $pegawai) }}" 
               class="inline-flex items-center space-x-2 px-4 py-2 rounded-xl bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold shadow-sm transition">
                <i data-lucide="pencil" class="w-4 h-4"></i>
                <span>Ubah Data</span>
            </a>
            <!-- Delete Form with SweetAlert2 confirmation pop-up (f) -->
            <form id="delete-form-show-{{ $pegawai->id }}" action="{{ route('pegawai.destroy', $pegawai) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="button" 
                        onclick="confirmDelete('delete-form-show-{{ $pegawai->id }}', '{{ addslashes($pegawai->nama) }}')" 
                        class="inline-flex items-center space-x-2 px-4 py-2 rounded-xl bg-rose-50 text-rose-600 hover:bg-rose-100 text-xs font-bold transition">
                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                    <span>Hapus Pegawai</span>
                </button>
            </form>
            <a href="{{ route('pegawai.index') }}" 
               class="inline-flex items-center space-x-2 px-4 py-2 rounded-xl border border-slate-200 text-slate-600 bg-white hover:bg-slate-50 text-xs font-bold transition">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                <span>Kembali</span>
            </a>
        </div>
    </div>

    <!-- Main Profile Card -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
        <!-- Banner Header -->
        <div class="h-32 bg-gradient-to-r from-indigo-700 via-indigo-600 to-violet-600 relative">
            <div class="absolute -bottom-10 left-8 flex items-end space-x-4">
                <div class="w-20 h-20 rounded-2xl bg-white p-1 shadow-xl">
                    <div class="w-full h-full rounded-xl bg-gradient-to-tr from-indigo-600 to-violet-500 text-white font-extrabold flex items-center justify-center text-2xl shadow-inner">
                        {{ $pegawai->inisial }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Body Details -->
        <div class="pt-14 p-8">
            <div class="flex flex-col md:flex-row md:items-center justify-between pb-6 border-b border-slate-100 gap-4">
                <div>
                    <h3 class="text-2xl font-black text-slate-800">{{ $pegawai->nama }}</h3>
                    <p class="text-sm font-semibold text-indigo-600 mt-0.5">{{ $pegawai->jabatan ?? 'Pegawai' }}</p>
                    <p class="text-xs text-slate-400 font-mono mt-1">NIP: {{ $pegawai->nip ?? '-' }}</p>
                </div>
                <div class="flex items-center space-x-2">
                    @if($pegawai->jenis_kelamin === 'Laki-laki')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-700 border border-blue-200">
                            <i data-lucide="user" class="w-3.5 h-3.5 mr-1.5"></i>
                            Laki-laki
                        </span>
                    @else
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-rose-50 text-rose-700 border border-rose-200">
                            <i data-lucide="user" class="w-3.5 h-3.5 mr-1.5"></i>
                            Perempuan
                        </span>
                    @endif

                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                        {{ $pegawai->pendidikan_terakhir }}
                    </span>
                </div>
            </div>

            <!-- Detail Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <!-- Atribut Wajib MUK -->
                <div class="space-y-4">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400 pb-2 border-b border-slate-100">
                        Atribut Pokok Pegawai (MUK)
                    </h4>

                    <div class="flex items-start space-x-3 text-sm">
                        <div class="p-2 rounded-xl bg-slate-100 text-slate-500"><i data-lucide="user-check" class="w-4 h-4"></i></div>
                        <div>
                            <span class="text-xs text-slate-400 block font-medium">Nama Pegawai</span>
                            <span class="font-bold text-slate-800">{{ $pegawai->nama }}</span>
                        </div>
                    </div>

                    <div class="flex items-start space-x-3 text-sm">
                        <div class="p-2 rounded-xl bg-slate-100 text-slate-500"><i data-lucide="users" class="w-4 h-4"></i></div>
                        <div>
                            <span class="text-xs text-slate-400 block font-medium">Jenis Kelamin</span>
                            <span class="font-bold text-slate-800">{{ $pegawai->jenis_kelamin }}</span>
                        </div>
                    </div>

                    <div class="flex items-start space-x-3 text-sm">
                        <div class="p-2 rounded-xl bg-slate-100 text-slate-500"><i data-lucide="graduation-cap" class="w-4 h-4"></i></div>
                        <div>
                            <span class="text-xs text-slate-400 block font-medium">Pendidikan Terakhir</span>
                            <span class="font-bold text-slate-800">{{ $pegawai->pendidikan_terakhir }}</span>
                        </div>
                    </div>

                    <div class="flex items-start space-x-3 text-sm">
                        <div class="p-2 rounded-xl bg-slate-100 text-slate-500"><i data-lucide="calendar" class="w-4 h-4"></i></div>
                        <div>
                            <span class="text-xs text-slate-400 block font-medium">Tanggal Lahir & Usia</span>
                            <span class="font-bold text-slate-800">{{ $pegawai->formatted_tanggal_lahir }}</span>
                            <span class="text-xs text-indigo-600 font-semibold block mt-0.5">
                                {{ $pegawai->usia }} Tahun (Kategori: {{ $pegawai->kelompok_usia }})
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Informasi Kontak & Tambahan -->
                <div class="space-y-4">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400 pb-2 border-b border-slate-100">
                        Kontak & Informasi Tambahan
                    </h4>

                    <div class="flex items-start space-x-3 text-sm">
                        <div class="p-2 rounded-xl bg-slate-100 text-slate-500"><i data-lucide="briefcase" class="w-4 h-4"></i></div>
                        <div>
                            <span class="text-xs text-slate-400 block font-medium">Jabatan / Posisi</span>
                            <span class="font-bold text-slate-800">{{ $pegawai->jabatan ?? '-' }}</span>
                        </div>
                    </div>

                    <div class="flex items-start space-x-3 text-sm">
                        <div class="p-2 rounded-xl bg-slate-100 text-slate-500"><i data-lucide="mail" class="w-4 h-4"></i></div>
                        <div>
                            <span class="text-xs text-slate-400 block font-medium">Email</span>
                            <span class="text-slate-700">{{ $pegawai->email ?? '-' }}</span>
                        </div>
                    </div>

                    <div class="flex items-start space-x-3 text-sm">
                        <div class="p-2 rounded-xl bg-slate-100 text-slate-500"><i data-lucide="phone" class="w-4 h-4"></i></div>
                        <div>
                            <span class="text-xs text-slate-400 block font-medium">Nomor Telepon</span>
                            <span class="font-mono text-slate-700">{{ $pegawai->telepon ?? '-' }}</span>
                        </div>
                    </div>

                    <div class="flex items-start space-x-3 text-sm">
                        <div class="p-2 rounded-xl bg-slate-100 text-slate-500"><i data-lucide="map-pin" class="w-4 h-4"></i></div>
                        <div>
                            <span class="text-xs text-slate-400 block font-medium">Alamat Lengkap</span>
                            <span class="text-slate-700">{{ $pegawai->alamat ?? '-' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Metadata Timestamp -->
            <div class="mt-8 pt-4 border-t border-slate-100 flex items-center justify-between text-xs text-slate-400">
                <span>Ditambahkan: {{ $pegawai->created_at?->translatedFormat('d F Y H:i') ?? '-' }}</span>
                <span>Terakhir Diperbarui: {{ $pegawai->updated_at?->translatedFormat('d F Y H:i') ?? '-' }}</span>
            </div>
        </div>
    </div>
</div>
@endsection
