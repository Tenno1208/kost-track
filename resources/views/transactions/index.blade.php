@extends('layouts.app')

@section('header', 'Daftar Transaksi')

@section('content')
<div class="space-y-6">
    <!-- Header & Tombol Tambah -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <p class="text-sm text-[#777D75]">Kelola seluruh pemasukan dan pengeluaran harianmu di sini.</p>
        </div>
        <a href="{{ route('transactions.create') }}" class="inline-flex items-center gap-2 bg-[#174D3A] text-white px-4 py-2.5 rounded-xl text-sm font-semibold shadow-sm hover:bg-[#174D3A]/90 transition-colors">
            <i data-lucide="plus" class="w-4 h-4"></i>
            <span>Tambah Transaksi</span>
        </a>
    </div>

    <!-- Filter & Pencarian -->
    <div class="bg-white p-4 rounded-2xl border border-[#E8E8E1] shadow-sm">
        <form method="GET" action="{{ route('transactions.index') }}" class="grid grid-cols-1 sm:grid-cols-4 gap-4">
            <div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari catatan..." class="w-full rounded-xl border-[#E8E8E1] text-sm focus:border-[#174D3A] focus:ring-[#174D3A]">
            </div>
            <div>
                <select name="type" class="w-full rounded-xl border-[#E8E8E1] text-sm focus:border-[#174D3A] focus:ring-[#174D3A]">
                    <option value="">Semua Jenis</option>
                    <option value="income" {{ request('type') == 'income' ? 'selected' : '' }}>Pemasukan</option>
                    <option value="expense" {{ request('type') == 'expense' ? 'selected' : '' }}>Pengeluaran</option>
                </select>
            </div>
            <div>
                <select name="category_id" class="w-full rounded-xl border-[#E8E8E1] text-sm focus:border-[#174D3A] focus:ring-[#174D3A]">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-center gap-2">
                <button type="submit" class="w-full bg-[#174D3A] text-white py-2.5 rounded-xl text-sm font-medium hover:bg-[#174D3A]/90 transition-colors">Filter</button>
                <a href="{{ route('transactions.index') }}" class="bg-[#F8F7F2] border border-[#E8E8E1] text-[#777D75] px-4 py-2.5 rounded-xl text-sm font-medium hover:text-[#242923] transition-colors">Reset</a>
            </div>
        </form>
    </div>

    <!-- Tabel Transaksi -->
    <div class="bg-white rounded-2xl border border-[#E8E8E1] shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#F8F7F2] border-b border-[#E8E8E1] text-xs font-semibold text-[#777D75] uppercase tracking-wider">
                        <th class="py-3.5 px-6">Tanggal</th>
                        <th class="py-3.5 px-6">Kategori</th>
                        <th class="py-3.5 px-6">Catatan</th>
                        <th class="py-3.5 px-6">Nominal</th>
                        <th class="py-3.5 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E8E8E1] text-sm">
                    @forelse($transactions as $trx)
                        <tr class="hover:bg-[#F8F7F2]/50 transition-colors">
                            <td class="py-4 px-6 text-[#777D75] whitespace-nowrap">
                                {{ \Carbon\Carbon::parse($trx->transaction_date)->format('d M Y') }}
                            </td>
                            <td class="py-4 px-6 font-medium text-[#242923]">
                                <span class="inline-flex items-center gap-2">
                                    <span class="w-2.5 h-2.5 rounded-full" style="background-color: {{ $trx->category->color ?? '#174D3A' }}"></span>
                                    {{ $trx->category->name ?? '-' }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-[#777D75]">
                                {{ $trx->notes ?: '-' }}
                            </td>
                            <td class="py-4 px-6 font-bold {{ $trx->type == 'income' ? 'text-[#174D3A]' : 'text-[#C65B55]' }}">
                                {{ $trx->type == 'income' ? '+' : '-' }}Rp {{ number_format($trx->amount, 0, ',', '.') }}
                            </td>
                            <td class="py-4 px-6 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('transactions.edit', $trx->id) }}" class="p-2 rounded-lg text-[#777D75] hover:bg-[#F8F7F2] hover:text-[#242923] transition-colors">
                                        <i data-lucide="pencil" class="w-4 h-4"></i>
                                    </a>
                                    <form action="{{ route('transactions.destroy', $trx->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus transaksi ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 rounded-lg text-[#C65B55] hover:bg-[#C65B55]/10 transition-colors">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center text-[#777D75]">
                                <div class="flex flex-col items-center justify-center gap-2">
                                    <i data-lucide="receipt" class="w-10 h-10 text-[#777D75]/50"></i>
                                    <p class="font-medium">Belum ada data transaksi.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($transactions->hasPages())
            <div class="p-4 border-t border-[#E8E8E1]">
                {{ $transactions->links() }}
            </div>
        @endif
    </div>
</div>
@endsection