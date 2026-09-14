@extends('layouts.auth')

@section('title', 'Verifikasi Kode OTP — SIPEDES Desa Rombiya Barat')

@section('content')
<div class="max-w-md w-full space-y-7 bg-white p-7 sm:p-9 rounded-3xl border border-slate-200/80 shadow-sm">
    <div class="text-center space-y-2">
        <div class="w-14 h-14 bg-emerald-100 text-emerald-600 rounded-2xl flex items-center justify-center mx-auto shadow-xs">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
            </svg>
        </div>
        <h2 class="text-2xl font-extrabold text-slate-900">Verifikasi Kode OTP</h2>
        <p class="text-xs text-slate-500 leading-relaxed">
            Masukkan 6 digit kode verifikasi yang telah kami kirimkan ke nomor WhatsApp terdaftar milik Anda:
        </p>
    </div>

    <!-- Phone Number Pill -->
    <div class="py-2.5 px-4 rounded-xl bg-slate-50 border border-slate-200/80 flex items-center justify-between">
        <div class="flex items-center gap-2.5">
            <div class="w-7 h-7 rounded-lg bg-emerald-500 text-white flex items-center justify-center">
                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M17.472 14.382c-.301-.15-1.78-.878-2.056-.978-.276-.1-.477-.15-.678.15-.201.3-.777.978-.953 1.179-.176.2-.351.226-.652.075-.301-.15-1.272-.469-2.423-1.495-.896-.799-1.501-1.787-1.677-2.088-.176-.3-.019-.462.132-.612.136-.135.301-.351.452-.527.15-.175.2-.3.301-.5.1-.2.05-.376-.025-.526-.075-.15-.678-1.631-.929-2.233-.244-.585-.493-.506-.678-.515-.176-.008-.376-.01-.577-.01s-.527.075-.803.376c-.276.3-1.054 1.03-1.054 2.511s1.079 2.911 1.23 3.112c.15.2 2.124 3.244 5.146 4.549.719.31 1.28.496 1.718.636.722.23 1.378.197 1.898.12.58-.087 1.78-.728 2.03-1.431.251-.703.251-1.305.176-1.431-.075-.126-.276-.201-.577-.351z"/>
                    <path d="M12 2C6.477 2 2 6.477 2 12c0 1.89.525 3.66 1.438 5.168L2 22l4.982-1.399A9.957 9.957 0 0012 22c5.523 0 10-4.477 10-10S17.523 2 12 2zm0 18.182a8.136 8.136 0 01-4.321-1.234l-.31-.184-2.957.83.844-2.885-.202-.322A8.136 8.136 0 013.818 12c0-4.512 3.67-8.182 8.182-8.182 4.512 0 8.182 3.67 8.182 8.182 0 4.512-3.67 8.182-8.182 8.182z"/>
                </svg>
            </div>
            <div>
                <p class="text-[11px] text-slate-500 font-medium">{{ $user->name ?? 'Warga' }}</p>
                <p class="text-xs font-bold text-slate-800 font-mono tracking-wider">{{ $maskedPhone }}</p>
            </div>
        </div>
        <a href="{{ route('warga.password.request') }}" class="text-[11px] font-semibold text-emerald-600 hover:text-emerald-700 hover:underline">
            Ubah NIK
        </a>
    </div>

    <!-- OTP Form -->
    <form class="space-y-6" action="{{ route('warga.password.verify_otp') }}" method="POST" id="otpForm">
        @csrf

        <!-- Hidden input for submitting complete 6-digit OTP -->
        <input type="hidden" name="otp" id="realOtpInput" value="{{ old('otp') }}">

        <div>
            <label class="block text-xs font-semibold text-slate-700 mb-3 text-center">Masukkan 6 Digit Angka</label>
            
            <div class="flex justify-center gap-2 sm:gap-2.5" id="otpBoxes">
                @for ($i = 0; $i < 6; $i++)
                    <input type="text" inputmode="numeric" pattern="[0-9]" maxlength="1" 
                        class="otp-digit w-11 h-13 sm:w-12 sm:h-14 text-center text-xl font-bold font-mono rounded-xl border border-slate-300 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/30 outline-none transition-all bg-slate-50/50 focus:bg-white @error('otp') border-rose-500 bg-rose-50/30 @enderror"
                        data-index="{{ $i }}" autocomplete="one-time-code">
                @endfor
            </div>

            @error('otp')
                <p class="mt-2 text-xs text-rose-600 text-center font-medium">{{ $message }}</p>
            @enderror
            <p class="mt-2 text-[11px] text-slate-400 text-center">Kode OTP berlaku selama 10 menit.</p>
        </div>

        <button type="submit" id="btnSubmitOtp" class="w-full py-3.5 px-4 bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-sm rounded-xl shadow-md shadow-emerald-600/25 transition-all flex items-center justify-center gap-2 cursor-pointer">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span>Verifikasi Kode OTP</span>
        </button>
    </form>

    <!-- Resend OTP Section -->
    <div class="pt-3 border-t border-slate-100 text-center">
        <form action="{{ route('warga.password.resend') }}" method="POST" id="resendForm" class="inline">
            @csrf
            <p class="text-xs text-slate-600">
                Tidak menerima kode verifikasi di WhatsApp? 
                <button type="submit" id="btnResend" 
                    @if($cooldownSeconds > 0) disabled @endif
                    class="font-bold text-emerald-600 hover:underline disabled:opacity-50 disabled:no-underline disabled:cursor-not-allowed">
                    Kirim Ulang <span id="cooldownTimer">@if($cooldownSeconds > 0)({{ $cooldownSeconds }}d)@endif</span>
                </button>
            </p>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const digits = document.querySelectorAll('.otp-digit');
    const realInput = document.getElementById('realOtpInput');
    const form = document.getElementById('otpForm');

    // Sync old input if exists
    if (realInput.value && realInput.value.length === 6) {
        for (let i = 0; i < 6; i++) {
            digits[i].value = realInput.value[i];
        }
    } else {
        digits[0]?.focus();
    }

    function updateRealInput() {
        let code = '';
        digits.forEach(d => code += d.value);
        realInput.value = code;
        return code;
    }

    digits.forEach((digit, idx) => {
        digit.addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
            if (this.value.length === 1 && idx < digits.length - 1) {
                digits[idx + 1].focus();
            }
            updateRealInput();
        });

        digit.addEventListener('keydown', function(e) {
            if (e.key === 'Backspace' && !this.value && idx > 0) {
                digits[idx - 1].focus();
                digits[idx - 1].value = '';
                updateRealInput();
            }
        });

        digit.addEventListener('paste', function(e) {
            e.preventDefault();
            const pasted = (e.clipboardData || window.clipboardData).getData('text');
            const cleanDigits = pasted.replace(/[^0-9]/g, '').slice(0, 6);
            if (!cleanDigits) return;

            for (let i = 0; i < digits.length; i++) {
                digits[i].value = cleanDigits[i] || '';
            }
            updateRealInput();
            const nextIdx = Math.min(cleanDigits.length, digits.length - 1);
            digits[nextIdx].focus();
        });
    });

    form.addEventListener('submit', function(e) {
        const code = updateRealInput();
        if (code.length < 6) {
            e.preventDefault();
            alert('Mohon lengkapi 6 digit kode OTP verifikasi.');
            digits[code.length < digits.length ? code.length : 0].focus();
        }
    });

    // Cooldown Timer
    let cooldown = parseInt("{{ $cooldownSeconds }}", 10) || 0;
    const btnResend = document.getElementById('btnResend');
    const timerSpan = document.getElementById('cooldownTimer');

    if (cooldown > 0 && btnResend && timerSpan) {
        btnResend.disabled = true;
        const interval = setInterval(function() {
            cooldown--;
            if (cooldown > 0) {
                timerSpan.textContent = `(${cooldown}d)`;
            } else {
                clearInterval(interval);
                timerSpan.textContent = '';
                btnResend.disabled = false;
            }
        }, 1000);
    }
});
</script>
@endsection
