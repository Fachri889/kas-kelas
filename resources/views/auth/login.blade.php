<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Masuk - Kas Kelas XII MIPA 2</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet"/>
    
    <link rel="stylesheet" href="{{ asset('css/style.css') }}"/>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="{{ asset('js/tailwind-config.js') }}"></script>
    <script src="{{ asset('js/login.js') }}" defer></script>
</head>
<body class="bg-background font-body-md text-on-surface antialiased min-h-screen flex items-center justify-center p-space-md">
    <main class="w-full flex items-center justify-center">
        <div class="flex flex-col w-full items-center justify-center relative py-space-xl">
            <!-- Decorative Glow Spheres -->
            <div class="absolute -top-12 -left-12 w-96 h-96 bg-primary/10 rounded-full blur-3xl pointer-events-none -z-10"></div>
            <div class="absolute bottom-0 right-0 w-[420px] h-[420px] bg-secondary-fixed-dim/20 rounded-full blur-3xl pointer-events-none -z-10"></div>

            <!-- Bento Box Card -->
            <div class="w-full max-w-5xl bg-surface-container-lowest rounded-[20px] shadow-xl overflow-hidden flex flex-col lg:flex-row transition-all duration-300 border border-outline-variant/30">
                <!-- Left Column: Login Form -->
                <div class="w-full lg:w-7/12 p-space-lg md:p-space-xl flex flex-col justify-between">
                    <div>
                        <!-- Header / Brand -->
                        <div class="flex items-center justify-between mb-space-lg">
                            <div class="flex items-center gap-space-sm">
                                <div class="w-14 h-14 rounded-xl bg-surface-container-low flex items-center justify-center p-2 shadow-xs">
                                    <img alt="Kas Kelas Logo" class="w-full h-full object-contain" src="{{ asset('logo.svg') }}"/>
                                </div>
                                <div>
                                    <div class="flex items-center gap-space-xs">
                                        <span class="font-headline-lg text-headline-lg text-on-surface font-bold tracking-tight">Kas Kelas</span>
                                    </div>
                                    <p class="font-body-sm text-body-sm text-on-surface-variant line-clamp-1">SMAN 1 - Keuangan Digital Terbuka XII MIPA 2</p>
                                </div>
                            </div>

                        </div>

                        <div class="mb-space-lg">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-primary/10 text-primary text-xs font-semibold uppercase tracking-wider mb-2">
                                <span class="material-symbols-outlined text-[16px]">admin_panel_settings</span>
                                Khusus Pengurus & Bendahara
                            </span>
                            <h1 class="font-display-lg text-headline-lg md:text-display-lg text-on-surface font-bold tracking-tight mb-space-xs">Masuk Akun Bendahara</h1>
                            <p class="font-body-md text-body-md text-on-surface-variant leading-relaxed">
                                Silakan masuk dengan akun pengurus untuk mengelola pencatatan kas, verifikasi iuran siswa, dan pengeluaran kelas.
                            </p>
                        </div>

                        <!-- Session / Error Alerts -->
                        @if(session('success'))
                            <div class="mb-space-md p-3.5 bg-secondary-fixed/30 border border-secondary/40 text-on-surface rounded-xl flex items-center gap-2 font-body-sm">
                                <span class="material-symbols-outlined text-secondary text-[20px]">check_circle</span>
                                <span>{{ session('success') }}</span>
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="mb-space-md p-3.5 bg-error-container/40 border border-error/30 text-on-error-container rounded-xl flex items-center gap-2 font-body-sm">
                                <span class="material-symbols-outlined text-error text-[20px]">error</span>
                                <div>
                                    @foreach($errors->all() as $err)
                                        <p>{{ $err }}</p>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Login Form for Bendahara -->
                        <form method="POST" action="{{ route('login.post') }}" class="space-y-space-md">
                            @csrf

                            <!-- Username Field -->
                            <div>
                                <label class="block font-label-md text-label-md text-on-surface mb-1.5 font-medium" for="user-username">
                                    Username
                                </label>
                                <div class="relative flex items-center">
                                    <span class="material-symbols-outlined absolute left-3.5 text-outline text-[20px] pointer-events-none">person</span>
                                    <input class="w-full h-11 pl-11 pr-4 bg-surface-container-lowest border border-outline-variant/60 rounded-xl font-body-md text-body-md text-on-surface placeholder:text-outline/70 shadow-xs focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all" 
                                           id="user-username" 
                                           name="username"
                                           value="{{ old('username', 'admin') }}" 
                                           placeholder="admin" 
                                           type="text" 
                                           autocomplete="username"
                                           required/>
                                </div>
                            </div>

                            <!-- Password Field -->
                            <div id="password-group">
                                <div class="flex items-center justify-between mb-1.5">
                                    <label class="block font-label-md text-label-md text-on-surface font-medium" for="user-password">
                                        Password
                                    </label>
                                </div>
                                <div class="relative flex items-center">
                                    <span class="material-symbols-outlined absolute left-3.5 text-outline text-[20px] pointer-events-none">lock</span>
                                    <input class="w-full h-11 pl-11 pr-11 bg-surface-container-lowest border border-outline-variant/60 rounded-xl font-body-md text-body-md text-on-surface placeholder:text-outline/70 shadow-xs focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all tracking-wider" 
                                           id="user-password" 
                                           name="password"
                                           value="password"
                                           placeholder="••••••••" 
                                           type="password"
                                           autocomplete="current-password"
                                           required/>
                                    <button aria-label="Toggle password visibility" class="absolute right-3 text-outline hover:text-on-surface p-1 rounded-md transition-colors" onclick="togglePassword()" type="button">
                                        <span class="material-symbols-outlined text-[20px] block" id="password-toggle-icon">visibility</span>
                                    </button>
                                </div>
                            </div>

                            <!-- Remember Me & Info -->
                            <div class="flex items-center justify-between pt-1">
                                <label class="flex items-center gap-2 cursor-pointer select-none">
                                    <input class="w-4 h-4 rounded text-primary focus:ring-0 focus:ring-offset-0 cursor-pointer accent-primary" name="remember" type="checkbox" checked/>
                                    <span class="font-body-sm text-body-sm text-on-surface-variant">Ingat Saya</span>
                                </label>
                                <span class="font-label-sm text-label-sm text-outline">
                                    Demo: <code class="bg-surface-container-low px-1.5 py-0.5 rounded text-primary font-mono font-semibold">admin</code> / <code class="bg-surface-container-low px-1.5 py-0.5 rounded text-primary font-mono font-semibold">password</code>
                                </span>
                            </div>

                            <!-- Primary Submit CTA -->
                            <button class="w-full h-11 rounded-xl bg-primary text-on-primary font-headline-sm text-headline-sm font-semibold flex items-center justify-center gap-2 shadow-xs hover:bg-primary-container active:scale-[0.99] transition-all duration-150 mt-space-md" type="submit">
                                <span>Masuk</span>
                                <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
                            </button>
                        </form>

                        <!-- Public Transparency Divider -->
                        <div class="relative flex items-center justify-center my-space-lg">
                            <div class="w-full h-px bg-outline-variant/30"></div>
                            <span class="absolute px-3 bg-surface-container-lowest font-label-sm text-label-sm text-outline uppercase tracking-wider">
                                untuk siswa & wali murid
                            </span>
                        </div>

                        <!-- Secondary CTA: Public Portal -->
                        <div class="rounded-xl border border-blue-200/80 bg-blue-50/50 p-3.5 text-center">
                            <p class="text-xs text-slate-600 mb-2.5">
                                Siswa & Wali Murid <strong>tidak perlu login</strong> untuk melihat status iuran dan mutasi kas kelas.
                            </p>
                            <a href="{{ route('siswa.dashboard') }}" class="w-full h-10 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-label-lg text-label-lg flex items-center justify-center gap-2 transition-all duration-150 font-semibold shadow-xs">
                                <span class="material-symbols-outlined text-[19px]">visibility</span>
                                <span>Buka Portal Transparansi Siswa</span>
                            </a>
                        </div>
                    </div>

                    <!-- Footer Note -->
                    <div class="mt-space-lg pt-space-md text-center lg:text-left border-t border-outline-variant/20">
                        <p class="font-body-sm text-body-sm text-outline">
                            © 2024 Kas Kelas SMA Negeri 1 - Dikelola oleh Bendahara Kelas XII MIPA 2 & Laravel 11.
                        </p>
                    </div>
                </div>

                <!-- Right Column: Visual Dashboard Preview & Trust Badges -->
                <div class="w-full lg:w-5/12 bg-surface-container-low p-space-lg md:p-space-xl flex flex-col justify-between relative overflow-hidden">
                    <div class="absolute -right-16 -top-16 w-56 h-56 rounded-full bg-primary/5 pointer-events-none"></div>
                    <div class="absolute right-12 bottom-12 w-72 h-72 rounded-full bg-secondary-fixed/20 pointer-events-none blur-xl"></div>

                    <div class="relative z-10 space-y-space-md">
                        <!-- Live Micro-Widget: Kas Kelas Snapshot -->
                        <div class="bg-surface-container-lowest rounded-xl p-space-md shadow-xs border border-outline-variant/20">
                            <div class="flex items-center justify-between mb-space-sm">
                                <span class="font-label-sm text-label-sm uppercase text-outline tracking-wider font-semibold">Kas Terkumpul (Bulan Berjalan)</span>
                                <span class="px-2 py-0.5 rounded-full bg-secondary-fixed/30 text-secondary font-label-sm text-label-sm font-bold flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[12px]">trending_up</span> Terverifikasi
                                </span>
                            </div>
                            <div class="flex items-baseline gap-1.5 mb-space-sm">
                                <span class="font-currency-stat text-currency-stat text-on-surface font-bold">Rp 2.850.000</span>
                                <span class="font-body-sm text-body-sm text-outline">/ Target Bulan</span>
                            </div>
                            <div class="w-full h-2 rounded-full bg-surface-container overflow-hidden">
                                <div class="h-full bg-secondary rounded-full" style="width: 86%;"></div>
                            </div>
                            <div class="flex justify-between items-center mt-2 font-label-sm text-label-sm text-on-surface-variant">
                                <span>Siswa Aktif: 7 Siswa Terdaftar</span>
                                <span class="text-secondary font-bold">Minggu ke-4</span>
                            </div>
                        </div>

                        <!-- Inline Mini-Ledger Card -->
                        <div class="bg-surface-container-lowest rounded-xl p-space-md shadow-xs border border-outline-variant/20 flex items-center gap-space-md">
                            <div class="w-12 h-12 rounded-xl bg-surface-container-high flex items-center justify-center text-primary shrink-0">
                                <span class="material-symbols-outlined text-[24px]">receipt_long</span>
                            </div>
                            <div class="min-w-0 flex-1">
                                <div class="font-label-lg text-label-lg text-on-surface truncate font-semibold">Pengeluaran Terakhir</div>
                                <div class="font-body-sm text-body-sm text-on-surface-variant truncate">Pembelian Spidol & Kebutuhan Kelas</div>
                            </div>
                            <div class="text-right shrink-0">
                                <span class="font-label-md text-label-md text-error font-bold block">-Rp 85.000</span>
                                <span class="font-label-sm text-label-sm text-outline">Nota Terlampir</span>
                            </div>
                        </div>
                    </div>

                    <!-- Trust Badges -->
                    <div class="relative z-10 mt-space-xl space-y-space-sm">
                        <span class="font-label-sm text-label-sm uppercase tracking-wider text-outline block mb-space-xs font-semibold">Keunggulan Platform</span>
                        
                        <div class="flex items-center gap-space-sm p-space-sm rounded-xl bg-surface-container-lowest/80 backdrop-blur shadow-xs">
                            <div class="w-9 h-9 rounded-lg bg-surface-container-high text-primary flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined text-[20px]" style="font-variation-settings: 'FILL' 1;">verified_user</span>
                            </div>
                            <div>
                                <h4 class="font-label-lg text-label-lg text-on-surface font-semibold">100% Transparan & Akurat</h4>
                                <p class="font-body-sm text-body-sm text-on-surface-variant">Arsip mutasi dana dapat dicek langsung setiap waktu.</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-space-sm p-space-sm rounded-xl bg-surface-container-lowest/80 backdrop-blur shadow-xs">
                            <div class="w-9 h-9 rounded-lg bg-secondary-fixed text-on-secondary-fixed flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined text-[20px]" style="font-variation-settings: 'FILL' 1;">sync</span>
                            </div>
                            <div>
                                <h4 class="font-label-lg text-label-lg text-on-surface font-semibold">Pencatatan Otomatis Real-time</h4>
                                <p class="font-body-sm text-body-sm text-on-surface-variant">Verifikasi bayar otomatis per-minggu bebas selisih.</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-space-sm p-space-sm rounded-xl bg-surface-container-lowest/80 backdrop-blur shadow-xs">
                            <div class="w-9 h-9 rounded-lg bg-tertiary-fixed text-on-tertiary-fixed flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined text-[20px]" style="font-variation-settings: 'FILL' 1;">description</span>
                            </div>
                            <div>
                                <h4 class="font-label-lg text-label-lg text-on-surface font-semibold">Ekspor Laporan PDF & Excel</h4>
                                <p class="font-body-sm text-body-sm text-on-surface-variant">Cetak lembar pertanggungjawaban wali kelas 1-klik.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('user-password');
            const toggleIcon = document.getElementById('password-toggle-icon');
            if (!passwordInput || !toggleIcon) return;

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.textContent = 'visibility_off';
            } else {
                passwordInput.type = 'password';
                toggleIcon.textContent = 'visibility';
            }
        }
    </script>
</body>
</html>
