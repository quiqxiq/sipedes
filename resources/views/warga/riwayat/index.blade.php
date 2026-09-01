@extends('layouts.app')

@section('title', 'Riwayat Permohonan Surat — SIPEDES')

@section('content')
<div class="py-10 bg-slate-50 min-h-[85vh]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-extrabold text-slate-900">Riwayat Permohonan Surat</h1>
                <p class="text-xs text-slate-500">Pantau status verifikasi dan unduh berkas surat resmi Anda.</p>
            </div>

            <a href="{{ route('warga.pengajuan.wizard') }}" class="px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs shadow-sm transition-all flex items-center gap-1.5">
                <span>✍️</span> Permohonan Surat Baru
            </a>
        </div>

        <div class="bg-white rounded-3xl border border-slate-200 shadow-xs overflow-hidden">
            @if($permohonanList->isEmpty())
                <div class="p-16 text-center space-y-3">
                    <div class="w-12 h-12 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto text-2xl">
                        📭
                    </div>
                    <h3 class="font-bold text-slate-800 text-sm">Belum Ada Pengajuan Surat</h3>
                    <p class="text-xs text-slate-500 max-w-sm mx-auto">Anda belum memiliki riwayat pengajuan surat online. Silakan klik tombol di bawah ini untuk mengajukan surat.</p>
                    <a href="{{ route('warga.pengajuan.wizard') }}" class="inline-flex items-center gap-1.5 px-4 py-2 text-xs font-bold text-white bg-emerald-600 rounded-xl hover:bg-emerald-500 transition-all">
                        Buat Permohonan Baru
                    </a>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-50 text-slate-600 font-semibold border-b border-slate-200">
                            <tr>
                                <th class="p-4">No. Permohonan</th>
                                <th class="p-4">Jenis Surat</th>
                                <th class="p-4">Tanggal Pengajuan</th>
                                <th class="p-4">Status Verifikasi</th>
                                <th class="p-4 text-right">Aksi & Dokumen</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($permohonanList as $item)
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="p-4 font-mono font-bold text-slate-800">{{ $item->nomor_permohonan }}</td>
                                    <td class="p-4">
                                        <div class="font-semibold text-slate-900">{{ $item->jenisSurat->nama ?? '-' }}</div>
                                        <div class="text-[11px] text-slate-400">Kode: {{ $item->jenisSurat->kode ?? '-' }}</div>
                                    </td>
                                    <td class="p-4 text-slate-500">{{ $item->created_at->format('d M Y, H:i') }} WIB</td>
                                    <td class="p-4">
                                        @if($item->status == 'diajukan')
                                            <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-amber-100 text-amber-800">Menunggu Verifikasi</span>
                                        @elseif($item->status == 'diproses')
                                            <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-sky-100 text-sky-800">Sedang Diproses</span>
                                        @elseif($item->status == 'disetujui')
                                            <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-800">Disetujui</span>
                                        @elseif($item->status == 'butuh_koreksi')
                                            <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-orange-100 text-orange-800">Perlu Koreksi</span>
                                        @else
                                            <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-rose-100 text-rose-800">Ditolak</span>
                                        @endif
                                    </td>
                                    <td class="p-4 text-right space-x-2">
                                        <a href="{{ route('warga.riwayat.show', $item->id) }}" class="px-3 py-1.5 rounded-lg text-xs font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 transition-colors">
                                            Detail
                                        </a>

                                        @if($item->status == 'disetujui')
                                            <a href="{{ route('warga.surat.pdf', $item->id) }}" target="_blank" class="px-3 py-1.5 rounded-lg text-xs font-semibold text-white bg-emerald-600 hover:bg-emerald-500 shadow-xs transition-colors">
                                                📥 Unduh PDF
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="p-4 border-t border-slate-100">
                    {{ $permohonanList->links() }}
                </div>
            @endif
        </div>

    </div>
</div>
@endsection
