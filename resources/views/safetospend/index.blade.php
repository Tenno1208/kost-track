@extends('layouts.app')

@section('header', 'Safe-to-Spend & Ketahanan Uang')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Primary Hero Card: Days Left Estimator -->
    <div class="bg-[#174D3A] text-white p-8 rounded-3xl shadow-sm relative overflow-hidden">
        <div class="relative z-10 grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
            
            <!-- Left Side: Hari Cukup -->
            <div class="space-y-3">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 text-xs font-semibold tracking-wider uppercase text-[#A9B9A3]">
                    <i data-lucide="hourglass" class="w-4 h-4"></i>
                    <span>Estimasi Ketahanan Uang Kos</span>
                </div>
                <div>
                    <h2 class="text-4xl sm:text-5xl font-extrabold tracking-tight">
                        {{ $daysMoneyWillLast }} <span class="text-xl font-normal text-[#A9B9A3]">Hari Lagi</span>
                    </h2>
                    <p class="text-xs sm:text-sm text-[#A9B9A3] mt-2 leading-relaxed">
                        Dengan gaya hidupmu saat ini (rata-rata pengeluaran <strong>Rp {{ number_format($dailyAverageExpense, 0, ',', '.') }}/hari</strong>), sisa uangmu akan cukup sampai tanggal <strong>{{ $projectedEndDate }}</strong>.
                    </p>
                </div>
            </div>

            <!-- Right Side: Safe Daily Budget -->
            <div class="bg-white/10 p-6 rounded-2xl border border-white/10 space-y-2">
                <span class="text-xs text-[#A9B9A3] font-medium uppercase tracking-wider">Jatah Belanja Aman Maksimal</span>
                <div class="text-2xl font-bold text-white">
                    Rp {{ number_format($safeDailyBudget, 0, ',', '.') }} <span class="text-xs font-normal text-[#A9B9A3]">/ hari</span>
                </div>
                <p class="text-[11px] text-[#A9B9A3] leading-normal">
                    Agar uangmu bertahan pas sampai akhir bulan (sisa {{ $remainingDaysInMonth }} hari), jangan belanja lebih dari nominal ini per hari.
                </p>
            </div>

        </div>
        <!-- Decorative Circle -->
        <div class="absolute -right-12 -bottom-12 w-64 h-64 rounded-full bg-white/5 pointer-events-none"></div>
    </div>

    <!-- Breakdown Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white p-5 rounded-2xl border border-[#E8E8E1] shadow-sm">
            <span class="text-xs font-semibold text-[#777D75] uppercase">Total Saldo Saat Ini</span>
            <p class="text-xl font-bold text-[#242923] mt-1">Rp {{ number_format($netBalance, 0, ',', '.') }}</p>
        </div>
        
        <div class="bg-white p-5 rounded-2xl border border-[#E8E8E1] shadow-sm">
            <span class="text-xs font-semibold text-[#777D75] uppercase">Tagihan Belum Lunas</span>
            <p class="text-xl font-bold text-[#C65B55] mt-1">-Rp {{ number_format($unpaidBills, 0, ',', '.') }}</p>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-[#E8E8E1] shadow-sm">
            <span class="text-xs font-semibold text-[#777D75] uppercase">Sisa Uang Bebas Pakai</span>
            <p class="text-xl font-bold text-[#174D3A] mt-1">Rp {{ number_format($availableMoney, 0, ',', '.') }}</p>
        </div>
    </div>

    <!-- Interactive Simulation Note -->
    <div class="bg-white p-6 rounded-2xl border border-[#E8E8E1] shadow-sm flex items-start gap-4">
        <div class="w-10 h-10 rounded-xl bg-[#174D3A]/10 text-[#174D3A] flex items-center justify-center shrink-0">
            <i data-lucide="sparkles" class="w-5 h-5"></i>
        </div>
        <div class="space-y-1">
            <h3 class="font-bold text-base text-[#242923]">Sistem Kalkulasi Otomatis</h3>
            <p class="text-sm text-[#777D75] leading-relaxed">
                Setiap kali kamu menerima kiriman orang tua (misal Rp1.000.000) dan mencatatnya di menu <strong>Transaksi (Pemasukan)</strong>, atau membayar tagihan kos di menu <strong>Tagihan</strong>, angka ketahanan hari ini akan otomatis terkalkulasi ulang!
            </p>
        </div>
    </div>

</div>
@endsection