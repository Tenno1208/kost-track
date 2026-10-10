@extends('layouts.app')

@section('header', 'Edit Transaksi')

@section('content')
<div class="max-w-xl mx-auto bg-white p-6 rounded-2xl border border-[#E8E8E1] shadow-sm">
    <form action="{{ route('transactions.update', $transaction->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-semibold text-[#242923] mb-1">Jenis Transaksi</label>
            <select name="type" class="w-full rounded-xl border-[#E8E8E1] text-sm focus:border-[#174D3A] focus:ring-[#174D3A]" required>
                <option value="expense" {{ old('type', $transaction->type) == 'expense' ? 'selected' : '' }}>Pengeluaran</option>
                <option value="income" {{ old('type', $transaction->type) == 'income' ? 'selected' : '' }}>Pemasukan</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-semibold text-[#242923] mb-1">Kategori</label>
            <select name="category_id" class="w-full rounded-xl border-[#E8E8E1] text-sm focus:border-[#174D3A] focus:ring-[#174D3A]" required>
                <option value="">Pilih Kategori</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ old('category_id', $transaction->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }} ({{ ucfirst($cat->type) }})</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-semibold text-[#242923] mb-1">Nominal (Rp)</label>
            <input type="number" name="amount" value="{{ old('amount', $transaction->amount) }}" step="0.01" class="w-full rounded-xl border-[#E8E8E1] text-sm focus:border-[#174D3A] focus:ring-[#174D3A]" required>
        </div>

        <div>
            <label class="block text-sm font-semibold text-[#242923] mb-1">Tanggal Transaksi</label>
            <input type="date" name="transaction_date" value="{{ old('transaction_date', $transaction->transaction_date->format('Y-m-d')) }}" class="w-full rounded-xl border-[#E8E8E1] text-sm focus:border-[#174D3A] focus:ring-[#174D3A]" required>
        </div>

        <div>
            <label class="block text-sm font-semibold text-[#242923] mb-1">Catatan (Opsional)</label>
            <textarea name="notes" rows="3" class="w-full rounded-xl border-[#E8E8E1] text-sm focus:border-[#174D3A] focus:ring-[#174D3A]">{{ old('notes', $transaction->notes) }}</textarea>
        </div>

        <div class="flex items-center justify-end gap-3 pt-4 border-t border-[#E8E8E1]">
            <a href="{{ route('transactions.index') }}" class="px-4 py-2.5 rounded-xl text-sm font-medium text-[#777D75] hover:bg-[#F8F7F2] transition-colors">Batal</a>
            <button type="submit" class="px-5 py-2.5 rounded-xl bg-[#174D3A] text-white text-sm font-semibold shadow-sm hover:bg-[#174D3A]/90 transition-colors">Perbarui Transaksi</button>
        </div>
    </form>
</div>
@endsection