<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>KosTrack — Solusi Keuangan Cerdas Anak Kos</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-[#F8F7F2] text-[#242923] font-sans antialiased selection:bg-[#174D3A] selection:text-white">

    <!-- Header / Navbar -->
    <header class="max-w-7xl mx-auto px-6 py-6 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-[#174D3A] flex items-center justify-center text-white font-bold text-lg shadow-sm">
                K
            </div>
            <span class="font-bold text-xl tracking-tight text-[#242923]">KosTrack</span>
        </div>
        <div class="flex items-center gap-4">
            @auth
                <a href="{{ route('dashboard') }}" class="px-5 py-2.5 rounded-xl bg-[#174D3A] text-white font-semibold text-sm hover:bg-[#174D3A]/90 transition-colors shadow-sm">
                    Ke Dashboard
                </a>
            @else
                <a href="{{ route('login') }}" class="text-sm font-semibold text-[#777D75] hover:text-[#242923] transition-colors">Masuk</a>
                <a href="{{ route('register') }}" class="px-5 py-2.5 rounded-xl bg-[#174D3A] text-white font-semibold text-sm hover:bg-[#174D3A]/90 transition-colors shadow-sm">
                    Daftar Gratis
                </a>
            @endauth
        </div>
    </header>

    <!-- Hero Section -->
    <section class="max-w-5xl mx-auto px-6 pt-16 pb-20 text-center space-y-6">
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-[#A9B9A3]/20 border border-[#A9B9A3]/40 text-[#174D3A] text-xs font-bold tracking-wide uppercase">
            <i data-lucide="sparkles" class="w-4 h-4"></i>
            <span>Didesain Khusus untuk Mahasiswa & Anak Kos</span>
        </div>
        <h1 class="text-4xl sm:text-6xl font-extrabold tracking-tight text-[#242923] leading-tight">
            Atur Uang Bulanan Tanpa Pusing<br class="hidden sm:inline"> Kapan Uang Kos Bakal Habis.
        </h1>
        <p class="max-w-2xl mx-auto text-base sm:text-lg text-[#777D75] leading-relaxed">
            KosTrack membantu kamu mengontrol pengeluaran harian, mengelola anggaran kategori, hingga memprediksi berapa hari lagi jatah uang kirimanmu bertahan lewat fitur <strong>Safe-to-Spend</strong>.
        </p>
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-4">
            <a href="{{ route('register') }}" class="w-full sm:w-auto px-8 py-4 rounded-2xl bg-[#174D3A] text-white font-bold text-base shadow-lg shadow-[#174D3A]/20 hover:bg-[#174D3A]/90 transition-all active:scale-95">
                Mulai Kelola Keuangan →
            </a>
        </div>
    </section>

    <!-- Features Section -->
    <section class="max-w-7xl mx-auto px-6 py-16 border-t border-[#E8E8E1]">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white p-8 rounded-3xl border border-[#E8E8E1] shadow-sm space-y-3">
                <div class="w-12 h-12 rounded-2xl bg-[#174D3A]/10 text-[#174D3A] flex items-center justify-center">
                    <i data-lucide="shield-check" class="w-6 h-6"></i>
                </div>
                <h3 class="font-bold text-lg text-[#242923]">Safe-to-Spend</h3>
                <p class="text-sm text-[#777D75] leading-relaxed">
                    Ketahui jatah belanja harian yang aman dan kalkulasi estimasi berapa hari sisa uangmu akan bertahan berdasarkan pengeluaran riil.
                </p>
            </div>

            <div class="bg-white p-8 rounded-3xl border border-[#E8E8E1] shadow-sm space-y-3">
                <div class="w-12 h-12 rounded-2xl bg-[#174D3A]/10 text-[#174D3A] flex items-center justify-center">
                    <i data-lucide="pie-chart" class="w-6 h-6"></i>
                </div>
                <h3 class="font-bold text-lg text-[#242923]">Anggaran Kategori</h3>
                <p class="text-sm text-[#777D75] leading-relaxed">
                    Pasang batas pengeluaran untuk makan, nongkrong, dan kebutuhan kos. Dapatkan indikator visual saat anggaran mendekati batas.
                </p>
            </div>

            <div class="bg-white p-8 rounded-3xl border border-[#E8E8E1] shadow-sm space-y-3">
                <div class="w-12 h-12 rounded-2xl bg-[#174D3A]/10 text-[#174D3A] flex items-center justify-center">
                    <i data-lucide="receipt" class="w-6 h-6"></i>
                </div>
                <h3 class="font-bold text-lg text-[#242923]">Manajemen Tagihan</h3>
                <p class="text-sm text-[#777D75] leading-relaxed">
                    Catat tagihan listrik, Wi-Fi, dan sewa kamar kos agar saldo bebas pakaimu tidak salah terhitung.
                </p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="max-w-7xl mx-auto px-6 py-8 border-t border-[#E8E8E1] text-center text-xs text-[#777D75]">
        &copy; {{ date('Y') }} KosTrack. Crafted with Laravel 12 & Tailwind CSS.
    </footer>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>