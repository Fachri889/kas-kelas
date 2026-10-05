<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - Kas Kelas XII IPA 2</title>
    
    <!-- Modern Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet"/>
    
    <!-- CSS & Tailwind -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}"/>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="{{ asset('js/tailwind-config.js') }}"></script>
    <script src="{{ asset('js/main.js') }}" defer></script>
    
    @stack('styles')
</head>
<body class="bg-slate-50 font-sans text-slate-800 antialiased min-h-screen flex flex-col selection:bg-blue-100 selection:text-blue-900">
    <!-- Mobile Drawer Backdrop -->
    <div id="sidebar-backdrop" 
         class="fixed inset-0 bg-slate-900/50 backdrop-blur-xs z-40 hidden transition-opacity duration-300"
         aria-hidden="true"></div>

    <!-- App Sidebar: Admin & Bendahara -->
    <aside id="app-sidebar" 
           class="fixed left-0 top-0 h-full w-[260px] bg-white border-r border-slate-200/80 z-50 flex flex-col justify-between transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out shadow-sm"
           aria-label="Sidebar Menu">
        <div class="flex flex-col">
            <!-- Brand Header -->
            <div class="h-16 px-5 border-b border-slate-100 flex items-center justify-between gap-3">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 min-w-0">
                    <img alt="Kas Kelas Logo" class="h-8 w-8 object-contain shrink-0" src="{{ asset('logo.svg') }}"/>
                    <div class="flex flex-col min-w-0">
                        <span class="text-base font-bold text-slate-900 tracking-tight leading-none">Kas Kelas</span>
                        <span class="text-xs text-slate-500 font-medium truncate mt-1">XII IPA 2</span>
                    </div>
                </a>
                <button id="mobile-sidebar-close" 
                        class="lg:hidden p-1.5 rounded-lg text-slate-400 hover:bg-slate-100 hover:text-slate-700 transition-colors" 
                        type="button" 
                        aria-label="Tutup Menu">
                    <span class="material-symbols-outlined text-[20px]">close</span>
                </button>
            </div>

            <!-- Navigation Links -->
            <nav class="flex flex-col gap-1.5 p-3.5">
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white font-semibold shadow-xs' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <span class="material-symbols-outlined text-[20px] {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-slate-400' }}">dashboard</span>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('admin.siswa.index') }}" 
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('admin.siswa.*') ? 'bg-blue-600 text-white font-semibold shadow-xs' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <span class="material-symbols-outlined text-[20px] {{ request()->routeIs('admin.siswa.*') ? 'text-white' : 'text-slate-400' }}">group</span>
                    <span>Data Siswa</span>
                </a>

                <a href="{{ route('admin.pembayaran.index') }}" 
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('admin.pembayaran.*') ? 'bg-blue-600 text-white font-semibold shadow-xs' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <span class="material-symbols-outlined text-[20px] {{ request()->routeIs('admin.pembayaran.*') ? 'text-white' : 'text-slate-400' }}">account_balance_wallet</span>
                    <span>Pembayaran Kas</span>
                </a>

                <a href="{{ route('admin.pemasukan.index') }}" 
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('admin.pemasukan.*') ? 'bg-blue-600 text-white font-semibold shadow-xs' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <span class="material-symbols-outlined text-[20px] {{ request()->routeIs('admin.pemasukan.*') ? 'text-white' : 'text-slate-400' }}">trending_up</span>
                    <span>Pemasukan</span>
                </a>

                <a href="{{ route('admin.pengeluaran.index') }}" 
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('admin.pengeluaran.*') ? 'bg-blue-600 text-white font-semibold shadow-xs' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <span class="material-symbols-outlined text-[20px] {{ request()->routeIs('admin.pengeluaran.*') ? 'text-white' : 'text-slate-400' }}">trending_down</span>
                    <span>Pengeluaran</span>
                </a>

                <a href="{{ route('admin.laporan.index') }}" 
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('admin.laporan.*') ? 'bg-blue-600 text-white font-semibold shadow-xs' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <span class="material-symbols-outlined text-[20px] {{ request()->routeIs('admin.laporan.*') ? 'text-white' : 'text-slate-400' }}">description</span>
                    <span>Laporan Keuangan</span>
                </a>

                <div class="my-2 border-t border-slate-100"></div>

                <a href="{{ route('siswa.dashboard') }}" 
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium text-slate-600 hover:bg-blue-50 hover:text-blue-700 transition-colors">
                    <span class="material-symbols-outlined text-[19px] text-slate-400">how_to_reg</span>
                    <span>Lihat Portal Siswa</span>
                </a>
            </nav>
        </div>

        <!-- Sidebar Footer -->
        <div class="p-4 border-t border-slate-100 flex flex-col gap-2.5">
            <form action="{{ route('logout') }}" method="POST" class="w-full">
                @csrf
                <button type="submit" 
                        class="w-full flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium text-red-600 hover:bg-red-50 hover:text-red-700 transition-colors">
                    <span class="material-symbols-outlined text-[20px] text-red-500">logout</span>
                    <span>Keluar Akun</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content Wrapper with 260px Left Offset on Desktop -->
    <div class="lg:pl-[260px] min-h-screen flex flex-col">
        <!-- Top Sticky Header Navigation Bar -->
        <header class="fixed top-0 left-0 lg:left-[260px] right-0 h-16 bg-white/95 backdrop-blur-md border-b border-slate-200/80 z-30">
            <div class="h-16 w-full px-4 sm:px-6 lg:px-8 flex items-center justify-between gap-4">
                <!-- Left: Hamburger Toggle & Global Search Bar -->
                <div class="flex items-center gap-3 flex-1 max-w-md">
                    <button id="mobile-sidebar-toggle" 
                            class="lg:hidden p-2 -ml-1 rounded-xl text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition-colors" 
                            type="button" 
                            aria-label="Buka Menu">
                        <span class="material-symbols-outlined text-[24px]">menu</span>
                    </button>
                    
                    <div class="relative w-full hidden sm:block">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-[18px] pointer-events-none">search</span>
                        <input id="header-search-input" 
                               class="w-full h-10 pl-9 pr-4 rounded-xl bg-slate-50 border border-slate-200 text-xs sm:text-sm text-slate-800 placeholder:text-slate-400 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 focus:bg-white transition-all" 
                               placeholder="Cari data kas, mutasi, siswa..." 
                               type="text"/>
                    </div>
                </div>

                <!-- Right: Status, Notifications & Profile -->
                <div class="flex items-center gap-3 shrink-0">
                    <div class="hidden sm:flex items-center gap-1.5 px-3 py-1 rounded-full bg-slate-100 text-slate-600 text-xs font-semibold">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                        <span>TA 2024/2025</span>
                    </div>

                    <div class="h-5 w-px bg-slate-200 hidden sm:block"></div>

                    <!-- Profile Pill -->
                    <div class="flex items-center gap-2.5 pl-1">
                        <div class="w-9 h-9 rounded-xl bg-blue-50 text-blue-700 border border-blue-200 flex items-center justify-center font-bold text-xs uppercase shrink-0">
                            SP
                        </div>
                        <div class="hidden md:flex flex-col text-left">
                            <span class="text-xs sm:text-sm font-bold text-slate-900 leading-tight">
                                {{ auth()->user()->name ?? 'Salsabila Putri' }}
                            </span>
                            <span class="text-[11px] text-slate-500 font-medium">
                                Bendahara 1
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content Canvas with Deliberate Spacing to Prevent Overlap -->
        <main class="w-full pt-24 pb-12 bg-slate-50 flex-1 px-4 sm:px-6 lg:px-8">
            @if(session('success'))
                <div data-flash-success="{{ session('success') }}" class="hidden"></div>
            @endif
            @if(session('error') || $errors->any())
                <div data-flash-error="{{ session('error') ?? $errors->first() }}" class="hidden"></div>
            @endif
            @yield('content')
        </main>
    </div>

    <!-- Mobile Drawer Native Toggle Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggleBtn = document.getElementById('mobile-sidebar-toggle');
            const closeBtn = document.getElementById('mobile-sidebar-close');
            const sidebar = document.getElementById('app-sidebar');
            const backdrop = document.getElementById('sidebar-backdrop');

            function openDrawer() {
                if (!sidebar || !backdrop) return;
                sidebar.classList.remove('-translate-x-full');
                backdrop.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            }

            function closeDrawer() {
                if (!sidebar || !backdrop) return;
                sidebar.classList.add('-translate-x-full');
                backdrop.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }

            if (toggleBtn) toggleBtn.addEventListener('click', openDrawer);
            if (closeBtn) closeBtn.addEventListener('click', closeDrawer);
            if (backdrop) backdrop.addEventListener('click', closeDrawer);

            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') closeDrawer();
            });
        });
    </script>

    @stack('scripts')
</body>
</html>
