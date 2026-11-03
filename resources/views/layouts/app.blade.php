<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - SIMPEG (Sistem Manajemen Pegawai)</title>
    
    <!-- Google Fonts Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
    @stack('styles')
</head>
<body class="h-full text-slate-800 antialiased bg-slate-50 selection:bg-indigo-500 selection:text-white">
    <div class="min-h-screen flex flex-col md:flex-row">
        <!-- Sidebar -->
        <aside class="w-full md:w-64 bg-slate-900 text-slate-300 flex-shrink-0 border-r border-slate-800 flex flex-col justify-between">
            <div>
                <!-- Brand Header -->
                <div class="px-6 py-5 border-b border-slate-800/80 flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-indigo-500 via-indigo-600 to-violet-500 flex items-center justify-center text-white shadow-lg shadow-indigo-500/20 font-extrabold text-lg">
                            SP
                        </div>
                        <div>
                            <h1 class="text-base font-bold text-white tracking-tight leading-tight">SIMPEG</h1>
                            <p class="text-xs text-indigo-400 font-medium">Manajemen Pegawai</p>
                        </div>
                    </div>
                </div>

                <!-- Navigation Links -->
                <nav class="p-4 space-y-1.5 text-sm font-medium">
                    <a href="{{ route('dashboard') }}" 
                       class="flex items-center space-x-3 px-3.5 py-2.5 rounded-xl transition duration-150 {{ request()->routeIs('dashboard') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/30' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                        <i data-lucide="layout-dashboard" class="w-5 h-5 flex-shrink-0"></i>
                        <span>Dashboard & Grafik</span>
                    </a>

                    <a href="{{ route('pegawai.index') }}" 
                       class="flex items-center space-x-3 px-3.5 py-2.5 rounded-xl transition duration-150 {{ request()->routeIs('pegawai.index', 'pegawai.show', 'pegawai.edit') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/30' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                        <i data-lucide="users" class="w-5 h-5 flex-shrink-0"></i>
                        <span>Data Pegawai</span>
                    </a>

                    <a href="{{ route('pegawai.create') }}" 
                       class="flex items-center space-x-3 px-3.5 py-2.5 rounded-xl transition duration-150 {{ request()->routeIs('pegawai.create') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/30' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                        <i data-lucide="user-plus" class="w-5 h-5 flex-shrink-0"></i>
                        <span>Tambah Pegawai</span>
                    </a>

                    <a href="{{ route('pegawai.export') }}" 
                       class="flex items-center space-x-3 px-3.5 py-2.5 rounded-xl transition duration-150 text-slate-400 hover:text-white hover:bg-slate-800/60">
                        <i data-lucide="file-spreadsheet" class="w-5 h-5 flex-shrink-0"></i>
                        <span>Export CSV</span>
                    </a>
                </nav>
            </div>

            <!-- User Footer in Sidebar -->
            <div class="p-4 border-t border-slate-800/80 bg-slate-950/40">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-9 h-9 rounded-xl bg-slate-800 text-indigo-400 flex items-center justify-center font-bold text-sm border border-slate-700">
                            {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
                        </div>
                        <div class="overflow-hidden">
                            <p class="text-xs font-semibold text-white truncate max-w-[120px]">{{ auth()->user()->name ?? 'Admin' }}</p>
                            <p class="text-[11px] text-slate-400 truncate max-w-[120px]">{{ auth()->user()->email ?? 'admin@ujikom.test' }}</p>
                        </div>
                    </div>

                    <!-- Logout Button -->
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" title="Keluar dari sistem" class="p-2 text-slate-400 hover:text-rose-400 hover:bg-rose-950/30 rounded-lg transition">
                            <i data-lucide="log-out" class="w-4 h-4"></i>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col min-h-screen overflow-x-hidden">
            <!-- Topbar Header -->
            <header class="bg-white border-b border-slate-200/80 sticky top-0 z-30 px-6 py-4 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="text-xs font-medium text-slate-400">
                        <span>Aplikasi Ujikom</span>
                        <span class="mx-1">/</span>
                        <span class="text-slate-700 font-semibold">@yield('page_heading', 'Dashboard')</span>
                    </div>
                </div>

                <div class="flex items-center space-x-4">
                    <a href="{{ route('pegawai.create') }}" 
                       class="inline-flex items-center space-x-2 px-3.5 py-2 text-xs font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl shadow-sm transition">
                        <i data-lucide="plus-circle" class="w-4 h-4"></i>
                        <span class="hidden sm:inline">Pegawai Baru</span>
                    </a>

                    <div class="h-5 w-px bg-slate-200"></div>

                    <div class="flex items-center space-x-2 text-xs text-slate-500">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span class="font-medium">Admin Mode</span>
                    </div>
                </div>
            </header>

            <!-- Page Body -->
            <main class="flex-1 p-6 md:p-8 max-w-7xl w-full mx-auto">
                @yield('content')
            </main>

            <!-- Footer -->
            <footer class="bg-white border-t border-slate-200/80 px-6 py-4 text-center text-xs text-slate-400">
                &copy; {{ date('Y') }} SIMPEG - Sistem Informasi Manajemen Pegawai. Disiapkan untuk Uji Kompetensi Keahlian (MUK).
            </footer>
        </div>
    </div>

    <!-- Quick Detail Modal Container -->
    <div id="detailModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4 transition-opacity">
        <div class="bg-white rounded-3xl shadow-2xl max-w-lg w-full overflow-hidden border border-slate-100 transform transition-all" id="detailModalContent">
            <!-- Injected by openPegawaiModal(id) via JS -->
        </div>
    </div>

    <!-- SweetAlert Toast Handler for Flash Messages -->
    @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                window.showToast('success', "{{ session('success') }}");
            });
        </script>
    @endif
    @if(session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                window.showToast('error', "{{ session('error') }}");
            });
        </script>
    @endif
    @if(session('info'))
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                window.showToast('info', "{{ session('info') }}");
            });
        </script>
    @endif

    @stack('scripts')
</body>
</html>
