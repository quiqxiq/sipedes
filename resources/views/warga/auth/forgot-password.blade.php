@extends('layouts.auth')

@section('title', 'Lupa Kata Sandi — SIPEDES Desa Rombiya Barat')

@section('content')
<div class="max-w-md w-full space-y-7 bg-white p-7 sm:p-9 rounded-3xl border border-slate-200/80 shadow-sm">
    <div class="text-center space-y-2">
        <img src="{{ asset('images/logo.png') }}" alt="Logo Desa Rombiya Barat" class="w-16 h-16 object-contain mx-auto">
        <h2 class="text-2xl font-extrabold text-slate-900">Lupa Kata Sandi</h2>
        <p class="text-xs text-slate-500 leading-relaxed">
            SIPEDES Desa Rombiya Barat — Masukkan NIK Anda. Kode OTP verifikasi akan dikirimkan secara otomatis ke nomor WhatsApp yang terdaftar.
        </p>
    </div>

    <!-- Info Banner WhatsApp -->
    <div class="p-3.5 rounded-2xl bg-emerald-50/70 border border-emerald-100 flex items-start gap-3">
        <div class="w-8 h-8 rounded-xl bg-emerald-600 text-white flex items-center justify-center shrink-0 shadow-xs">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                <path d="M17.472 14.382c-.301-.15-1.78-.878-2.056-.978-.276-.1-.477-.15-.678.15-.201.3-.777.978-.953 1.179-.176.2-.351.226-.652.075-.301-.15-1.272-.469-2.423-1.495-.896-.799-1.501-1.787-1.677-2.088-.176-.3-.019-.462.132-.612.136-.135.301-.351.452-.527.15-.175.2-.3.301-.5.1-.2.05-.376-.025-.526-.075-.15-.678-1.631-.929-2.233-.244-.585-.493-.506-.678-.515-.176-.008-.376-.01-.577-.01s-.527.075-.803.376c-.276.3-1.054 1.03-1.054 2.511s1.079 2.911 1.23 3.112c.15.2 2.124 3.244 5.146 4.549.719.31 1.28.496 1.718.636.722.23 1.378.197 1.898.12.58-.087 1.78-.728 2.03-1.431.251-.703.251-1.305.176-1.431-.075-.126-.276-.201-.577-.351z"/>
                <path d="M12 2C6.477 2 2 6.477 2 12c0 1.89.525 3.66 1.438 5.168L2 22l4.982-1.399A9.957 9.957 0 0012 22c5.523 0 10-4.477 10-10S17.523 2 12 2zm0 18.182a8.136 8.136 0 01-4.321-1.234l-.31-.184-2.957.83.844-2.885-.202-.322A8.136 8.136 0 013.818 12c0-4.512 3.67-8.182 8.182-8.182 4.512 0 8.182 3.67 8.182 8.182 0 4.512-3.67 8.182-8.182 8.182z"/>
            </svg>
        </div>
        <p class="text-[11px] text-emerald-800 leading-relaxed">
            Pastikan nomor WhatsApp Anda aktif. Kode verifikasi OTP 6 digit akan dikirimkan langsung dari nomor resmi pelayanan Balai Desa Rombiya Barat.
        </p>
    </div>

    <form class="space-y-5" action="{{ route('warga.password.send_otp') }}" method="POST">
        @csrf

        <div>
            <label for="nik" class="block text-xs font-semibold text-slate-700 mb-1">Nomor Induk Kependudukan (NIK)</label>
            <input id="nik" name="nik" type="text" inputmode="numeric" pattern="[0-9]{16}" maxlength="16" 
                value="{{ old('nik') }}" required autofocus placeholder="Masukkan 16 digit NIK Anda" 
                oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 16);"
                class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all @error('nik') border-rose-500 @enderror">
            @error('nik')
                <p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="w-full py-3.5 px-4 bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-sm rounded-xl shadow-md shadow-emerald-600/25 transition-all flex items-center justify-center gap-2 cursor-pointer">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
            </svg>
            <span>Kirim Kode OTP WhatsApp</span>
        </button>

        <div class="text-center pt-2 border-t border-slate-100">
            <p class="text-xs text-slate-600">
                Ingat kata sandi Anda? 
                <a href="{{ route('warga.login') }}" class="font-bold text-emerald-600 hover:underline">Kembali ke Halaman Masuk</a>
            </p>
        </div>
    </form>
</div>
@endsection
