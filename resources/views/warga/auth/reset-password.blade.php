@extends('layouts.auth')

@section('title', 'Buat Kata Sandi Baru — SIPEDES Desa Rombiya Barat')

@section('content')
<div class="max-w-md w-full space-y-7 bg-white p-7 sm:p-9 rounded-3xl border border-slate-200/80 shadow-sm">
    <div class="text-center space-y-2">
        <div class="w-14 h-14 bg-emerald-100 text-emerald-600 rounded-2xl flex items-center justify-center mx-auto shadow-xs">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
            </svg>
        </div>
        <h2 class="text-2xl font-extrabold text-slate-900">Buat Kata Sandi Baru</h2>
        <p class="text-xs text-slate-500 leading-relaxed">
            Kode OTP berhasil diverifikasi untuk akun warga <strong class="text-slate-800">{{ $user->name }}</strong>. Silakan masukkan kata sandi baru Anda.
        </p>
    </div>

    <form id="resetPasswordForm" class="space-y-5" action="{{ route('warga.password.update') }}" method="POST">
        @csrf
        <input type="hidden" name="token" value="{{ $token ?? old('token') ?? session('password_reset_token') }}">
        <input type="hidden" name="nik" value="{{ $user->nik ?? old('nik') ?? session('password_reset_nik') }}">

        <div>
            <label for="password" class="block text-xs font-semibold text-slate-700 mb-1">Kata Sandi Baru</label>
            <div class="relative">
                <input id="password" name="password" type="password" required autofocus placeholder="Minimal 8 karakter" 
                    class="w-full px-4 py-3 pr-11 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all @error('password') border-rose-500 @enderror">
                <button type="button" onclick="togglePasswordVisibility('password', this)" 
                    class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-emerald-600 focus:outline-none p-1.5 rounded-lg transition-colors" 
                    title="Tampilkan / Sembunyikan Kata Sandi">
                    <svg class="w-5 h-5 eye-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    <svg class="w-5 h-5 eye-slash-icon hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"></path>
                    </svg>
                </button>
            </div>
            @error('password')
                <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password_confirmation" class="block text-xs font-semibold text-slate-700 mb-1">Ulangi Kata Sandi Baru</label>
            <div class="relative">
                <input id="password_confirmation" name="password_confirmation" type="password" required placeholder="Ketik ulang kata sandi baru" 
                    class="w-full px-4 py-3 pr-11 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all @error('password') border-rose-500 @enderror">
                <button type="button" onclick="togglePasswordVisibility('password_confirmation', this)" 
                    class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-emerald-600 focus:outline-none p-1.5 rounded-lg transition-colors" 
                    title="Tampilkan / Sembunyikan Kata Sandi">
                    <svg class="w-5 h-5 eye-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    <svg class="w-5 h-5 eye-slash-icon hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"></path>
                    </svg>
                </button>
            </div>
            <p id="clientConfirmError" class="mt-1 text-xs text-rose-600 font-medium hidden">Konfirmasi kata sandi tidak cocok. Pastikan kedua kolom terisi sama persis.</p>
        </div>

        <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/70 text-xs text-slate-600 space-y-1">
            <p class="font-semibold text-slate-700">Persyaratan Kata Sandi:</p>
            <ul class="list-disc list-inside space-y-0.5 text-slate-500 text-[11px]">
                <li>Minimal 8 karakter</li>
                <li>Disarankan kombinasi huruf dan angka</li>
            </ul>
        </div>

        <button id="btnSubmitReset" type="submit" class="w-full py-3.5 px-4 bg-emerald-600 hover:bg-emerald-500 disabled:opacity-75 disabled:cursor-not-allowed text-white font-bold text-sm rounded-xl shadow-md shadow-emerald-600/25 transition-all flex items-center justify-center gap-2 cursor-pointer">
            <svg id="btnSubmitIcon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            <svg id="btnSubmitSpinner" class="w-4 h-4 animate-spin hidden" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
            </svg>
            <span id="btnSubmitText">Simpan Kata Sandi Baru</span>
        </button>

        <div class="text-center pt-2 border-t border-slate-100">
            <p class="text-xs text-slate-600">
                Batal ubah kata sandi? 
                <a href="{{ route('warga.login') }}" class="font-bold text-emerald-600 hover:underline">Kembali ke Halaman Masuk</a>
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

    const form = document.getElementById('resetPasswordForm');
    const pwd = document.getElementById('password');
    const pwdConfirm = document.getElementById('password_confirmation');
    const confirmErr = document.getElementById('clientConfirmError');
    const btn = document.getElementById('btnSubmitReset');
    const icon = document.getElementById('btnSubmitIcon');
    const spinner = document.getElementById('btnSubmitSpinner');
    const text = document.getElementById('btnSubmitText');

    if (pwdConfirm) {
        pwdConfirm.addEventListener('input', function () {
            if (confirmErr) confirmErr.classList.add('hidden');
            pwdConfirm.classList.remove('border-rose-500');
        });
    }

    if (form) {
        form.addEventListener('submit', function (e) {
            if (pwd && pwdConfirm && pwd.value !== pwdConfirm.value) {
                e.preventDefault();
                if (confirmErr) confirmErr.classList.remove('hidden');
                pwdConfirm.classList.add('border-rose-500');
                pwdConfirm.focus();
                return;
            }

            if (btn) {
                btn.style.pointerEvents = 'none';
                if (icon) icon.classList.add('hidden');
                if (spinner) spinner.classList.remove('hidden');
                if (text) text.textContent = 'Menyimpan Kata Sandi...';
                setTimeout(() => {
                    btn.disabled = true;
                }, 50);
            }
        });
    }
</script>
@endsection
