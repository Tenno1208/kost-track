@extends('layouts.app')

@section('header', 'Tambah Transaksi')

@section('content')
<div class="max-w-xl mx-auto bg-white p-6 rounded-2xl border border-[#E8E8E1] shadow-sm">
    <form action="{{ route('transactions.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-semibold text-[#242923] mb-1">Jenis Transaksi</label>
            <select name="type" id="type" class="w-full rounded-xl border-[#E8E8E1] text-sm focus:border-[#174D3A] focus:ring-[#174D3A]" required>
                <option value="expense" {{ old('type') == 'expense' ? 'selected' : '' }}>Pengeluaran</option>
                <option value="income" {{ old('type') == 'income' ? 'selected' : '' }}>Pemasukan</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-semibold text-[#242923] mb-1">Kategori</label>
            <select name="category_id" class="w-full rounded-xl border-[#E8E8E1] text-sm focus:border-[#174D3A] focus:ring-[#174D3A]" required>
                <option value="">Pilih Kategori</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }} ({{ ucfirst($cat->type) }})</option>
                @endforeach
            </select>
            @error('category_id') <span class="text-xs text-[#C65B55] mt-1">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-semibold text-[#242923] mb-1">Nominal (Rp)</label>
            <input type="number" name="amount" value="{{ old('amount') }}" step="0.01" placeholder="Contoh: 50000" class="w-full rounded-xl border-[#E8E8E1] text-sm focus:border-[#174D3A] focus:ring-[#174D3A]" required>
            @error('amount') <span class="text-xs text-[#C65B55] mt-1">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-semibold text-[#242923] mb-1">Tanggal Transaksi</label>
            <input type="date" name="transaction_date" value="{{ old('transaction_date', date('Y-m-d')) }}" class="w-full rounded-xl border-[#E8E8E1] text-sm focus:border-[#174D3A] focus:ring-[#174D3A]" required>
            @error('transaction_date') <span class="text-xs text-[#C65B55] mt-1">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-semibold text-[#242923] mb-1">Catatan (Opsional)</label>
            <textarea name="notes" rows="3" placeholder="Contoh: Beli nasi padang di depan gang" class="w-full rounded-xl border-[#E8E8E1] text-sm focus:border-[#174D3A] focus:ring-[#174D3A]">{{ old('notes') }}</textarea>
            @error('notes') <span class="text-xs text-[#C65B55] mt-1">{{ $message }}</span> @enderror
        </div>

        <div class="flex items-center justify-end gap-3 pt-4 border-t border-[#E8E8E1]">
            <a href="{{ route('transactions.index') }}" class="px-4 py-2.5 rounded-xl text-sm font-medium text-[#777D75] hover:bg-[#F8F7F2] transition-colors">Batal</a>
            <button type="submit" class="px-5 py-2.5 rounded-xl bg-[#174D3A] text-white text-sm font-semibold shadow-sm hover:bg-[#174D3A]/90 transition-colors">Simpan Transaksi</button>
        </div>
    </form>
</div>
@endsection