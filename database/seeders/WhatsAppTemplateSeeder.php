<?php

namespace Database\Seeders;

use App\Models\WhatsAppTemplate;
use Illuminate\Database\Seeder;

class WhatsAppTemplateSeeder extends Seeder
{
    public function run(): void
    {
        $templates = [
            // 1. Permohonan Baru Masuk -> Petugas
            [
                'kode' => 'surat_masuk_petugas',
                'nama' => 'Notifikasi Pengajuan Surat Baru (ke Petugas/Pamong)',
                'kategori' => 'surat',
                'target' => 'petugas',
                'konten' => "🔔 *NOTIFIKASI SURAT BARU — SIPEDES DESA ROMBIYA BARAT*\n\nYth. Petugas / Pamong Desa,\nTerdapat permohonan surat baru yang masuk dan membutuhkan verifikasi:\n\n📄 *Jenis Surat:* {jenis_surat}\n🔢 *Nomor:* {nomor_permohonan}\n👤 *Pemohon:* {nama_pemohon}\n📍 *Dusun:* {dusun}\n🕒 *Waktu Pengajuan:* {tanggal_pengajuan}\n\nSilakan buka panel dashboard SIPEDES untuk memverifikasi berkas persyaratan:\n🔗 {link_admin}\n\n_Pemerintah Desa Rombiya Barat, Kec. Ganding, Kab. Sumenep_",
                'variabel_tersedia' => ['jenis_surat', 'nomor_permohonan', 'nama_pemohon', 'dusun', 'tanggal_pengajuan', 'link_admin'],
            ],

            // 2. Permohonan Baru Dibuat -> Warga Pemohon
            [
                'kode' => 'surat_diajukan_warga',
                'nama' => 'Konfirmasi Pengajuan Surat Diterima (ke Warga)',
                'kategori' => 'surat',
                'target' => 'warga',
                'konten' => "Salam Bapak/Ibu *{nama_pemohon}*,\n\nTerima kasih telah menggunakan layanan digital *SIPEDES Desa Rombiya Barat*.\nPermohonan surat Anda telah berhasil kami terima:\n\n📄 *Jenis Surat:* {jenis_surat}\n🔢 *No. Tiket Permohonan:* {nomor_permohonan}\n🕒 *Status Saat Ini:* Menunggu Verifikasi Petugas\n\nPamong desa kami akan segera memeriksa kelengkapan berkas Anda. Pantau perkembangan surat Anda melalui tautan berikut:\n🔗 {link_status}\n\n_Pemerintah Desa Rombiya Barat, Kec. Ganding, Kab. Sumenep_",
                'variabel_tersedia' => ['nama_pemohon', 'jenis_surat', 'nomor_permohonan', 'link_status'],
            ],

            // 3. Surat Sedang Diproses -> Warga
            [
                'kode' => 'surat_diproses_warga',
                'nama' => 'Pemberitahuan Surat Sedang Diproses (ke Warga)',
                'kategori' => 'surat',
                'target' => 'warga',
                'konten' => "Halo *{nama_pemohon}*,\n\nPermohonan surat Anda saat ini *SEDANG DIPROSES* oleh petugas balai desa:\n\n📄 *Jenis Surat:* {jenis_surat}\n🔢 *Nomor:* {nomor_permohonan}\n👨‍💼 *Petugas Verifikator:* {nama_petugas}\n\nMohon ditunggu, surat resmi Anda sedang disiapkan dan ditandatangani.\n\n_Pemerintah Desa Rombiya Barat, Kec. Ganding, Kab. Sumenep_",
                'variabel_tersedia' => ['nama_pemohon', 'jenis_surat', 'nomor_permohonan', 'nama_petugas'],
            ],

            // 4. Surat Disetujui / Selesai -> Warga
            [
                'kode' => 'surat_disetujui_warga',
                'nama' => 'Pemberitahuan Surat Selesai & Siap Diunduh (ke Warga)',
                'kategori' => 'surat',
                'target' => 'warga',
                'konten' => "Kabar Baik Bapak/Ibu *{nama_pemohon}*,\n\nPermohonan surat Anda telah *DISETUJUI & SELESAI DITERBITKAN* secara resmi oleh Pemerintah Desa Rombiya Barat.\n\n📄 *Jenis Surat:* {jenis_surat}\n🔢 *Nomor Registrasi:* {nomor_permohonan}\n📅 *Tanggal Terbit:* {tanggal_selesai}\n\nAnda dapat mengunduh dan mencetak langsung dokumen surat resmi berformat PDF melalui tautan berikut:\n📥 {link_download_pdf}\n\nSurat ini sah dan dilengkapi kode verifikasi digital desa.\n\n_Pemerintah Desa Rombiya Barat, Kec. Ganding, Kab. Sumenep_",
                'variabel_tersedia' => ['nama_pemohon', 'jenis_surat', 'nomor_permohonan', 'tanggal_selesai', 'link_download_pdf'],
            ],

            // 5. Surat Butuh Koreksi -> Warga
            [
                'kode' => 'surat_koreksi_warga',
                'nama' => 'Pemberitahuan Perbaikan Berkas Surat (ke Warga)',
                'kategori' => 'surat',
                'target' => 'warga',
                'konten' => "Yth. Bapak/Ibu *{nama_pemohon}*,\n\nPermohonan surat *{jenis_surat}* ({nomor_permohonan}) membutuhkan perbaikan berkas persyaratan.\n\n📝 *Catatan Petugas Verifikator:*\n\"{catatan_petugas}\"\n\nSilakan lakukan perbaikan atau unggah ulang dokumen pendukung melalui akun SIPEDES Anda:\n🔗 {link_status}\n\n_Pemerintah Desa Rombiya Barat, Kec. Ganding, Kab. Sumenep_",
                'variabel_tersedia' => ['nama_pemohon', 'jenis_surat', 'nomor_permohonan', 'catatan_petugas', 'link_status'],
            ],

            // 6. Surat Ditolak -> Warga
            [
                'kode' => 'surat_ditolak_warga',
                'nama' => 'Pemberitahuan Surat Ditolak (ke Warga)',
                'kategori' => 'surat',
                'target' => 'warga',
                'konten' => "Yth. Bapak/Ibu *{nama_pemohon}*,\n\nMohon maaf, permohonan surat *{jenis_surat}* ({nomor_permohonan}) belum dapat disetujui.\n\n⚠️ *Alasan:* \n\"{catatan_petugas}\"\n\nApabila memerlukan informasi lebih lanjut, silakan hubungi Balai Desa Rombiya Barat pada jam pelayanan kerja.\n\n_Pemerintah Desa Rombiya Barat, Kec. Ganding, Kab. Sumenep_",
                'variabel_tersedia' => ['nama_pemohon', 'jenis_surat', 'nomor_permohonan', 'catatan_petugas'],
            ],

            // 7. Pengaduan Baru -> Petugas/Kasun
            [
                'kode' => 'pengaduan_masuk_petugas',
                'nama' => 'Alert Laporan Pengaduan Baru (ke Petugas/Pamong)',
                'kategori' => 'pengaduan',
                'target' => 'petugas',
                'konten' => "📢 *LAPORAN ASPIRASI / PENGADUAN WARGA BARU*\n\nYth. Petugas & Kepala Dusun,\nTerdapat pengaduan masyarakat yang baru disampaikan warga:\n\n🎫 *No. Tiket:* {kode_tiket}\n👤 *Pelapor:* {nama_pelapor}\n📍 *Lokasi Dusun:* {dusun}\n📂 *Kategori:* {kategori}\n📋 *Judul Laporan:* {judul_pengaduan}\n\nDetail tindak lanjut dapat diakses di panel admin:\n🔗 {link_admin}\n\n_SIPEDES Desa Rombiya Barat_",
                'variabel_tersedia' => ['kode_tiket', 'nama_pelapor', 'dusun', 'kategori', 'judul_pengaduan', 'link_admin'],
            ],

            // 8. Pengaduan Selesai / Ditindaklanjuti -> Warga
            [
                'kode' => 'pengaduan_selesai_warga',
                'nama' => 'Tanggapan Penanganan Pengaduan Selesai (ke Warga)',
                'kategori' => 'pengaduan',
                'target' => 'warga',
                'konten' => "Halo *{nama_pelapor}*,\n\nTerima kasih atas kepedulian Anda terhadap lingkungan Desa Rombiya Barat.\nLaporan pengaduan Anda telah ditindaklanjuti oleh pamong desa:\n\n🎫 *No. Tiket:* {kode_tiket}\n📋 *Judul:* {judul_pengaduan}\n✅ *Status:* Selesai Ditindaklanjuti\n\n💬 *Tanggapan Resmi Balai Desa:*\n\"{tanggapan_petugas}\"\n\n_Pemerintah Desa Rombiya Barat, Kec. Ganding, Kab. Sumenep_",
                'variabel_tersedia' => ['nama_pelapor', 'kode_tiket', 'judul_pengaduan', 'tanggapan_petugas'],
            ],

            // 9. Pengaduan Diterima -> Warga Pelapor
            [
                'kode' => 'pengaduan_dibuat_warga',
                'nama' => 'Bukti Tanda Terima Pengaduan (ke Warga Pelapor)',
                'kategori' => 'pengaduan',
                'target' => 'warga',
                'konten' => "Salam Bapak/Ibu *{nama_pelapor}*,\n\nLaporan aspirasi/pengaduan Anda telah resmi tercatat di sistem *SIPEDES Desa Rombiya Barat*:\n\n🎫 *No. Tiket:* {kode_tiket}\n📋 *Judul Laporan:* {judul_pengaduan}\n📂 *Kategori:* {kategori}\n🕒 *Waktu Lapor:* {tanggal_laporan}\n\nPamong desa akan meninjau dan menindaklanjuti laporan Anda. Anda dapat memantau perkembangannya pada akun SIPEDES Anda.\n\n_Pemerintah Desa Rombiya Barat, Kec. Ganding, Kab. Sumenep_",
                'variabel_tersedia' => ['nama_pelapor', 'kode_tiket', 'judul_pengaduan', 'kategori', 'tanggal_laporan'],
            ],

            // 10. OTP Lupa Password -> Warga
            [
                'kode' => 'otp_lupa_password',
                'nama' => 'Kode OTP Reset Kata Sandi Akun Warga',
                'kategori' => 'sistem',
                'target' => 'warga',
                'konten' => "🔐 *KODE VERIFIKASI OTP — SIPEDES DESA ROMBIYA BARAT*\n\nYth. *{nama_warga}*,\n\nKami menerima permintaan untuk mereset kata sandi akun SIPEDES Anda. Berikut adalah kode verifikasi OTP Anda:\n\n👉 *{otp_code}*\n\nKode ini bersifat RAHASIA dan berlaku selama 10 menit. Jangan berikan kode ini kepada siapa pun termasuk perangkat desa.\n\nJika Anda tidak merasa meminta reset kata sandi, amankan akun Anda segera.\n\n_Pemerintah Desa Rombiya Barat, Kec. Ganding, Kab. Sumenep_",
                'variabel_tersedia' => ['nama_warga', 'otp_code'],
            ],

            // 11. Konfirmasi Kata Sandi Berhasil Diubah -> Warga
            [
                'kode' => 'password_berhasil_diubah',
                'nama' => 'Notifikasi Kata Sandi Berhasil Diperbarui',
                'kategori' => 'sistem',
                'target' => 'warga',
                'konten' => "✅ *KATA SANDI BERHASIL DIPERBARUI — SIPEDES DESA ROMBIYA BARAT*\n\nHalo *{nama_warga}*,\n\nKata sandi akun SIPEDES Anda telah berhasil diubah pada {waktu}.\n\nJika Anda merasa tidak melakukan perubahan ini, segera hubungi Balai Desa Rombiya Barat untuk mengamankan akun Anda.\n\n_Pemerintah Desa Rombiya Barat, Kec. Ganding, Kab. Sumenep_",
                'variabel_tersedia' => ['nama_warga', 'waktu'],
            ],
        ];

        foreach ($templates as $tpl) {
            WhatsAppTemplate::updateOrCreate(
                ['kode' => $tpl['kode']],
                $tpl
            );
        }
    }
}
