<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-900">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk Admin - SIMPEG</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>
<body class="h-full flex items-center justify-center p-4 bg-gradient-to-br from-slate-950 via-slate-900 to-indigo-950 text-slate-100">
    <div class="w-full max-w-md">
        <!-- Brand Logo & Header -->
        <div class="text-center mb-8">
            <div class="inline-flex w-16 h-16 rounded-2xl bg-gradient-to-tr from-indigo-500 via-indigo-600 to-violet-500 items-center justify-center text-white shadow-xl shadow-indigo-500/25 font-black text-2xl mb-4 border border-indigo-400/20">
                SP
            </div>
            <h1 class="text-2xl font-black tracking-tight text-white">SIMPEG</h1>
            <p class="text-sm text-slate-400 mt-1">Sistem Informasi Manajemen Data Pegawai (MUK)</p>
        </div>

        <!-- Card Container -->
        <div class="bg-slate-900/80 backdrop-blur-xl border border-slate-800 rounded-3xl p-8 shadow-2xl relative overflow-hidden">
            <!-- Glow Accent -->
            <div class="absolute -top-16 -right-16 w-32 h-32 bg-indigo-500/10 rounded-full blur-2xl pointer-events-none"></div>

            <div class="mb-6">
                <h2 class="text-lg font-bold text-white">Masuk ke Portal Admin</h2>
                <p class="text-xs text-slate-400 mt-1">Masukkan kredensial administrator Anda untuk melanjutkan.</p>
            </div>

            <!-- Error Notification -->
            @if ($errors->any())
                <div class="mb-5 p-3.5 rounded-xl bg-rose-500/10 border border-rose-500/20 text-rose-300 text-xs">
                    <div class="flex items-center space-x-2 font-semibold">
                        <i data-lucide="alert-circle" class="w-4 h-4"></i>
                        <span>Gagal Masuk</span>
                    </div>
                    <ul class="mt-1 list-disc list-inside space-y-0.5 text-rose-400">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Login Form -->
            <form action="{{ route('login.attempt') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">
                        Alamat Email
                    </label>
                    <div class="relative">
                        <input type="email" 
                               name="email" 
                               id="email" 
                               value="{{ old('email', 'admin@ujikom.test') }}" 
                               required
                               class="w-full px-4 py-2.5 rounded-xl bg-slate-950/60 border border-slate-700/80 text-white placeholder-slate-500 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
                               placeholder="nama@perusahaan.com">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">
                        Kata Sandi
                    </label>
                    <div class="relative">
                        <input type="password" 
                               name="password" 
                               id="password" 
                               value="password"
                               required
                               class="w-full px-4 py-2.5 rounded-xl bg-slate-950/60 border border-slate-700/80 text-white placeholder-slate-500 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
                               placeholder="••••••••">
                    </div>
                </div>

                <div class="flex items-center justify-between text-xs pt-1">
                    <label class="flex items-center space-x-2 cursor-pointer text-slate-400 hover:text-slate-200">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded bg-slate-800 border-slate-700 text-indigo-600 focus:ring-indigo-500">
                        <span>Ingat saya di perangkat ini</span>
                    </label>
                </div>

                <button type="submit" 
                        class="w-full py-3 px-4 rounded-xl font-bold text-sm text-white bg-indigo-600 hover:bg-indigo-500 active:bg-indigo-700 shadow-lg shadow-indigo-600/30 transition duration-150 flex items-center justify-center space-x-2">
                    <i data-lucide="log-in" class="w-4 h-4"></i>
                    <span>Masuk Administrator</span>
                </button>
            </form>

            <div class="relative my-6 text-center">
                <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-slate-800"></div></div>
                <div class="relative"><span class="px-3 bg-slate-900 text-xs text-slate-500 font-medium">atau untuk Penguji / Asesor</span></div>
            </div>

            <!-- 1-Click Quick Demo Login Button -->
            <form action="{{ route('login.demo') }}" method="POST">
                @csrf
                <button type="submit" 
                        class="w-full py-2.5 px-4 rounded-xl font-semibold text-xs text-indigo-300 bg-indigo-950/50 hover:bg-indigo-900/50 border border-indigo-800/60 hover:border-indigo-600 transition duration-150 flex items-center justify-center space-x-2">
                    <i data-lucide="sparkles" class="w-4 h-4 text-amber-400"></i>
                    <span>1-Click Masuk Cepat Demo Admin</span>
                </button>
            </form>

            <!-- Credential Info Hint -->
            <div class="mt-6 pt-5 border-t border-slate-800/80 text-[11px] text-slate-400 flex items-start space-x-2 bg-slate-950/40 p-3 rounded-xl border">
                <i data-lucide="info" class="w-4 h-4 text-indigo-400 flex-shrink-0 mt-0.5"></i>
                <div>
                    <span class="font-semibold text-slate-300">Akun Pengujian Bawaan:</span><br>
                    Email: <code class="text-indigo-300 font-mono">admin@ujikom.test</code><br>
                    Password: <code class="text-indigo-300 font-mono">password</code>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
