@extends('layouts.app')

@section('title', 'Pendaftaran Akun Warga — SIPEDES')

@section('content')
<div class="min-h-[85vh] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-slate-50">
    <div class="max-w-xl w-full space-y-6 bg-white p-8 rounded-3xl border border-slate-200 shadow-sm">
        <div class="text-center space-y-2">
            <div class="w-12 h-12 rounded-2xl bg-emerald-600 text-white flex items-center justify-center font-bold text-xl mx-auto shadow-md shadow-emerald-600/20">
                S
            </div>
            <h2 class="text-2xl font-extrabold text-slate-900">Daftar Akun Warga Baru</h2>
            <p class="text-xs text-slate-500">Lengkapi data diri kependudukan Anda untuk mulai mengajukan surat online.</p>
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
                <textarea id="alamat" name="alamat" rows="2" required placeholder="Contoh: RT 02 RW 01, Dusun Krajan, Rombiyah Barat" 
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500 outline-none @error('alamat') border-rose-500 @enderror">{{ old('alamat') }}</textarea>
                @error('alamat')
                    <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="password" class="block text-xs font-semibold text-slate-700 mb-1">Kata Sandi</label>
                    <input id="password" name="password" type="password" required placeholder="Minimal 8 karakter" 
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500 outline-none @error('password') border-rose-500 @enderror">
                    @error('password')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-xs font-semibold text-slate-700 mb-1">Konfirmasi Kata Sandi</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required placeholder="Ulangi kata sandi" 
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500 outline-none">
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
@endsection
