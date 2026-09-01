@extends('layouts.app')

@section('title', 'Masuk Akun Warga — SIPEDES')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-slate-50">
    <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-3xl border border-slate-200 shadow-sm">
        <div class="text-center space-y-2">
            <div class="w-12 h-12 rounded-2xl bg-emerald-600 text-white flex items-center justify-center font-bold text-xl mx-auto shadow-md shadow-emerald-600/20">
                S
            </div>
            <h2 class="text-2xl font-extrabold text-slate-900">Masuk Akun Warga</h2>
            <p class="text-xs text-slate-500">Masukkan NIK dan kata sandi Anda untuk mengakses layanan surat.</p>
        </div>

        <form class="mt-8 space-y-5" action="{{ route('warga.login.store') }}" method="POST">
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
                <input id="password" name="password" type="password" required placeholder="••••••••" 
                    class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all @error('password') border-rose-500 @enderror">
                @error('password')
                    <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between text-xs">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="remember" class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                    <span class="text-slate-600">Ingat Saya</span>
                </label>
            </div>

            <button type="submit" class="w-full py-3.5 px-4 bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-sm rounded-xl shadow-md shadow-emerald-600/25 transition-all">
                Masuk ke Dashboard
            </button>

            <div class="text-center pt-2 border-t border-slate-100">
                <p class="text-xs text-slate-600">
                    Belum punya akun warga? 
                    <a href="{{ route('warga.register') }}" class="font-bold text-emerald-600 hover:underline">Daftar Akun Baru</a>
                </p>
            </div>
        </form>
    </div>
</div>
@endsection
