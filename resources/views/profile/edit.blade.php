@extends('layouts.app')

@section('header', 'Pengaturan Profil')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <!-- Informational Card -->
    <div class="bg-white p-6 rounded-2xl border border-[#E8E8E1] shadow-sm space-y-4">
        <h2 class="font-bold text-base text-[#242923]">Informasi Akun</h2>
        <form method="post" action="{{ route('profile.update') }}" class="space-y-4">
            @csrf
            @method('patch')

            <div>
                <label class="block text-sm font-semibold text-[#242923] mb-1">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full rounded-xl border-[#E8E8E1] text-sm focus:border-[#174D3A] focus:ring-[#174D3A]" required>
            </div>

            <div>
                <label class="block text-sm font-semibold text-[#242923] mb-1">Alamat Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full rounded-xl border-[#E8E8E1] text-sm focus:border-[#174D3A] focus:ring-[#174D3A]" required>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-[#174D3A] text-white text-sm font-semibold shadow-sm hover:bg-[#174D3A]/90 transition-colors">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection