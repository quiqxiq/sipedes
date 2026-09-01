<?php

namespace App\Livewire\Warga;

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
    public array $files = [];

    public function mount()
    {
        if (request()->has('jenis')) {
            $this->jenis_surat_id = (int) request('jenis');
        }
    }

    public function selectJenisSurat(int $id)
    {
        $this->jenis_surat_id = $id;
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
        $this->validate([
            'catatan_pemohon' => 'nullable|string|max:1000',
            'files.*' => 'required|file|mimes:pdf,jpg,jpeg,png|max:3072',
        ], [
            'files.*.mimes' => 'Format file lampiran harus berupa PDF, JPG, JPEG, atau PNG.',
            'files.*.max' => 'Ukuran file per berkas maksimal 3 MB.',
        ]);
    }

    public function submit()
    {
        if (!$this->jenis_surat_id) {
            return;
        }

        $jenisSurat = JenisSurat::findOrFail($this->jenis_surat_id);
        $user = Auth::user();

        // Generate Nomor Permohonan: SURAT/YYYYMMDD/RANDOM
        $nomorPermohonan = 'SRT/' . date('Ymd') . '/' . strtoupper(substr(uniqid(), -5));

        $permohonan = PermohonanSurat::create([
            'nomor_permohonan' => $nomorPermohonan,
            'user_id' => $user->id,
            'jenis_surat_id' => $jenisSurat->id,
            'status' => 'diajukan',
            'catatan_petugas' => $this->catatan_pemohon ? 'Catatan Pemohon: ' . $this->catatan_pemohon : null,
        ]);

        // Save uploaded files
        if (!empty($this->files)) {
            foreach ($this->files as $file) {
                $originalName = $file->getClientOriginalName();
                $path = $file->store('dokumen_persyaratan/' . date('Y/m'), 'public');

                DokumenPersyaratan::create([
                    'permohonan_id' => $permohonan->id,
                    'nama_file' => $originalName,
                    'path' => $path,
                ]);
            }
        }

        // Send Notification
        Notifikasi::create([
            'user_id' => $user->id,
            'permohonan_id' => $permohonan->id,
            'pesan' => "Permohonan {$jenisSurat->nama} ({$nomorPermohonan}) berhasil dibuat dan sedang menunggu verifikasi petugas.",
        ]);

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
        ])->layout('layouts.app');
    }
}
