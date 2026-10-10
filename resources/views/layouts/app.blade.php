<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'KosTrack') }} — Manajemen Keuangan Anak Kos</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Lucide Icons (versi dipin supaya ikon tidak berubah mendadak) -->
    <script src="https://unpkg.com/lucide@0.469.0/dist/umd/lucide.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }
        @keyframes shimmer {
            100% { transform: translateX(100%); }
        }
        .skeleton-shimmer {
            position: relative;
            overflow: hidden;
        }
        .skeleton-shimmer::after {
            position: absolute;
            top: 0; right: 0; bottom: 0; left: 0;
            transform: translateX(-100%);
            background-image: linear-gradient(
                90deg,
                rgba(255, 255, 255, 0) 0,
                rgba(255, 255, 255, 0.2) 20%,
                rgba(255, 255, 255, 0.5) 60%,
                rgba(255, 255, 255, 0)
            );
            animation: shimmer 1.5s infinite;
            content: '';
        }
    </style>
</head>
<body x-data="{
        showLogoutModal: false,
        isLoading: false,
        sidebarCollapsed: JSON.parse(localStorage.getItem('sidebarCollapsed') ?? 'false'),
        toggleSidebar() {
            this.sidebarCollapsed = !this.sidebarCollapsed;
            localStorage.setItem('sidebarCollapsed', this.sidebarCollapsed);
        }
      }"
      @navigation-start.window="isLoading = true"
      @page-loading.window="isLoading = true"
      @navigation-stop.window="isLoading = false"
      class="bg-[#F8F7F2] text-[#242923] font-sans antialiased selection:bg-[#174D3A] selection:text-white pb-20 md:pb-0">

    @php
        $menus = [
            ['label' => 'Dashboard',     'route' => 'dashboard',          'match' => 'dashboard',     'icon' => 'layout-dashboard'],
            ['label' => 'Transaksi',     'route' => 'transactions.index', 'match' => 'transactions*', 'icon' => 'arrow-left-right'],
            ['label' => 'Anggaran',      'route' => 'budgets.index',      'match' => 'budgets*',      'icon' => 'pie-chart'],
            ['label' => 'Safe-to-Spend', 'route' => 'safetospend.index',  'match' => 'safetospend*',  'icon' => 'shield-check'],
            ['label' => 'Tagihan Kos',   'route' => 'bills.index',        'match' => 'bills*',        'icon' => 'receipt'],
            ['label' => 'Laporan',       'route' => 'reports.index',      'match' => 'reports*',      'icon' => 'bar-chart-3'],
        ];
    @endphp

    <!-- Global Page Transition Skeleton Loader -->
    <div x-show="isLoading"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-[#F8F7F2]/90 backdrop-blur-sm z-50 flex items-center justify-center p-6" x-cloak>
        <div class="w-full max-w-4xl space-y-6">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-[#174D3A]/20 animate-pulse"></div>
                <div class="space-y-2">
                    <div class="h-4 w-32 bg-[#E8E8E1] rounded-lg animate-pulse"></div>
                    <div class="h-3 w-20 bg-[#E8E8E1] rounded-lg animate-pulse"></div>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div class="h-32 bg-white rounded-2xl border border-[#E8E8E1] p-6 space-y-3 skeleton-shimmer">
                    <div class="h-3 w-24 bg-[#E8E8E1] rounded"></div>
                    <div class="h-8 w-36 bg-[#174D3A]/10 rounded-lg"></div>
                </div>
                <div class="h-32 bg-white rounded-2xl border border-[#E8E8E1] p-6 space-y-3 skeleton-shimmer">
                    <div class="h-3 w-24 bg-[#E8E8E1] rounded"></div>
                    <div class="h-8 w-36 bg-[#174D3A]/10 rounded-lg"></div>
                </div>
                <div class="h-32 bg-white rounded-2xl border border-[#E8E8E1] p-6 space-y-3 skeleton-shimmer">
                    <div class="h-3 w-24 bg-[#E8E8E1] rounded"></div>
                    <div class="h-8 w-36 bg-[#C65B55]/10 rounded-lg"></div>
                </div>
            </div>

            <div class="h-64 bg-white rounded-2xl border border-[#E8E8E1] p-6 space-y-4 skeleton-shimmer">
                <div class="h-4 w-48 bg-[#E8E8E1] rounded"></div>
                <div class="h-3 w-full bg-[#F8F7F2] rounded"></div>
                <div class="h-3 w-5/6 bg-[#F8F7F2] rounded"></div>
                <div class="h-3 w-4/6 bg-[#F8F7F2] rounded"></div>
            </div>
        </div>
    </div>

    <div class="min-h-screen flex flex-col md:flex-row">

        <!-- Desktop Collapsible Sidebar -->
        <aside x-bind:class="sidebarCollapsed ? 'md:w-20 px-3' : 'md:w-64 px-5'"
               class="hidden md:flex bg-white border-r border-[#E8E8E1] flex-col justify-between py-6 fixed inset-y-0 z-30 transition-all duration-300 ease-in-out">
            <div>
                <!-- Brand -->
                <div class="flex items-center gap-3 mb-8 h-10"
                     x-bind:class="sidebarCollapsed ? 'justify-center' : 'px-2'">
                    <div class="w-10 h-10 rounded-xl bg-[#174D3A] flex items-center justify-center text-white font-bold text-lg shadow-sm shrink-0">
                        K
                    </div>
                    <div x-show="!sidebarCollapsed" x-transition.opacity.duration.200ms class="overflow-hidden whitespace-nowrap leading-tight">
                        <span class="block font-bold text-lg text-[#242923] tracking-tight">KosTrack</span>
                        <span class="block text-xs text-[#777D75]">Keuangan Anak Kos</span>
                    </div>
                </div>

                <!-- Navigation -->
                <nav class="space-y-1.5">
                    @foreach ($menus as $menu)
                        @php $isActive = request()->routeIs($menu['match']); @endphp
                        <a href="{{ route($menu['route']) }}"
                           @click="isLoading = true"
                           class="group relative flex items-center gap-3 py-2.5 rounded-xl text-sm font-medium transition-colors
                                  {{ $isActive
                                        ? 'bg-[#174D3A] text-white shadow-sm'
                                        : 'text-[#777D75] hover:bg-[#F8F7F2] hover:text-[#242923]' }}"
                           x-bind:class="sidebarCollapsed ? 'justify-center px-0' : 'px-3'">

                            <i data-lucide="{{ $menu['icon'] }}" class="w-5 h-5 shrink-0"></i>

                            <span x-show="!sidebarCollapsed" x-transition.opacity.duration.200ms class="truncate">
                                {{ $menu['label'] }}
                            </span>

                            <!-- Tooltip saat sidebar mengecil -->
                            <span x-show="sidebarCollapsed" x-cloak
                                  class="pointer-events-none absolute left-full ml-3 px-2.5 py-1.5 rounded-lg bg-[#242923] text-white text-xs font-medium whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity duration-150 z-50 shadow-lg">
                                {{ $menu['label'] }}
                            </span>
                        </a>
                    @endforeach
                </nav>
            </div>

            <!-- User Profile & Logout -->
            <div class="pt-5 border-t border-[#E8E8E1] space-y-2">
                <div class="flex items-center gap-3 py-1"
                     x-bind:class="sidebarCollapsed ? 'justify-center' : 'px-2'">
                    <div class="w-9 h-9 rounded-full bg-[#A9B9A3]/30 text-[#174D3A] flex items-center justify-center font-semibold text-sm shrink-0 uppercase">
                        {{ substr(Auth::user()->name, 0, 2) }}
                    </div>
                    <div x-show="!sidebarCollapsed" x-transition.opacity.duration.200ms class="overflow-hidden leading-tight">
                        <p class="text-sm font-semibold text-[#242923] truncate">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-[#777D75] truncate">{{ Auth::user()->email }}</p>
                    </div>
                </div>

                <button type="button" @click="showLogoutModal = true"
                        class="group relative w-full flex items-center gap-3 py-2.5 rounded-xl text-sm font-medium text-[#C65B55] hover:bg-[#C65B55]/10 transition-colors"
                        x-bind:class="sidebarCollapsed ? 'justify-center px-0' : 'px-3'">
                    <i data-lucide="log-out" class="w-5 h-5 shrink-0"></i>
                    <span x-show="!sidebarCollapsed" x-transition.opacity.duration.200ms class="truncate">Keluar</span>

                    <span x-show="sidebarCollapsed" x-cloak
                          class="pointer-events-none absolute left-full ml-3 px-2.5 py-1.5 rounded-lg bg-[#242923] text-white text-xs font-medium whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity duration-150 z-50 shadow-lg">
                        Keluar
                    </span>
                </button>
            </div>
        </aside>

        <!-- Mobile Bottom Navigation -->
        <div class="md:hidden fixed bottom-0 inset-x-0 bg-white border-t border-[#E8E8E1] z-40 px-4 py-2 flex justify-around items-center">
            <a href="{{ route('dashboard') }}" @click="isLoading = true" class="flex flex-col items-center py-1 px-3 {{ request()->routeIs('dashboard') ? 'text-[#174D3A]' : 'text-[#777D75]' }}">
                <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                <span class="text-[10px] font-medium mt-1">Home</span>
            </a>
            <a href="{{ route('transactions.index') }}" @click="isLoading = true" class="flex flex-col items-center py-1 px-3 {{ request()->routeIs('transactions*') ? 'text-[#174D3A]' : 'text-[#777D75]' }}">
                <i data-lucide="arrow-left-right" class="w-5 h-5"></i>
                <span class="text-[10px] font-medium mt-1">Transaksi</span>
            </a>

            <!-- Quick Add Button in Mobile Nav -->
            <a href="{{ route('transactions.create') }}" @click="isLoading = true" class="flex items-center justify-center w-12 h-12 rounded-full bg-[#174D3A] text-white shadow-md -mt-5 hover:bg-[#174D3A]/90 transition-transform active:scale-95">
                <i data-lucide="plus" class="w-6 h-6"></i>
            </a>

            <a href="{{ route('budgets.index') }}" @click="isLoading = true" class="flex flex-col items-center py-1 px-3 {{ request()->routeIs('budgets*') ? 'text-[#174D3A]' : 'text-[#777D75]' }}">
                <i data-lucide="pie-chart" class="w-5 h-5"></i>
                <span class="text-[10px] font-medium mt-1">Anggaran</span>
            </a>
            <a href="{{ route('safetospend.index') }}" @click="isLoading = true" class="flex flex-col items-center py-1 px-3 {{ request()->routeIs('safetospend*') ? 'text-[#174D3A]' : 'text-[#777D75]' }}">
                <i data-lucide="shield-check" class="w-5 h-5"></i>
                <span class="text-[10px] font-medium mt-1">Safe-to-Spend</span>
            </a>
        </div>

        <!-- Main Content Wrapper -->
        <main x-bind:class="sidebarCollapsed ? 'md:ml-20' : 'md:ml-64'"
              class="flex-1 flex flex-col min-h-screen transition-all duration-300 ease-in-out">
            <!-- Top Header -->
            <header class="bg-white border-b border-[#E8E8E1] h-16 px-6 flex items-center justify-between sticky top-0 z-20">
                <div class="flex items-center gap-4">
                    <!-- Satu-satunya tombol toggle sidebar -->
                    <button type="button" @click="toggleSidebar()"
                            class="hidden md:flex p-2 rounded-lg text-[#777D75] hover:bg-[#F8F7F2] hover:text-[#242923] transition-colors"
                            x-bind:title="sidebarCollapsed ? 'Perluas Sidebar' : 'Ciutkan Sidebar'">
                        <span x-show="!sidebarCollapsed"><i data-lucide="panel-left-close" class="w-5 h-5"></i></span>
                        <span x-show="sidebarCollapsed" x-cloak><i data-lucide="panel-left-open" class="w-5 h-5"></i></span>
                    </button>
                    <h1 class="font-bold text-lg text-[#242923]">
                        @yield('header', 'Dashboard')
                    </h1>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('profile.edit') }}" @click="isLoading = true" class="w-9 h-9 rounded-full bg-[#F8F7F2] border border-[#E8E8E1] flex items-center justify-center text-[#242923] hover:border-[#174D3A] transition-colors">
                        <i data-lucide="user" class="w-4 h-4"></i>
                    </a>
                    <button type="button" @click="showLogoutModal = true" class="md:hidden w-9 h-9 rounded-full bg-[#C65B55]/10 text-[#C65B55] flex items-center justify-center transition-colors">
                        <i data-lucide="log-out" class="w-4 h-4"></i>
                    </button>
                </div>
            </header>

            <!-- Page Content -->
            <div class="flex-1 p-6 max-w-7xl w-full mx-auto">
                @if (session('success'))
                    <div class="mb-6 p-4 rounded-xl bg-[#A9B9A3]/20 border border-[#A9B9A3] text-[#174D3A] text-sm font-medium flex items-center gap-3">
                        <i data-lucide="check-circle-2" class="w-5 h-5 shrink-0"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-6 p-4 rounded-xl bg-[#C65B55]/10 border border-[#C65B55]/30 text-[#C65B55] text-sm font-medium flex items-center gap-3">
                        <i data-lucide="alert-circle" class="w-5 h-5 shrink-0"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    <!-- Modal Konfirmasi Logout -->
    <div x-show="showLogoutModal"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40 backdrop-blur-sm"
         x-cloak>

        <div @click.away="showLogoutModal = false"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             class="bg-white rounded-3xl border border-[#E8E8E1] p-6 max-w-sm w-full shadow-xl space-y-5 text-center">

            <div class="w-12 h-12 rounded-2xl bg-[#C65B55]/10 text-[#C65B55] flex items-center justify-center mx-auto">
                <i data-lucide="log-out" class="w-6 h-6"></i>
            </div>

            <div class="space-y-1">
                <h3 class="font-bold text-lg text-[#242923]">Keluar dari KosTrack?</h3>
                <p class="text-xs text-[#777D75] leading-relaxed">
                    Sesi kamu akan diakhiri. Kamu dapat masuk kembali kapan saja untuk mencatat keuanganmu.
                </p>
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="button" @click="showLogoutModal = false"
                        class="flex-1 py-2.5 rounded-xl border border-[#E8E8E1] text-sm font-semibold text-[#777D75] hover:bg-[#F8F7F2] transition-colors">
                    Batal
                </button>

                <form method="POST" action="{{ route('logout') }}" class="flex-1" @submit="isLoading = true">
                    @csrf
                    <button type="submit"
                            class="w-full py-2.5 rounded-xl bg-[#C65B55] text-white text-sm font-semibold hover:bg-[#C65B55]/90 transition-colors shadow-sm">
                        Ya, Keluar
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            lucide.createIcons();

            document.querySelectorAll('form').forEach(form => {
                form.addEventListener('submit', () => {
                    window.dispatchEvent(new CustomEvent('page-loading'));
                });
            });
        });

        window.addEventListener('pageshow', () => {
            window.dispatchEvent(new CustomEvent('navigation-stop'));
        });
    </script>
</body>
</html>