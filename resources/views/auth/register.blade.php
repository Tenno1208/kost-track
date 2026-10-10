<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-[#F8F7F2] p-4 font-sans selection:bg-[#174D3A] selection:text-white">
        <div class="w-full max-w-md bg-white p-8 rounded-3xl border border-[#E8E8E1] shadow-sm space-y-6">
            <!-- Brand Logo & Header -->
            <div class="text-center space-y-2">
                <a href="/" class="inline-flex items-center gap-3">
                    <div class="w-11 h-11 rounded-2xl bg-[#174D3A] flex items-center justify-center text-white font-bold text-xl shadow-sm">
                        K
                    </div>
                </a>
                <h1 class="text-2xl font-extrabold text-[#242923] tracking-tight">Buat Akun KosTrack</h1>
                <p class="text-xs text-[#777D75]">Mulai atur uang bulanan kosmu dengan lebih terencana</p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                <!-- Name -->
                <div>
                    <label for="name" class="block text-xs font-semibold text-[#242923] uppercase tracking-wider mb-1">Nama Lengkap</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="Contoh: Tenno Haika"
                        class="w-full rounded-xl border-[#E8E8E1] text-sm text-[#242923] focus:border-[#174D3A] focus:ring-[#174D3A] py-2.5 px-3.5 bg-[#F8F7F2]/50">
                    <x-input-error :messages="$errors->get('name')" class="mt-1 text-xs text-[#C65B55]" />
                </div>

                <!-- Email Address -->
                <div>
                    <label for="email" class="block text-xs font-semibold text-[#242923] uppercase tracking-wider mb-1">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="nama@email.com"
                        class="w-full rounded-xl border-[#E8E8E1] text-sm text-[#242923] focus:border-[#174D3A] focus:ring-[#174D3A] py-2.5 px-3.5 bg-[#F8F7F2]/50">
                    <x-input-error :messages="$errors->get('email')" class="mt-1 text-xs text-[#C65B55]" />
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-xs font-semibold text-[#242923] uppercase tracking-wider mb-1">Password</label>
                    <input id="password" type="password" name="password" required autocomplete="new-password" placeholder="Minimal 8 karakter"
                        class="w-full rounded-xl border-[#E8E8E1] text-sm text-[#242923] focus:border-[#174D3A] focus:ring-[#174D3A] py-2.5 px-3.5 bg-[#F8F7F2]/50">
                    <x-input-error :messages="$errors->get('password')" class="mt-1 text-xs text-[#C65B55]" />
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-xs font-semibold text-[#242923] uppercase tracking-wider mb-1">Konfirmasi Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Ulangi password di atas"
                        class="w-full rounded-xl border-[#E8E8E1] text-sm text-[#242923] focus:border-[#174D3A] focus:ring-[#174D3A] py-2.5 px-3.5 bg-[#F8F7F2]/50">
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-xs text-[#C65B55]" />
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full py-3 px-4 rounded-xl bg-[#174D3A] text-white font-bold text-sm shadow-md shadow-[#174D3A]/10 hover:bg-[#174D3A]/90 transition-all active:scale-[0.99]">
                    Daftar Sekarang
                </button>
            </form>

            <!-- Footer Link -->
            <div class="text-center pt-2 border-t border-[#E8E8E1]">
                <p class="text-xs text-[#777D75]">
                    Sudah punya akun? 
                    <a href="{{ route('login') }}" class="font-bold text-[#174D3A] hover:underline">Masuk di sini</a>
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>