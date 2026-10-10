@extends('layouts.app')

@section('header', 'Laporan Keuangan')

@section('content')
<div class="space-y-6">
    <!-- Header & Filter Bulan -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white p-6 rounded-2xl border border-[#E8E8E1] shadow-sm">
        <div>
            <h2 class="font-bold text-base text-[#242923]">Laporan Keuangan Bulanan</h2>
            <p class="text-xs text-[#777D75]">Analisis arus kas dan distribusi pengeluaranmu</p>
        </div>
        
        <div class="flex items-center gap-3">
            <!-- Filter Bulan -->
            <form method="GET" action="{{ route('reports.index') }}" class="flex items-center gap-2">
                <input type="month" name="month" value="{{ $selectedMonth }}" onchange="this.form.submit()" class="rounded-xl border-[#E8E8E1] text-sm focus:border-[#174D3A]">
            </form>

            <!-- Tombol Unduh PDF -->
            <a href="{{ route('reports.pdf', ['month' => $selectedMonth]) }}" class="inline-flex items-center gap-2 bg-[#174D3A] text-white px-4 py-2.5 rounded-xl text-xs font-semibold hover:bg-[#174D3A]/90 transition-colors shadow-sm">
                <i data-lucide="download" class="w-4 h-4"></i>
                <span>Unduh PDF</span>
            </a>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-2xl border border-[#E8E8E1] shadow-sm">
            <span class="text-xs font-semibold uppercase tracking-wider text-[#777D75]">Total Pemasukan</span>
            <div class="text-2xl font-bold text-[#174D3A] mt-2">
                +Rp {{ number_format($totalIncome, 0, ',', '.') }}
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-[#E8E8E1] shadow-sm">
            <span class="text-xs font-semibold uppercase tracking-wider text-[#777D75]">Total Pengeluaran</span>
            <div class="text-2xl font-bold text-[#C65B55] mt-2">
                -Rp {{ number_format($totalExpense, 0, ',', '.') }}
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-[#E8E8E1] shadow-sm">
            <span class="text-xs font-semibold uppercase tracking-wider text-[#777D75]">Sisa Kas (Net)</span>
            <div class="text-2xl font-bold {{ $netSavings >= 0 ? 'text-[#174D3A]' : 'text-[#C65B55]' }} mt-2">
                Rp {{ number_format($netSavings, 0, ',', '.') }}
            </div>
        </div>
    </div>

    <!-- Charts & Category Breakdown -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Visualisasi Grafik -->
        <div class="bg-white p-6 rounded-2xl border border-[#E8E8E1] shadow-sm flex flex-col justify-between">
            <h3 class="font-bold text-base text-[#242923] mb-4">Proporsi Pengeluaran</h3>
            <div class="relative h-64 flex items-center justify-center">
                @if(count($categoryTotals) > 0)
                    <canvas id="reportChart"></canvas>
                @else
                    <div class="text-center text-[#777D75] text-sm">
                        <i data-lucide="bar-chart-2" class="w-8 h-8 mx-auto mb-2 opacity-50"></i>
                        <p>Tidak ada transaksi pengeluaran pada bulan ini.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Rincian Kategori Pengeluaran -->
        <div class="bg-white p-6 rounded-2xl border border-[#E8E8E1] shadow-sm">
            <h3 class="font-bold text-base text-[#242923] mb-4">Kategori Pengeluaran Terbesar</h3>
            <div class="space-y-4">
                @forelse($categoryBreakdown as $item)
                    @php
                        $percentage = $totalExpense > 0 ? ($item->total / $totalExpense) * 100 : 0;
                    @endphp
                    <div class="space-y-1">
                        <div class="flex justify-between items-center text-sm">
                            <span class="font-semibold text-[#242923] flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full" style="background-color: {{ $item->category->color ?? '#174D3A' }}"></span>
                                {{ $item->category->name ?? 'Lain-lain' }}
                            </span>
                            <span class="font-bold text-[#242923]">
                                Rp {{ number_format($item->total, 0, ',', '.') }} <span class="text-xs text-[#777D75] font-normal">({{ number_format($percentage, 1) }}%)</span>
                            </span>
                        </div>
                        <div class="w-full bg-[#E8E8E1] h-2 rounded-full overflow-hidden">
                            <div class="h-full rounded-full" style="width: {{ $percentage }}%; background-color: {{ $item->category->color ?? '#174D3A' }}"></div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 text-[#777D75] text-sm">
                        Belum ada data pengeluaran.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@if(count($categoryTotals) > 0)
<script>
    const ctx = document.getElementById('reportChart').getContext('2d');
    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: {!! json_encode($categoryNames) !!},
            datasets: [{
                data: {!! json_encode($categoryTotals) !!},
                backgroundColor: {!! json_encode($categoryColors) !!},
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        boxWidth: 12,
                        font: { family: 'Plus Jakarta Sans', size: 11 },
                        color: '#242923'
                    }
                }
            }
        }
    });
</script>
@endif
@endsection