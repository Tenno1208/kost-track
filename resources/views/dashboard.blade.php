@extends('layouts.app')

@section('header', 'Ringkasan Keuangan')

@section('content')
<div class="space-y-6">
    
    <!-- Top Summary Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
        <!-- Total Saldo -->
        <div class="bg-white p-6 rounded-2xl border border-[#E8E8E1] shadow-sm">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-semibold uppercase tracking-wider text-[#777D75]">Total Saldo</span>
                <div class="w-8 h-8 rounded-xl bg-[#174D3A]/10 text-[#174D3A] flex items-center justify-center">
                    <i data-lucide="wallet" class="w-4 h-4"></i>
                </div>
            </div>
            <div class="text-2xl font-bold text-[#242923]">
                Rp {{ number_format($balance, 0, ',', '.') }}
            </div>
            <p class="text-xs text-[#777D75] mt-1">Akumulasi seluruh saldo bersih</p>
        </div>

        <!-- Pemasukan Bulan Ini -->
        <div class="bg-white p-6 rounded-2xl border border-[#E8E8E1] shadow-sm">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-semibold uppercase tracking-wider text-[#777D75]">Pemasukan (Bulan Ini)</span>
                <div class="w-8 h-8 rounded-xl bg-[#A9B9A3]/20 text-[#174D3A] flex items-center justify-center">
                    <i data-lucide="arrow-down-left" class="w-4 h-4"></i>
                </div>
            </div>
            <div class="text-2xl font-bold text-[#174D3A]">
                +Rp {{ number_format($monthlyIncome, 0, ',', '.') }}
            </div>
            <p class="text-xs text-[#777D75] mt-1">Total pemasukan bulan berjalan</p>
        </div>

        <!-- Pengeluaran Bulan Ini -->
        <div class="bg-white p-6 rounded-2xl border border-[#E8E8E1] shadow-sm">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-semibold uppercase tracking-wider text-[#777D75]">Pengeluaran (Bulan Ini)</span>
                <div class="w-8 h-8 rounded-xl bg-[#C65B55]/10 text-[#C65B55] flex items-center justify-center">
                    <i data-lucide="arrow-up-right" class="w-4 h-4"></i>
                </div>
            </div>
            <div class="text-2xl font-bold text-[#C65B55]">
                -Rp {{ number_format($monthlyExpense, 0, ',', '.') }}
            </div>
            <p class="text-xs text-[#777D75] mt-1">Total pengeluaran bulan berjalan</p>
        </div>
    </div>

    <!-- Charts & Quick Insights Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Grafik Kategori Pengeluaran -->
        <div class="bg-white p-6 rounded-2xl border border-[#E8E8E1] shadow-sm lg:col-span-2 flex flex-col justify-between">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h2 class="font-bold text-base text-[#242923]">Pengeluaran Berdasarkan Kategori</h2>
                    <p class="text-xs text-[#777D75]">Distribusi pengeluaran bulan ini</p>
                </div>
            </div>
            <div class="relative h-64 flex items-center justify-center">
                @if(count($categoryTotals) > 0)
                    <canvas id="expenseCategoryChart"></canvas>
                @else
                    <div class="text-center text-[#777D75] text-sm">
                        <i data-lucide="pie-chart" class="w-8 h-8 mx-auto mb-2 opacity-50"></i>
                        <p>Belum ada data pengeluaran bulan ini.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Quick Summary Card -->
        <div class="bg-[#174D3A] text-white p-6 rounded-2xl shadow-sm flex flex-col justify-between">
            <div>
                <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center mb-4">
                    <i data-lucide="shield-check" class="w-5 h-5 text-white"></i>
                </div>
                <h3 class="font-bold text-lg mb-2">Tips Keuangan Anak Kos</h3>
                <p class="text-xs text-[#A9B9A3] leading-relaxed">
                    Pastikan untuk selalu mencatat pengeluaran kecil seperti ongkos parkir atau jajanan warung agar fitur **Safe-to-Spend** dapat memprediksi sisa uang kamu dengan akurat.
                </p>
            </div>
            <div class="pt-6 mt-6 border-t border-white/10">
                <a href="{{ route('transactions.create') }}" class="inline-flex items-center justify-center w-full bg-white text-[#174D3A] font-semibold py-2.5 px-4 rounded-xl text-sm hover:bg-[#F8F7F2] transition-colors">
                    + Catat Transaksi Baru
                </a>
            </div>
        </div>
    </div>

    <!-- Tabel Transaksi Terbaru -->
    <div class="bg-white rounded-2xl border border-[#E8E8E1] shadow-sm overflow-hidden">
        <div class="p-6 border-b border-[#E8E8E1] flex items-center justify-between">
            <div>
                <h2 class="font-bold text-base text-[#242923]">Transaksi Terbaru</h2>
                <p class="text-xs text-[#777D75]">5 catatan keuangan terakhir Anda</p>
            </div>
            <a href="{{ route('transactions.index') }}" class="text-xs font-semibold text-[#174D3A] hover:underline">Lihat Semua →</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#F8F7F2] border-b border-[#E8E8E1] text-xs font-semibold text-[#777D75] uppercase tracking-wider">
                        <th class="py-3 px-6">Tanggal</th>
                        <th class="py-3 px-6">Kategori</th>
                        <th class="py-3 px-6">Catatan</th>
                        <th class="py-3 px-6 text-right">Nominal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E8E8E1] text-sm">
                    @forelse($recentTransactions as $trx)
                        <tr class="hover:bg-[#F8F7F2]/50 transition-colors">
                            <td class="py-3.5 px-6 text-[#777D75] whitespace-nowrap">
                                {{ \Carbon\Carbon::parse($trx->transaction_date)->format('d M Y') }}
                            </td>
                            <td class="py-3.5 px-6 font-medium text-[#242923]">
                                <span class="inline-flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full" style="background-color: {{ $trx->category->color ?? '#174D3A' }}"></span>
                                    {{ $trx->category->name ?? '-' }}
                                </span>
                            </td>
                            <td class="py-3.5 px-6 text-[#777D75]">
                                {{ $trx->notes ?: '-' }}
                            </td>
                            <td class="py-3.5 px-6 text-right font-bold {{ $trx->type == 'income' ? 'text-[#174D3A]' : 'text-[#C65B55]' }}">
                                {{ $trx->type == 'income' ? '+' : '-' }}Rp {{ number_format($trx->amount, 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-8 text-center text-[#777D75] text-sm">
                                Belum ada transaksi tercatat.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@if(count($categoryTotals) > 0)
<script>
    const ctx = document.getElementById('expenseCategoryChart').getContext('2d');
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($categoryLabels) !!},
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
                        font: {
                            family: 'Plus Jakarta Sans',
                            size: 11
                        },
                        color: '#242923'
                    }
                }
            },
            cutout: '70%'
        }
    });
</script>
@endif
@endsection