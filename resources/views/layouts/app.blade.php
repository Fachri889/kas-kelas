<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Kas Kelas') - XII IPA 2</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet"/>
    
    <!-- CSS & Tailwind -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}"/>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="{{ asset('js/tailwind-config.js') }}"></script>
    
    <!-- Main JS -->
    <script src="{{ asset('js/main.js') }}" defer></script>
    @stack('styles')
</head>
<body class="bg-background font-body-md text-on-surface antialiased">
    <!-- Backdrop for Mobile Drawer -->
    <div id="sidebar-backdrop" class="fixed inset-0 bg-black/40 z-40 hidden lg:hidden transition-opacity"></div>

    <!-- App Sidebar -->
    <aside id="app-sidebar" class="fixed left-0 top-0 h-full w-[260px] bg-surface-container-lowest border-r border-outline-variant/30 z-50 flex flex-col justify-between transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out">
        <div class="flex flex-col">
            <!-- Brand -->
            <div class="h-16 px-space-md border-b border-outline-variant/30 flex items-center justify-between gap-space-sm">
                <div class="flex items-center gap-space-sm min-w-0">
                    <img alt="Kas Kelas Logo" class="h-8 w-8 object-contain shrink-0" src="{{ asset('logo.svg') }}"/>
                    <div class="flex flex-col min-w-0 flex-1">
                        <div class="flex items-center gap-space-xs">
                            <span class="font-headline-sm text-headline-sm text-primary truncate leading-tight font-semibold">Kas Kelas</span>
                        </div>
                        <div class="flex items-center gap-space-xs mt-0.5">
                            <span class="font-label-sm text-label-sm text-secondary bg-secondary-fixed/30 px-1.5 py-0.5 rounded">XII IPA 2</span>
                            <span class="font-label-sm text-label-sm text-on-surface-variant truncate">TA 2024</span>
                        </div>
                    </div>
                </div>
                <button id="mobile-sidebar-close" class="lg:hidden p-1.5 rounded-lg text-on-surface-variant hover:bg-surface-container-low hover:text-on-surface transition-colors" type="button" aria-label="Tutup Menu">
                    <span class="material-symbols-outlined text-[20px]">close</span>
                </button>
            </div>

            <!-- Navigation Links -->
            <nav class="flex flex-col gap-1 p-space-sm">
                <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg font-label-lg text-label-lg transition-colors {{ request()->routeIs('dashboard') ? 'bg-primary-container text-on-primary shadow-xs' : 'text-on-surface-variant hover:bg-surface-container-low hover:text-on-surface' }}" href="{{ route('dashboard') }}">
                    <span class="material-symbols-outlined text-[20px]">dashboard</span>
                    <span>Dashboard</span>
                </a>
                <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg font-label-lg text-label-lg transition-colors {{ request()->routeIs('siswa.*') ? 'bg-primary-container text-on-primary shadow-xs' : 'text-on-surface-variant hover:bg-surface-container-low hover:text-on-surface' }}" href="{{ route('siswa.index') }}">
                    <span class="material-symbols-outlined text-[20px]">group</span>
                    <span>Data Siswa</span>
                </a>
                <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg font-label-lg text-label-lg transition-colors {{ request()->routeIs('pembayaran.*') ? 'bg-primary-container text-on-primary shadow-xs' : 'text-on-surface-variant hover:bg-surface-container-low hover:text-on-surface' }}" href="{{ route('pembayaran.index') }}">
                    <span class="material-symbols-outlined text-[20px]">account_balance_wallet</span>
                    <span>Pembayaran Kas</span>
                </a>
                <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg font-label-lg text-label-lg transition-colors {{ request()->routeIs('pemasukan.*') ? 'bg-primary-container text-on-primary shadow-xs' : 'text-on-surface-variant hover:bg-surface-container-low hover:text-on-surface' }}" href="{{ route('pemasukan.index') }}">
                    <span class="material-symbols-outlined text-[20px]">trending_up</span>
                    <span>Pemasukan</span>
                </a>
                <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg font-label-lg text-label-lg transition-colors {{ request()->routeIs('pengeluaran.*') ? 'bg-primary-container text-on-primary shadow-xs' : 'text-on-surface-variant hover:bg-surface-container-low hover:text-on-surface' }}" href="{{ route('pengeluaran.index') }}">
                    <span class="material-symbols-outlined text-[20px]">trending_down</span>
                    <span>Pengeluaran</span>
                </a>
                <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg font-label-lg text-label-lg transition-colors {{ request()->routeIs('laporan.*') ? 'bg-primary-container text-on-primary shadow-xs' : 'text-on-surface-variant hover:bg-surface-container-low hover:text-on-surface' }}" href="{{ route('laporan.index') }}">
                    <span class="material-symbols-outlined text-[20px]">description</span>
                    <span>Laporan Keuangan</span>
                </a>
                <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg font-label-lg text-label-lg transition-colors {{ request()->routeIs('siswa.*') ? 'bg-primary-container text-on-primary shadow-xs' : 'text-on-surface-variant hover:bg-surface-container-low hover:text-on-surface' }}" href="{{ route('siswa.dashboard') }}">
                    <span class="material-symbols-outlined text-[20px]">how_to_reg</span>
                    <span>Portal Siswa</span>
                </a>
            </nav>
        </div>

        <!-- Sidebar Footer -->
        <div class="p-space-sm border-t border-outline-variant/30 flex flex-col gap-space-xs">
            <div class="flex items-center justify-between px-3 py-1.5 rounded-lg bg-surface-container-low">
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-secondary animate-pulse"></span>
                    <span class="font-label-sm text-label-sm text-on-surface">Online Kas Aktif</span>
                </div>
                <span class="font-label-sm text-label-sm text-on-surface-variant">v2.0 L11</span>
            </div>
            <form action="{{ route('logout') }}" method="POST" class="w-full">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg font-label-lg text-label-lg text-error hover:bg-error-container/40 hover:text-on-error-container transition-colors">
                    <span class="material-symbols-outlined text-[20px]">logout</span>
                    <span>Keluar Akun</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Wrapper -->
    <div class="lg:pl-[260px] min-h-screen flex flex-col">
        <!-- Responsive Header -->
        <header class="fixed top-0 left-0 lg:left-[260px] right-0 h-16 bg-surface-container-lowest/80 backdrop-blur-xl border-b border-outline-variant/40 z-30">
            <div class="h-16 w-full px-4 lg:px-space-lg flex items-center justify-between gap-space-md">
                <div class="flex items-center gap-2 sm:gap-space-md flex-1 max-w-md">
                    <button id="mobile-sidebar-toggle" class="lg:hidden p-2 -ml-1 rounded-lg text-on-surface-variant hover:bg-surface-container-low hover:text-on-surface transition-colors" type="button" aria-label="Buka Menu">
                        <span class="material-symbols-outlined text-[24px]">menu</span>
                    </button>
                    <div class="relative w-full flex items-center">
                        <span class="material-symbols-outlined absolute left-3 text-on-surface-variant text-[20px] pointer-events-none">search</span>
                        <input id="header-search" class="w-full h-10 pl-10 pr-4 rounded-lg bg-surface-container-low border border-outline-variant/50 font-body-md text-body-md text-on-surface placeholder:text-outline focus:outline-none focus:border-primary-container focus:ring-2 focus:ring-primary-fixed" placeholder="Cari siswa, transaksi, atau tanggal..." type="text"/>
                    </div>
                </div>
                <div class="flex items-center gap-2 sm:gap-space-md shrink-0">
                    <button class="relative p-2 rounded-lg text-on-surface-variant hover:bg-surface-container-low hover:text-on-surface transition-colors" type="button" aria-label="Notifikasi">
                        <span class="material-symbols-outlined text-[22px]">notifications</span>
                        <span class="absolute top-1.5 right-1.5 min-w-[18px] h-[18px] flex items-center justify-center px-1 rounded-full bg-error text-on-error font-label-sm text-[10px] font-bold">3</span>
                    </button>
                    <div class="h-6 w-px bg-outline-variant/50 hidden sm:block"></div>
                    <div class="flex items-center gap-space-sm pl-1">
                        @if(request()->routeIs('portal.*'))
                            <div class="w-8 h-8 rounded-full bg-secondary/15 text-secondary ring-2 ring-secondary-fixed flex items-center justify-center font-bold text-xs shrink-0">AF</div>
                            <div class="hidden md:flex flex-col text-left">
                                <span class="font-label-lg text-label-lg text-on-surface leading-tight">Ahmad Fauzi (Siswa)</span>
                                <span class="font-label-sm text-label-sm text-on-surface-variant">NIS: 89201 · XII MIPA 2</span>
                            </div>
                        @else
                            <div class="w-8 h-8 rounded-full bg-primary/10 text-primary ring-2 ring-primary-fixed flex items-center justify-center font-bold text-xs shrink-0">SP</div>
                            <div class="hidden md:flex flex-col text-left">
                                <span class="font-label-lg text-label-lg text-on-surface leading-tight">Salsabila Putri (Bendahara)</span>
                                <span class="font-label-sm text-label-sm text-on-surface-variant">XII MIPA 2</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content Area -->
        <main class="w-full pt-24 pb-10 bg-[#F8FAFC] flex-1 px-4 sm:px-6 lg:px-space-lg">
            <!-- Flash Alerts -->
            @if(session('success'))
                <div class="mb-space-md p-4 rounded-xl bg-secondary-container/60 border border-secondary/30 text-on-secondary-container flex items-center justify-between animate-fadeIn">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-secondary text-[22px]">check_circle</span>
                        <span class="font-label-lg text-label-lg">{{ session('success') }}</span>
                    </div>
                    <button type="button" onclick="this.parentElement.remove()" class="p-1 rounded-lg hover:bg-secondary/20">
                        <span class="material-symbols-outlined text-[18px]">close</span>
                    </button>
                </div>
            @endif

            @if(session('error') || $errors->any())
                <div class="mb-space-md p-4 rounded-xl bg-error-container/60 border border-error/30 text-on-error-container flex items-center justify-between animate-fadeIn">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-error text-[22px]">error</span>
                        <div class="font-label-lg text-label-lg">
                            {{ session('error') ?? $errors->first() }}
                        </div>
                    </div>
                    <button type="button" onclick="this.parentElement.remove()" class="p-1 rounded-lg hover:bg-error/20">
                        <span class="material-symbols-outlined text-[18px]">close</span>
                    </button>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>
