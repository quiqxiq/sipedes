<?php

namespace App\Livewire\Warga;

use App\Jobs\SendWhatsAppNotificationJob;
use App\Models\DokumenPersyaratan;
use App\Models\JenisSurat;
use App\Models\Notifikasi;
use App\Models\PermohonanSurat;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class PengajuanSuratWizard extends Component
{
    use WithFileUploads;

    public int $currentStep = 1;

    // Step 1
    public ?int $jenis_surat_id = null;

    // Step 2
    public string $catatan_pemohon = '';
    public array $dokumenFiles = [];

    public function mount()
    {
        if (request()->has('jenis')) {
            $this->jenis_surat_id = (int) request('jenis');
        }
    }

    public function selectJenisSurat(int $id)
    {
        $this->jenis_surat_id = $id;
        $this->dokumenFiles = [];
        $this->currentStep = 2;
    }

    public function goToStep(int $step)
    {
        if ($step == 2 && !$this->jenis_surat_id) {
            session()->flash('error', 'Silakan pilih jenis surat terlebih dahulu.');
            return;
        }

        if ($step == 3) {
            $this->validateStep2();
        }

        $this->currentStep = $step;
    }

    public function validateStep2()
    {
        $rules = [
            'catatan_pemohon' => 'nullable|string|max:1000',
        ];
        $messages = [];

        $jenisSurat = JenisSurat::find($this->jenis_surat_id);
        $syaratList = $jenisSurat?->persyaratan_list ?? [];

        foreach ($syaratList as $idx => $syarat) {
            $key = "dokumenFiles.{$idx}";
            $label = $syarat['nama'] ?? ('Berkas ' . ($idx + 1));

            if (!empty($syarat['wajib'])) {
                $rules[$key] = 'required|file|mimes:pdf,jpg,jpeg,png|max:3072';
                $messages["{$key}.required"] = "Berkas '{$label}' wajib diunggah.";
            } else {
                $rules[$key] = 'nullable|file|mimes:pdf,jpg,jpeg,png|max:3072';
            }

            $messages["{$key}.mimes"] = "Berkas '{$label}' harus berupa file PDF, JPG, JPEG, atau PNG.";
            $messages["{$key}.max"] = "Ukuran berkas '{$label}' tidak boleh melebihi 3 MB.";
        }

        $this->validate($rules, $messages);
    }

    public function submit()
    {
        if (!$this->jenis_surat_id) {
            return;
        }

        $this->validateStep2();

        $jenisSurat = JenisSurat::findOrFail($this->jenis_surat_id);
        $user = Auth::user();

        // Generate Nomor Permohonan: SRT/YYYYMMDD/RANDOM
        $nomorPermohonan = 'SRT/' . date('Ymd') . '/' . strtoupper(substr(uniqid(), -5));

        $permohonan = PermohonanSurat::create([
            'nomor_permohonan' => $nomorPermohonan,
            'user_id' => $user->id,
            'jenis_surat_id' => $jenisSurat->id,
            'status' => 'diajukan',
            'catatan_petugas' => $this->catatan_pemohon ? 'Catatan Pemohon: ' . $this->catatan_pemohon : null,
        ]);

        // Save uploaded files based on specific requirements
        $syaratList = $jenisSurat->persyaratan_list;
        if (!empty($this->dokumenFiles)) {
            foreach ($this->dokumenFiles as $idx => $file) {
                if ($file && is_object($file)) {
                    $tipeDokumen = $syaratList[$idx]['nama'] ?? ('Berkas Persyaratan ' . ($idx + 1));
                    $originalName = $file->getClientOriginalName();
                    $path = $file->store('dokumen_persyaratan/' . date('Y/m'), 'public');
                    $fileSize = method_exists($file, 'getSize') ? $file->getSize() : null;

                    DokumenPersyaratan::create([
                        'permohonan_id' => $permohonan->id,
                        'nama_file' => $originalName,
                        'path' => $path,
                        'tipe_dokumen' => $tipeDokumen,
                        'ukuran_file' => $fileSize,
                    ]);
                }
            }
        }

        // Send In-App Notification
        Notifikasi::create([
            'user_id' => $user->id,
            'permohonan_id' => $permohonan->id,
            'judul' => 'Permohonan Surat Diajukan',
            'pesan' => "Permohonan {$jenisSurat->nama} ({$nomorPermohonan}) berhasil dibuat dan sedang menunggu verifikasi petugas.",
        ]);

        // 1. WhatsApp ke Warga Pemohon
        if (!empty($user->telepon)) {
            SendWhatsAppNotificationJob::dispatch(
                'surat_diajukan_warga',
                $user->telepon,
                [
                    'nama_pemohon' => $user->name,
                    'jenis_surat' => $jenisSurat->nama,
                    'nomor_permohonan' => $nomorPermohonan,
                    'link_status' => route('warga.riwayat.show', $permohonan->id),
                ],
                $user->name,
                $permohonan->id
            );
        }

        // 2. WhatsApp Alert ke Pamong / Petugas Balai Desa
        $petugasPhone = config('whatsapp.petugas_phone');
        if (!empty($petugasPhone)) {
            SendWhatsAppNotificationJob::dispatch(
                'surat_masuk_petugas',
                $petugasPhone,
                [
                    'jenis_surat' => $jenisSurat->nama,
                    'nomor_permohonan' => $nomorPermohonan,
                    'nama_pemohon' => $user->name,
                    'dusun' => $user->alamat ?? 'Desa Rombiya Barat',
                    'tanggal_pengajuan' => now()->translatedFormat('d M Y H:i') . ' WIB',
                    'link_admin' => url('/admin/permohonan-surats/' . $permohonan->id),
                ],
                'Petugas Pelayanan Desa',
                $permohonan->id
            );
        }

        session()->flash('success', "Permohonan {$jenisSurat->nama} berhasil diajukan dengan Nomor: {$nomorPermohonan}");

        return redirect()->route('warga.riwayat.show', $permohonan->id);
    }

    public function render()
    {
        $jenisSuratList = JenisSurat::where('is_active', true)->get();
        $selectedJenisSurat = $this->jenis_surat_id ? JenisSurat::find($this->jenis_surat_id) : null;

        return view('livewire.warga.pengajuan-surat.wizard', [
            'jenisSuratList' => $jenisSuratList,
            'selectedJenisSurat' => $selectedJenisSurat,
            'currentStep' => $this->currentStep,
            'dokumenFiles' => $this->dokumenFiles,
            'catatan_pemohon' => $this->catatan_pemohon,
        ])->layout('layouts.app');
    }
}
