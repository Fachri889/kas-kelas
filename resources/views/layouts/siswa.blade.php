<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Portal Siswa') - Kas Kelas XII MIPA 2</title>
    
    <!-- Modern Sans-Serif Fonts (Plus Jakarta Sans) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet"/>
    
    <!-- CSS & Tailwind -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}"/>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="{{ asset('js/tailwind-config.js') }}"></script>
    
    <!-- Main JS -->
    <script src="{{ asset('js/main.js') }}" defer></script>
    @stack('styles')
</head>
<body class="bg-[#F8FAFC] font-sans text-slate-800 antialiased min-h-screen">
    <!-- Backdrop for Mobile Drawer -->
    <div id="sidebar-backdrop" class="fixed inset-0 bg-slate-900/40 z-40 hidden lg:hidden transition-opacity"></div>

    <!-- A. Left Sidebar Navigation (Fixed width ~260px, Pure White Background) -->
    <aside id="app-sidebar" class="fixed left-0 top-0 h-full w-[260px] bg-white border-r border-slate-200/80 z-50 flex flex-col justify-between transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out shadow-[0_4px_20px_-2px_rgba(0,0,0,0.02)]">
        <div class="flex flex-col">
            <!-- Top Brand -->
            <div class="h-16 px-5 border-b border-slate-100 flex items-center justify-between gap-3">
                <a href="{{ route('siswa.dashboard') }}" class="flex items-center gap-3 min-w-0">
                    <div class="w-10 h-10 rounded-xl bg-blue-600 text-white flex items-center justify-center shadow-md shadow-blue-500/20 shrink-0">
                        <span class="material-symbols-outlined text-[22px]">account_balance_wallet</span>
                    </div>
                    <div class="flex flex-col min-w-0">
                        <span class="text-base font-bold text-slate-900 tracking-tight leading-none">Kas Kelas</span>
                        <div class="mt-1">
                            <span class="inline-block bg-blue-50 text-blue-700 text-[10px] font-bold px-2 py-0.5 rounded-full border border-blue-100 leading-tight">
                                PORTAL SISWA XII IPA 2
                            </span>
                        </div>
                    </div>
                </a>
                <button id="mobile-sidebar-close" class="lg:hidden p-1.5 rounded-lg text-slate-400 hover:bg-slate-100 hover:text-slate-600 transition-colors" type="button" aria-label="Tutup Menu">
                    <span class="material-symbols-outlined text-[20px]">close</span>
                </button>
            </div>

            <!-- Nav List -->
            <nav class="flex flex-col gap-1.5 p-4">
                <!-- Dashboard Siswa -->
                <a href="{{ route('siswa.dashboard') }}" 
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-medium text-sm transition-all duration-150 {{ request()->routeIs('siswa.dashboard') ? 'bg-blue-600 text-white shadow-sm shadow-blue-500/25 font-semibold' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <span class="material-symbols-outlined text-[20px] {{ request()->routeIs('siswa.dashboard') ? 'text-white' : 'text-slate-400' }}">dashboard</span>
                    <span>Dashboard Siswa</span>
                </a>

                <!-- Riwayat & Kuitansi -->
                <a href="{{ route('siswa.pembayaran.index') }}" 
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-medium text-sm transition-all duration-150 {{ request()->routeIs('siswa.pembayaran.*') ? 'bg-blue-600 text-white shadow-sm shadow-blue-500/25 font-semibold' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <span class="material-symbols-outlined text-[20px] {{ request()->routeIs('siswa.pembayaran.*') ? 'text-white' : 'text-slate-400' }}">receipt_long</span>
                    <span>Riwayat & Kuitansi</span>
                </a>

                <!-- Secondary Link: Admin Panel if authenticated as admin -->
                @if(auth()->check() && auth()->user()->role === 'admin')
                    <div class="my-2 border-t border-slate-100"></div>
                    <a href="{{ route('admin.dashboard') }}" 
                       class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-medium text-sm text-blue-700 bg-blue-50/60 hover:bg-blue-100/70 border border-blue-100/80 transition-colors">
                        <span class="material-symbols-outlined text-[19px] text-blue-600">admin_panel_settings</span>
                        <span>Kembali ke Admin Panel</span>
                    </a>
                @endif
            </nav>
        </div>

        <!-- Bottom Footer Sidebar -->
        <div class="p-4 border-t border-slate-100 flex flex-col gap-2.5">
            <!-- Live Status Indicator -->
            <div class="flex items-center justify-between px-3 py-2 rounded-xl bg-slate-50 border border-slate-100 text-xs">
                <div class="flex items-center gap-2">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                    </span>
                    <span class="font-semibold text-slate-700">Kas Terverifikasi</span>
                </div>
                <span class="text-slate-400 text-[11px] font-medium">Real-time</span>
            </div>

            <!-- Auth Action -->
            @if(auth()->check() && auth()->user()->role === 'admin')
                <form action="{{ route('logout') }}" method="POST" class="w-full">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium text-red-600 hover:bg-red-50 hover:text-red-700 transition-colors">
                        <span class="material-symbols-outlined text-[20px] text-red-500">logout</span>
                        <span>Keluar Akun Admin</span>
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="w-full flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium text-slate-700 hover:bg-slate-100 hover:text-slate-900 transition-colors">
                    <span class="material-symbols-outlined text-[20px] text-blue-600">lock</span>
                    <span>Login Bendahara</span>
                </a>
            @endif
        </div>
    </aside>

    <!-- Main Wrapper -->
    <div class="lg:pl-[260px] min-h-screen flex flex-col">
        <!-- B. Top Header Bar -->
        <header class="sticky top-0 left-0 right-0 h-16 bg-white/90 backdrop-blur-md border-b border-slate-200/80 z-30">
            <div class="h-16 w-full px-4 sm:px-6 lg:px-8 flex items-center justify-between gap-4">
                <!-- Left: Title & Mobile Toggle -->
                <div class="flex items-center gap-3">
                    <button id="mobile-sidebar-toggle" class="lg:hidden p-2 -ml-1 rounded-xl text-slate-600 hover:bg-slate-100 transition-colors" type="button" aria-label="Buka Menu">
                        <span class="material-symbols-outlined text-[22px]">menu</span>
                    </button>
                    <h1 class="text-base sm:text-lg font-bold text-slate-900 tracking-tight">
                        Portal Transparansi Kas Kelas
                    </h1>
                </div>

                <!-- Right: Profile / Auth Indicator -->
                @if(auth()->check() && auth()->user()->role === 'admin')
                    <div class="flex items-center gap-3 shrink-0">
                        <a href="{{ route('admin.dashboard') }}" class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-blue-50 hover:bg-blue-100 text-blue-700 text-xs font-semibold border border-blue-200 transition-colors">
                            <span class="material-symbols-outlined text-[17px]">admin_panel_settings</span>
                            <span>Panel Admin</span>
                        </a>
                        <div class="flex items-center gap-2.5 pl-2">
                            <div class="w-9 h-9 rounded-full bg-blue-100 text-blue-800 ring-2 ring-blue-200 flex items-center justify-center font-bold text-xs uppercase shrink-0">
                                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                            </div>
                            <div class="hidden sm:flex flex-col text-left">
                                <span class="text-xs sm:text-sm font-bold text-slate-900 leading-tight">
                                    {{ auth()->user()->name }}
                                </span>
                                <span class="text-[11px] text-blue-600 font-semibold">
                                    Bendahara / Admin
                                </span>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="flex items-center gap-2.5 shrink-0">
                        <span class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200/80 text-xs font-medium">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            Portal Publik Siswa
                        </span>
                        <a href="{{ route('login') }}" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-semibold shadow-xs transition-colors">
                            <span class="material-symbols-outlined text-[16px]">lock</span>
                            <span>Login Bendahara</span>
                        </a>
                    </div>
                @endif
            </div>
        </header>

        <!-- Main Content Area -->
        <main class="w-full flex-1 px-4 sm:px-6 lg:px-8 py-6">
            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>
