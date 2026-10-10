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
                <h1 class="text-2xl font-extrabold text-[#242923] tracking-tight">Selamat Datang Kembali</h1>
                <p class="text-xs text-[#777D75]">Masuk ke akun KosTrack untuk mengelola keuanganmu</p>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                <!-- Email Address -->
                <div>
                    <label for="email" class="block text-xs font-semibold text-[#242923] uppercase tracking-wider mb-1">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                        class="w-full rounded-xl border-[#E8E8E1] text-sm text-[#242923] focus:border-[#174D3A] focus:ring-[#174D3A] py-2.5 px-3.5 bg-[#F8F7F2]/50">
                    <x-input-error :messages="$errors->get('email')" class="mt-1 text-xs text-[#C65B55]" />
                </div>

                <!-- Password -->
                <div>
                    <div class="flex items-center justify-between mb-1">
                        <label for="password" class="block text-xs font-semibold text-[#242923] uppercase tracking-wider">Password</label>
                        @if (Route::has('password.request'))
                            <a class="text-xs font-semibold text-[#174D3A] hover:underline" href="{{ route('password.request') }}">
                                Lupa password?
                            </a>
                        @endif
                    </div>
                    <input id="password" type="password" name="password" required autocomplete="current-password"
                        class="w-full rounded-xl border-[#E8E8E1] text-sm text-[#242923] focus:border-[#174D3A] focus:ring-[#174D3A] py-2.5 px-3.5 bg-[#F8F7F2]/50">
                    <x-input-error :messages="$errors->get('password')" class="mt-1 text-xs text-[#C65B55]" />
                </div>

                <!-- Remember Me -->
                <div class="flex items-center">
                    <input id="remember_me" type="checkbox" name="remember" class="rounded border-[#E8E8E1] text-[#174D3A] focus:ring-[#174D3A]">
                    <label for="remember_me" class="ml-2 text-xs text-[#777D75]">Ingat saya di perangkat ini</label>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full py-3 px-4 rounded-xl bg-[#174D3A] text-white font-bold text-sm shadow-md shadow-[#174D3A]/10 hover:bg-[#174D3A]/90 transition-all active:scale-[0.99]">
                    Masuk Akun
                </button>
            </form>

            <!-- Footer Link -->
            <div class="text-center pt-2 border-t border-[#E8E8E1]">
                <p class="text-xs text-[#777D75]">
                    Belum punya akun KosTrack? 
                    <a href="{{ route('register') }}" class="font-bold text-[#174D3A] hover:underline">Daftar Sekarang</a>
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>