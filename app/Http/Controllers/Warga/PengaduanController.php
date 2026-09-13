<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Jobs\SendWhatsAppNotificationJob;
use App\Models\AktivitasLog;
use App\Models\Pengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PengaduanController extends Controller
{
    public function index()
    {
        $pengaduan = Pengaduan::where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('warga.pengaduan.index', compact('pengaduan'));
    }

    public function create()
    {
        $dusunList = [
            'Dusun Kebunan',
            'Dusun Buwa',
            'Dusun Tanodung',
            'Dusun Rombiya',
            'Dusun Kalampok',
        ];

        return view('warga.pengaduan.create', compact('dusunList'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'dusun' => ['required', 'string'],
            'kategori' => ['required', 'string'],
            'judul' => ['required', 'string', 'max:255'],
            'deskripsi' => ['required', 'string', 'max:2000'],
            'lokasi_detail' => ['nullable', 'string', 'max:255'],
            'foto_lampiran' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:3072'],
        ], [
            'dusun.required' => 'Pilih dusun lokasi kejadian.',
            'kategori.required' => 'Pilih kategori pengaduan.',
            'judul.required' => 'Judul pengaduan wajib diisi.',
            'deskripsi.required' => 'Isi laporan pengaduan wajib diisi.',
            'foto_lampiran.image' => 'File lampiran harus berupa gambar (JPG/PNG).',
            'foto_lampiran.max' => 'Ukuran foto maksimal 3MB.',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto_lampiran')) {
            $fotoPath = $request->file('foto_lampiran')->store('pengaduan', 'public');
        }

        // Generate nomor tiket
        $countToday = Pengaduan::whereDate('created_at', today())->count() + 1;
        $kodeTiket = 'LAPOR-' . date('Ymd') . '-' . str_pad($countToday, 4, '0', STR_PAD_LEFT);

        $pengaduan = Pengaduan::create([
            'user_id' => Auth::id(),
            'kode_tiket' => $kodeTiket,
            'dusun' => $validated['dusun'],
            'kategori' => $validated['kategori'],
            'judul' => $validated['judul'],
            'deskripsi' => $validated['deskripsi'],
            'lokasi_detail' => $validated['lokasi_detail'] ?? null,
            'foto_lampiran' => $fotoPath,
            'status' => 'menunggu',
        ]);

        AktivitasLog::catat(
            Auth::id(),
            'pengaduan',
            'kirim_pengaduan',
            "Warga " . Auth::user()->name . " mengirimkan laporan pengaduan {$kodeTiket} di {$validated['dusun']}"
        );

        // 1. WhatsApp Alert ke Pamong / Petugas Balai Desa
        $petugasPhone = config('whatsapp.petugas_phone');
        if (!empty($petugasPhone)) {
            SendWhatsAppNotificationJob::dispatch(
                'pengaduan_masuk_petugas',
                $petugasPhone,
                [
                    'kode_tiket' => $kodeTiket,
                    'nama_pelapor' => Auth::user()->name,
                    'dusun' => $validated['dusun'],
                    'kategori' => $validated['kategori'],
                    'judul_pengaduan' => $validated['judul'],
                    'link_admin' => url('/admin/pengaduans/' . $pengaduan->id . '/edit'),
                ],
                'Petugas Pelayanan Desa',
                $pengaduan->id
            );
        }

        // 2. WhatsApp Tanda Terima ke Warga Pelapor
        if (!empty(Auth::user()->telepon)) {
            SendWhatsAppNotificationJob::dispatch(
                'pengaduan_dibuat_warga',
                Auth::user()->telepon,
                [
                    'nama_pelapor' => Auth::user()->name,
                    'kode_tiket' => $kodeTiket,
                    'judul_pengaduan' => $validated['judul'],
                    'kategori' => $validated['kategori'],
                    'tanggal_laporan' => now()->translatedFormat('d M Y H:i') . ' WIB',
                ],
                Auth::user()->name,
                $pengaduan->id
            );
        }

        return redirect()->route('warga.pengaduan.show', $pengaduan->id)
            ->with('success', "Laporan pengaduan berhasil dikirim! Nomor tiket Anda: {$kodeTiket}");
    }

    public function show($id)
    {
        $pengaduan = Pengaduan::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        return view('warga.pengaduan.show', compact('pengaduan'));
    }
}
