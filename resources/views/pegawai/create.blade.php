@extends('layouts.app')

@section('title', 'Tambah Pegawai Baru')
@section('page_heading', 'Tambah Pegawai Baru')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header Back Navigation -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-black text-slate-800 tracking-tight">Formulir Tambah Pegawai</h2>
            <p class="text-xs text-slate-500 mt-1">Lengkapi data pegawai baru sesuai kriteria instrumen MUK.</p>
        </div>
        <a href="{{ route('pegawai.index') }}" 
           class="inline-flex items-center space-x-2 px-4 py-2 rounded-xl border border-slate-200 text-slate-600 bg-white hover:bg-slate-50 text-xs font-bold transition">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            <span>Kembali ke Daftar</span>
        </a>
    </div>

    <!-- Main Form Card -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="p-6 md:p-8">
            <form action="{{ route('pegawai.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Section 1: Atribut Utama / Minimal Ketentuan MUK (Wajib) -->
                <div>
                    <div class="flex items-center space-x-2 pb-3 mb-4 border-b border-slate-100">
                        <span class="w-2.5 h-2.5 rounded-full bg-indigo-600"></span>
                        <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider">Atribut Pokok Pegawai (Ketentuan Utama MUK)</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <!-- 1. Nama Pegawai (Wajib) -->
                        <div class="md:col-span-2">
                            <label for="nama" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                Nama Lengkap Pegawai <span class="text-rose-500 font-bold">*</span>
                            </label>
                            <input type="text" 
                                   name="nama" 
                                   id="nama" 
                                   value="{{ old('nama') }}" 
                                   placeholder="Contoh: Raden Mas Arya Pratama, S.Kom."
                                   required
                                   class="w-full px-4 py-2.5 rounded-xl border @error('nama') border-rose-500 bg-rose-50/20 @else border-slate-200 bg-slate-50 @enderror focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm transition">
                            @error('nama')
                                <p class="text-xs text-rose-500 mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- 2. Jenis Kelamin (Wajib) -->
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                                Jenis Kelamin <span class="text-rose-500 font-bold">*</span>
                            </label>
                            <div class="grid grid-cols-2 gap-3">
                                <label class="relative flex items-center justify-center p-3 rounded-xl border cursor-pointer hover:bg-slate-50 transition {{ old('jenis_kelamin') === 'Laki-laki' ? 'border-indigo-600 bg-indigo-50/30' : 'border-slate-200' }}">
                                    <input type="radio" name="jenis_kelamin" value="Laki-laki" {{ old('jenis_kelamin', 'Laki-laki') === 'Laki-laki' ? 'checked' : '' }} class="sr-only">
                                    <div class="flex items-center space-x-2 text-xs font-bold text-slate-700">
                                        <i data-lucide="user" class="w-4 h-4 text-blue-500"></i>
                                        <span>Laki-laki</span>
                                    </div>
                                </label>
                                <label class="relative flex items-center justify-center p-3 rounded-xl border cursor-pointer hover:bg-slate-50 transition {{ old('jenis_kelamin') === 'Perempuan' ? 'border-indigo-600 bg-indigo-50/30' : 'border-slate-200' }}">
                                    <input type="radio" name="jenis_kelamin" value="Perempuan" {{ old('jenis_kelamin') === 'Perempuan' ? 'checked' : '' }} class="sr-only">
                                    <div class="flex items-center space-x-2 text-xs font-bold text-slate-700">
                                        <i data-lucide="user" class="w-4 h-4 text-rose-500"></i>
                                        <span>Perempuan</span>
                                    </div>
                                </label>
                            </div>
                            @error('jenis_kelamin')
                                <p class="text-xs text-rose-500 mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- 3. Pendidikan Terakhir (Wajib) -->
                        <div>
                            <label for="pendidikan_terakhir" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                Pendidikan Terakhir <span class="text-rose-500 font-bold">*</span>
                            </label>
                            <select name="pendidikan_terakhir" 
                                    id="pendidikan_terakhir" 
                                    required
                                    class="w-full px-4 py-2.5 rounded-xl border @error('pendidikan_terakhir') border-rose-500 bg-rose-50/20 @else border-slate-200 bg-slate-50 @enderror focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm transition">
                                <option value="" disabled {{ old('pendidikan_terakhir') ? '' : 'selected' }}>Pilih Jenjang Pendidikan</option>
                                @foreach($jenjangPendidikan as $jenjang)
                                    <option value="{{ $jenjang }}" {{ old('pendidikan_terakhir') === $jenjang ? 'selected' : '' }}>
                                        {{ $jenjang }}
                                    </option>
                                @endforeach
                            </select>
                            @error('pendidikan_terakhir')
                                <p class="text-xs text-rose-500 mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- 4. Tanggal Lahir (Wajib) -->
                        <div>
                            <label for="tanggal_lahir" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                Tanggal Lahir <span class="text-rose-500 font-bold">*</span>
                            </label>
                            <input type="date" 
                                   name="tanggal_lahir" 
                                   id="tanggal_lahir" 
                                   value="{{ old('tanggal_lahir') }}" 
                                   max="{{ date('Y-m-d') }}"
                                   required
                                   class="w-full px-4 py-2.5 rounded-xl border @error('tanggal_lahir') border-rose-500 bg-rose-50/20 @else border-slate-200 bg-slate-50 @enderror focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm transition">
                            <p class="text-[11px] text-slate-400 mt-1">Usia pegawai akan dihitung otomatis untuk visualisasi grafik.</p>
                            @error('tanggal_lahir')
                                <p class="text-xs text-rose-500 mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- NIP (Nomor Induk Pegawai) -->
                        <div>
                            <label for="nip" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                Nomor Induk Pegawai (NIP)
                            </label>
                            <input type="text" 
                                   name="nip" 
                                   id="nip" 
                                   value="{{ old('nip') }}" 
                                   placeholder="Kosongkan jika ingin digenerate otomatis"
                                   class="w-full px-4 py-2.5 rounded-xl border @error('nip') border-rose-500 bg-rose-50/20 @else border-slate-200 bg-slate-50 @enderror focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm font-mono transition">
                            <p class="text-[11px] text-slate-400 mt-1">Format rekomendasi: PEG-YYYYMMDDXXX</p>
                            @error('nip')
                                <p class="text-xs text-rose-500 mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Section 2: Informasi Tambahan & Kontak -->
                <div class="pt-4 border-t border-slate-100">
                    <div class="flex items-center space-x-2 pb-3 mb-4 border-b border-slate-100">
                        <span class="w-2.5 h-2.5 rounded-full bg-slate-400"></span>
                        <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider">Informasi Jabatan & Kontak</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                        <!-- Jabatan -->
                        <div>
                            <label for="jabatan" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                Posisi / Jabatan
                            </label>
                            <input type="text" 
                                   name="jabatan" 
                                   id="jabatan" 
                                   value="{{ old('jabatan') }}" 
                                   placeholder="Contoh: Staff IT / HRD"
                                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm transition">
                            @error('jabatan')
                                <p class="text-xs text-rose-500 mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                Alamat Email
                            </label>
                            <input type="email" 
                                   name="email" 
                                   id="email" 
                                   value="{{ old('email') }}" 
                                   placeholder="pegawai@perusahaan.co.id"
                                   class="w-full px-4 py-2.5 rounded-xl border @error('email') border-rose-500 bg-rose-50/20 @else border-slate-200 bg-slate-50 @enderror focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm transition">
                            @error('email')
                                <p class="text-xs text-rose-500 mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Nomor Telepon -->
                        <div>
                            <label for="telepon" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                Nomor Telepon / HP
                            </label>
                            <input type="text" 
                                   name="telepon" 
                                   id="telepon" 
                                   value="{{ old('telepon') }}" 
                                   placeholder="Contoh: 08123456789"
                                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm transition">
                            @error('telepon')
                                <p class="text-xs text-rose-500 mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Alamat Lengkap -->
                        <div class="md:col-span-3">
                            <label for="alamat" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                Alamat Tempat Tinggal
                            </label>
                            <textarea name="alamat" 
                                      id="alamat" 
                                      rows="2" 
                                      placeholder="Nama jalan, nomor rumah, RT/RW, kota/kabupaten..."
                                      class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm transition">{{ old('alamat') }}</textarea>
                            @error('alamat')
                                <p class="text-xs text-rose-500 mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Form Action Buttons -->
                <div class="pt-6 border-t border-slate-100 flex items-center justify-end space-x-3">
                    <a href="{{ route('pegawai.index') }}" 
                       class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-100 text-xs font-bold transition">
                        Batal
                    </a>
                    <button type="submit" 
                            class="px-6 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs shadow-md shadow-indigo-600/30 transition flex items-center space-x-2">
                        <i data-lucide="check" class="w-4 h-4"></i>
                        <span>Simpan Data Pegawai</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
