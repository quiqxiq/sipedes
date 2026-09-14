@extends('layouts.auth')

@section('title', 'Masuk Akun Warga — SIPEDES Desa Rombiya Barat')

@section('content')
<div class="max-w-md w-full space-y-7 bg-white p-7 sm:p-9 rounded-3xl border border-slate-200/80 shadow-sm">
    <div class="text-center space-y-2">
        <img src="{{ asset('images/logo.png') }}" alt="Logo Desa Rombiya Barat" class="w-16 h-16 object-contain mx-auto">
        <h2 class="text-2xl font-extrabold text-slate-900">Masuk Akun Warga</h2>
        <p class="text-xs text-slate-500">SIPEDES Desa Rombiya Barat — Masukkan NIK dan kata sandi Anda untuk mengakses layanan surat.</p>
    </div>

    <form class="mt-6 space-y-5" action="{{ route('warga.login.store') }}" method="POST">
        @csrf

        <div>
            <label for="nik" class="block text-xs font-semibold text-slate-700 mb-1">Nomor Induk Kependudukan (NIK)</label>
            <input id="nik" name="nik" type="text" inputmode="numeric" pattern="[0-9]{16}" maxlength="16" 
                value="{{ old('nik') }}" required autofocus placeholder="Masukkan 16 digit NIK Anda" 
                oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 16);"
                class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all @error('nik') border-rose-500 @enderror">
            @error('nik')
                <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password" class="block text-xs font-semibold text-slate-700 mb-1">Kata Sandi</label>
            <div class="relative">
                <input id="password" name="password" type="password" required placeholder="••••••••" 
                    class="w-full px-4 py-3 pr-11 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all @error('password') border-rose-500 @enderror">
                <button type="button" onclick="togglePasswordVisibility('password', this)" 
                    class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-emerald-600 focus:outline-none p-1.5 rounded-lg transition-colors" 
                    title="Tampilkan / Sembunyikan Kata Sandi" aria-label="Tampilkan kata sandi">
                    <!-- Eye Icon (Password Hidden) -->
                    <svg class="w-5 h-5 eye-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    <!-- Eye Slash Icon (Password Visible) -->
                    <svg class="w-5 h-5 eye-slash-icon hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"></path>
                    </svg>
                </button>
            </div>
            @error('password')
                <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-between text-xs">
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="remember" class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                <span class="text-slate-600">Ingat Saya</span>
            </label>
            <a href="{{ route('warga.password.request') }}" class="font-semibold text-emerald-600 hover:text-emerald-500 hover:underline">
                Lupa Kata Sandi?
            </a>
        </div>

        <button type="submit" class="w-full py-3.5 px-4 bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-sm rounded-xl shadow-md shadow-emerald-600/25 transition-all cursor-pointer">
            Masuk
        </button>

        <div class="text-center pt-2 border-t border-slate-100">
            <p class="text-xs text-slate-600">
                Belum punya akun warga? 
                <a href="{{ route('warga.register') }}" class="font-bold text-emerald-600 hover:underline">Daftar Akun Baru</a>
            </p>
        </div>
    </form>
</div>

<script>
function togglePasswordVisibility(inputId, btn) {
    const input = document.getElementById(inputId);
    if (!input) return;
    const isPassword = input.type === 'password';
    input.type = isPassword ? 'text' : 'password';
    
    const eyeIcon = btn.querySelector('.eye-icon');
    const eyeSlashIcon = btn.querySelector('.eye-slash-icon');
    if (eyeIcon && eyeSlashIcon) {
        eyeIcon.classList.toggle('hidden', isPassword);
        eyeSlashIcon.classList.toggle('hidden', !isPassword);
    }
}
</script>
@endsection
