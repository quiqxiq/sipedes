@extends('layouts.app')

@section('title', 'Pendaftaran Akun Warga — SIPEDES Desa Rombiya Barat')

@section('content')
<div class="min-h-[85vh] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-slate-50">
    <div class="max-w-xl w-full space-y-6 bg-white p-8 rounded-3xl border border-slate-200 shadow-sm">
        <div class="text-center space-y-2">
            <img src="{{ asset('images/logo.png') }}" alt="Logo Desa Rombiya Barat" class="w-16 h-16 object-contain mx-auto">
            <h2 class="text-2xl font-extrabold text-slate-900">Daftar Akun Warga Baru</h2>
            <p class="text-xs text-slate-500">SIPEDES Desa Rombiya Barat — Lengkapi data diri kependudukan Anda untuk mulai mengajukan surat online.</p>
        </div>

        <form class="space-y-4" action="{{ route('warga.register.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="name" class="block text-xs font-semibold text-slate-700 mb-1">Nama Lengkap (Sesuai KTP)</label>
                    <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus placeholder="Contoh: Budi Santoso" 
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500 outline-none @error('name') border-rose-500 @enderror">
                    @error('name')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="nik" class="block text-xs font-semibold text-slate-700 mb-1">NIK (16 Digit)</label>
                    <input id="nik" name="nik" type="text" inputmode="numeric" pattern="[0-9]{16}" maxlength="16" 
                        value="{{ old('nik') }}" required placeholder="350501xxxxxxxxxx" 
                        oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 16);"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500 outline-none @error('nik') border-rose-500 @enderror">
                    @error('nik')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="email" class="block text-xs font-semibold text-slate-700 mb-1">Alamat Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required placeholder="email@domain.com" 
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500 outline-none @error('email') border-rose-500 @enderror">
                    @error('email')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="telepon" class="block text-xs font-semibold text-slate-700 mb-1">Nomor WhatsApp / HP</label>
                    <input id="telepon" name="telepon" type="text" value="{{ old('telepon') }}" required placeholder="08xxxxxxxxxx" 
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500 outline-none @error('telepon') border-rose-500 @enderror">
                    @error('telepon')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label for="alamat" class="block text-xs font-semibold text-slate-700 mb-1">Alamat Lengkap Domisili (RT/RW)</label>
                <textarea id="alamat" name="alamat" rows="2" required placeholder="Contoh: RT 02 RW 01, Dusun Rombiya, Rombiya Barat" 
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500 outline-none @error('alamat') border-rose-500 @enderror">{{ old('alamat') }}</textarea>
                @error('alamat')
                    <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="password" class="block text-xs font-semibold text-slate-700 mb-1">Kata Sandi</label>
                    <div class="relative">
                        <input id="password" name="password" type="password" required placeholder="Minimal 8 karakter" 
                            class="w-full px-4 py-2.5 pr-10 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500 outline-none @error('password') border-rose-500 @enderror">
                        <button type="button" onclick="togglePasswordVisibility('password', this)" 
                            class="absolute right-2.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-emerald-600 focus:outline-none p-1 rounded-lg transition-colors"
                            title="Tampilkan / Sembunyikan Kata Sandi">
                            <svg class="w-4 h-4 eye-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            <svg class="w-4 h-4 eye-slash-icon hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"></path>
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-xs font-semibold text-slate-700 mb-1">Konfirmasi Kata Sandi</label>
                    <div class="relative">
                        <input id="password_confirmation" name="password_confirmation" type="password" required placeholder="Ulangi kata sandi" 
                            class="w-full px-4 py-2.5 pr-10 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500 outline-none">
                        <button type="button" onclick="togglePasswordVisibility('password_confirmation', this)" 
                            class="absolute right-2.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-emerald-600 focus:outline-none p-1 rounded-lg transition-colors"
                            title="Tampilkan / Sembunyikan Kata Sandi">
                            <svg class="w-4 h-4 eye-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            <svg class="w-4 h-4 eye-slash-icon hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <button type="submit" class="w-full py-3.5 px-4 bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs rounded-xl shadow-md shadow-emerald-600/25 transition-all mt-4">
                Daftar & Buat Akun Warga
            </button>

            <div class="text-center pt-2">
                <p class="text-xs text-slate-600">
                    Sudah mendaftar sebelumnya? 
                    <a href="{{ route('warga.login') }}" class="font-bold text-emerald-600 hover:underline">Masuk Disini</a>
                </p>
            </div>
        </form>
    </div>
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
