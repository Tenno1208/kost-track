@extends('layouts.app')

@section('header', 'Manajemen Tagihan Kos')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Form Tambah Tagihan -->
    <div class="bg-white p-6 rounded-2xl border border-[#E8E8E1] shadow-sm">
        <h2 class="font-bold text-base text-[#242923] mb-4">Tambah Tagihan Baru</h2>
        <form action="{{ route('bills.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-[#242923] mb-1">Nama Tagihan</label>
                <input type="text" name="name" placeholder="Contoh: Listrik Kos / Wi-Fi" class="w-full rounded-xl border-[#E8E8E1] text-sm focus:border-[#174D3A] focus:ring-[#174D3A]" required>
            </div>
            <div>
                <label class="block text-sm font-semibold text-[#242923] mb-1">Nominal (Rp)</label>
                <input type="number" name="amount" placeholder="Contoh: 150000" class="w-full rounded-xl border-[#E8E8E1] text-sm focus:border-[#174D3A] focus:ring-[#174D3A]" required>
            </div>
            <div>
                <label class="block text-sm font-semibold text-[#242923] mb-1">Tanggal Jatuh Tempo</label>
                <input type="date" name="due_date" class="w-full rounded-xl border-[#E8E8E1] text-sm focus:border-[#174D3A] focus:ring-[#174D3A]" required>
            </div>
            <button type="submit" class="w-full bg-[#174D3A] text-white py-2.5 rounded-xl text-sm font-semibold shadow-sm hover:bg-[#174D3A]/90 transition-colors">Simpan Tagihan</button>
        </form>
    </div>

    <!-- Daftar Tagihan -->
    <div class="bg-white p-6 rounded-2xl border border-[#E8E8E1] shadow-sm lg:col-span-2">
        <h2 class="font-bold text-base text-[#242923] mb-4">Daftar Tagihan & Pengingat</h2>
        <div class="space-y-3">
            @forelse($bills as $bill)
                <div class="p-4 rounded-xl bg-[#F8F7F2] border border-[#E8E8E1] flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div>
                        <h3 class="font-semibold text-[#242923] text-sm">{{ $bill->name }}</h3>
                        <p class="text-xs text-[#777D75] mt-0.5">Jatuh tempo: {{ \Carbon\Carbon::parse($bill->due_date)->format('d M Y') }}</p>
                    </div>
                    <div class="flex items-center gap-4 w-full sm:w-auto justify-between sm:justify-end">
                        <span class="font-bold text-sm text-[#242923]">Rp {{ number_format($bill->amount, 0, ',', '.') }}</span>
                        
                        <div class="flex items-center gap-2">
                            <form action="{{ route('bills.status', $bill->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="px-3 py-1.5 rounded-lg text-xs font-semibold {{ $bill->status == 'paid' ? 'bg-[#A9B9A3]/30 text-[#174D3A]' : 'bg-[#C65B55]/10 text-[#C65B55]' }}">
                                    {{ $bill->status == 'paid' ? 'Lunas' : 'Belum Lunas' }}
                                </button>
                            </form>
                            <form action="{{ route('bills.destroy', $bill->id) }}" method="POST" onsubmit="return confirm('Hapus tagihan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-[#777D75] hover:text-[#C65B55]"><i data-lucide="trash-2" class="w-4 h-4"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-8 text-[#777D75] text-sm">
                    Belum ada tagihan kos yang dicatat.
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection