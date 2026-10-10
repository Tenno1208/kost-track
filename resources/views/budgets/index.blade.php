@extends('layouts.app')

@section('header', 'Manajemen Anggaran Bulanan')

@section('content')
<div class="space-y-6">
    <!-- Filter Bulan & Form Tambah Anggaran -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Form Tambah Anggaran -->
        <div class="bg-white p-6 rounded-2xl border border-[#E8E8E1] shadow-sm">
            <h2 class="font-bold text-base text-[#242923] mb-4">Atur Anggaran Kategori</h2>
            <form action="{{ route('budgets.store') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="month" value="{{ request('month', date('Y-m')) }}">
                
                <div>
                    <label class="block text-sm font-semibold text-[#242923] mb-1">Kategori Pengeluaran</label>
                    <select name="category_id" class="w-full rounded-xl border-[#E8E8E1] text-sm focus:border-[#174D3A] focus:ring-[#174D3A]" required>
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-[#242923] mb-1">Batas Maksimal (Rp)</label>
                    <input type="number" name="amount" placeholder="Contoh: 1000000" class="w-full rounded-xl border-[#E8E8E1] text-sm focus:border-[#174D3A] focus:ring-[#174D3A]" required>
                </div>

                <button type="submit" class="w-full bg-[#174D3A] text-white py-2.5 rounded-xl text-sm font-semibold shadow-sm hover:bg-[#174D3A]/90 transition-colors">Simpan Anggaran</button>
            </form>
        </div>

        <!-- Daftar Anggaran & Progress Bar -->
        <div class="bg-white p-6 rounded-2xl border border-[#E8E8E1] shadow-sm lg:col-span-2">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="font-bold text-base text-[#242923]">Progress Anggaran Bulan Ini</h2>
                    <p class="text-xs text-[#777D75]">Pantau batas pengeluaran per kategori</p>
                </div>
                <form method="GET" action="{{ route('budgets.index') }}">
                    <input type="month" name="month" value="{{ request('month', date('Y-m')) }}" onchange="this.form.submit()" class="rounded-xl border-[#E8E8E1] text-sm focus:border-[#174D3A]">
                </form>
            </div>

            <div class="space-y-4">
                @forelse($budgets as $budget)
                    @php
                        $spent = $expenses[$budget->category_id] ?? 0;
                        $percentage = $budget->amount > 0 ? min(100, ($spent / $budget->amount) * 100) : 0;
                        $isExceeded = $spent > $budget->amount;
                    @endphp
                    <div class="p-4 rounded-xl bg-[#F8F7F2] border border-[#E8E8E1] space-y-2">
                        <div class="flex justify-between items-center text-sm">
                            <span class="font-semibold text-[#242923] flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full" style="background-color: {{ $budget->category->color ?? '#174D3A' }}"></span>
                                {{ $budget->category->name }}
                            </span>
                            <div class="flex items-center gap-4">
                                <span class="text-xs font-medium {{ $isExceeded ? 'text-[#C65B55] font-bold' : 'text-[#777D75]' }}">
                                    Rp {{ number_format($spent, 0, ',', '.') }} / Rp {{ number_format($budget->amount, 0, ',', '.') }}
                                </span>
                                <form action="{{ route('budgets.destroy', $budget->id) }}" method="POST" onsubmit="return confirm('Hapus anggaran ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-[#C65B55] hover:opacity-80"><i data-lucide="trash-2" class="w-4 h-4"></i></button>
                                </form>
                            </div>
                        </div>
                        <!-- Progress Bar -->
                        <div class="w-full bg-[#E8E8E1] h-2 rounded-full overflow-hidden">
                            <div class="h-full rounded-full {{ $isExceeded ? 'bg-[#C65B55]' : 'bg-[#174D3A]' }}" style="width: {{ $percentage }}%"></div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 text-[#777D75] text-sm">
                        Belum ada anggaran yang diatur untuk bulan ini.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection