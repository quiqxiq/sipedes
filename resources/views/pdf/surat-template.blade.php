<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $permohonan->jenisSurat->nama ?? 'Surat Resmi' }} — {{ $permohonan->nomor_permohonan }}</title>
    <style>
        @page {
            margin: 1.5cm 2cm 1.5cm 2cm;
            size: a4 portrait;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11pt;
            line-height: 1.35;
            color: #000;
            margin: 0;
            padding: 0;
        }

        /* Kop Surat Resmi Desa Rombiya Barat */
        .kop-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 0;
        }

        .kop-table td {
            vertical-align: middle;
            padding: 0;
        }

        .kop-logo {
            width: 80px;
            text-align: center;
        }

        .kop-logo img {
            width: 76px;
            height: auto;
            max-height: 84px;
        }

        .kop-text {
            text-align: center;
            padding-left: 10px;
        }

        .kop-instansi-1 {
            font-size: 13pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            line-height: 1.2;
            margin: 0;
        }

        .kop-instansi-2 {
            font-size: 13pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            line-height: 1.2;
            margin: 0;
        }

        .kop-instansi-3 {
            font-size: 15pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            line-height: 1.25;
            margin: 1px 0;
        }

        .kop-alamat {
            font-size: 9pt;
            font-style: italic;
            line-height: 1.25;
            margin-top: 3px;
        }

        /* Garis Ganda Pembatas Kop Surat */
        .kop-separator {
            border-top: 2.5px solid #000;
            border-bottom: 0.8px solid #000;
            height: 2px;
            margin-top: 5px;
            margin-bottom: 16px;
        }

        /* Judul & Nomor Surat */
        .judul-box {
            text-align: center;
            margin-bottom: 18px;
        }

        .judul-text {
            font-size: 12.5pt;
            font-weight: bold;
            text-transform: uppercase;
            text-decoration: underline;
            letter-spacing: 0.5px;
            margin: 0;
        }

        .nomor-text {
            font-size: 10.5pt;
            margin-top: 2px;
        }

        /* Konten Isi Surat */
        .isi-surat {
            text-align: justify;
            font-size: 11pt;
            line-height: 1.4;
        }

        .isi-surat p {
            margin: 6px 0;
            text-indent: 28px;
        }

        .isi-surat p.no-indent {
            text-indent: 0;
        }

        /* Tabel Isian Biodata */
        .table-data {
            width: 100%;
            border-collapse: collapse;
            margin: 6px 0 10px 15px;
            font-size: 10.5pt;
        }

        .table-data td {
            vertical-align: top;
            padding: 2.5px 0;
            line-height: 1.35;
        }

        .table-data td.col-label {
            width: 175px;
        }

        .table-data td.col-colon {
            width: 15px;
            text-align: center;
        }

        .table-data td.col-value {
            text-align: justify;
        }

        /* Tabel Khusus 12 Butir (Pindah Domisili) */
        .table-butir {
            width: 100%;
            border-collapse: collapse;
            margin: 4px 0 8px 0;
            font-size: 10pt;
        }

        .table-butir td {
            vertical-align: top;
            padding: 2px 0;
            line-height: 1.3;
        }

        .table-butir td.col-num {
            width: 22px;
        }

        .table-butir td.col-label {
            width: 165px;
        }

        .table-butir td.col-colon {
            width: 12px;
            text-align: center;
        }

        /* Kotak Tanda Tangan */
        .ttd-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .ttd-table td {
            vertical-align: top;
        }



        .ttd-col {
            text-align: center;
        }

        .ttd-tanggal {
            margin: 0;
            font-size: 10.5pt;
        }

        .ttd-jabatan {
            margin: 2px 0 0 0;
            font-size: 10.5pt;
        }

        .ttd-space {
            height: 65px;
        }

        .ttd-nama {
            margin: 0;
            font-size: 11pt;
            font-weight: bold;
            text-decoration: underline;
        }
    </style>
</head>
<body>

    @php
        $user = $permohonan->user;
        $data = $permohonan->data_pemohon ?? [];
        $kode = strtolower($permohonan->jenisSurat->kode ?? '');
        $namaSurat = strtoupper($permohonan->jenisSurat->nama ?? 'SURAT KETERANGAN');
    @endphp

    <!-- 1. KOP SURAT RESMI PEMERINTAH DESA ROMBIYA BARAT -->
    <table class="kop-table">
        <tr>
            <td class="kop-logo">
                @if(!empty($logoBase64))
                    <img src="{{ $logoBase64 }}" alt="Logo Desa Rombiya Barat">
                @endif
            </td>
            <td class="kop-text">
                <div class="kop-instansi-1">PEMERINTAH KABUPATEN {{ strtoupper($profil->kabupaten ?? 'SUMENEP') }}</div>
                <div class="kop-instansi-2">KECAMATAN {{ strtoupper($profil->kecamatan ?? 'GANDING') }}</div>
                <div class="kop-instansi-3">DESA {{ strtoupper($profil->nama_desa ?? 'ROMBIYA BARAT') }}</div>
                <div class="kop-alamat">
                    {{ $profil->kontak['alamat_kantor'] ?? 'Jl. Raya Ganding - Rombiya Barat No. 01, Kec. Ganding, Kab. Sumenep 69462' }}
                    @if(!empty($profil->kontak['telepon'])) | Telp: {{ $profil->kontak['telepon'] }} @endif
                </div>
            </td>
        </tr>
    </table>

    <!-- Garis Ganda Kop Surat Resmi -->
    <div class="kop-separator"></div>

    <!-- 2. JUDUL & NOMOR SURAT -->
    <div class="judul-box">
        <div class="judul-text">
            @if($kode === 'skk')
                SURAT KETERANGAN KEMATIAN
            @elseif($kode === 'sktm')
                SURAT KETERANGAN TIDAK MAMPU
            @elseif($kode === 'sku')
                SURAT KETERANGAN USAHA
            @elseif($kode === 'skn')
                SURAT KETERANGAN NIKAH
            @elseif($kode === 'skd')
                SURAT KETERANGAN PINDAH DOMISILI
            @else
                {{ $namaSurat }}
            @endif
        </div>
        <div class="nomor-text">Nomor : {{ $permohonan->nomor_permohonan }}</div>
    </div>

    <!-- 3. ISI SURAT BERDASARKAN JENIS TEMPLATE -->
    <div class="isi-surat">

        {{-- ==================================================================== --}}
        {{-- CASE 1: SKK - SURAT KETERANGAN KEMATIAN                              --}}
        {{-- (Sesuai TEMPLATE_SURAT/Surat_Keterangan_Kematian.docx)               --}}
        {{-- ==================================================================== --}}
        @if($kode === 'skk')
            <p class="no-indent">Saya yang bertanda tangan dibawah ini, Kepala Desa {{ $profil->nama_desa ?? 'Rombiya Barat' }} Kecamatan {{ $profil->kecamatan ?? 'Ganding' }} Kabupaten {{ $profil->kabupaten ?? 'Sumenep' }} dengan ini menerangkan bahwa :</p>

            <table class="table-data">
                <tr>
                    <td class="col-label">Nama</td>
                    <td class="col-colon">:</td>
                    <td class="col-value"><strong>{{ strtoupper($data['nama_almarhum'] ?? ($user->name ?? '-')) }}</strong></td>
                </tr>
                <tr>
                    <td class="col-label">Jenis Kelamin</td>
                    <td class="col-colon">:</td>
                    <td class="col-value">{{ $data['jenis_kelamin_almarhum'] ?? ($data['jenis_kelamin'] ?? 'Laki-laki') }}</td>
                </tr>
                <tr>
                    <td class="col-label">Tempat, Tanggal Lahir</td>
                    <td class="col-colon">:</td>
                    <td class="col-value">{{ $data['ttl_almarhum'] ?? ($data['ttl'] ?? 'Sumenep, -') }}</td>
                </tr>
                <tr>
                    <td class="col-label">Agama</td>
                    <td class="col-colon">:</td>
                    <td class="col-value">{{ $data['agama_almarhum'] ?? 'Islam' }}</td>
                </tr>
                <tr>
                    <td class="col-label">Pekerjaan</td>
                    <td class="col-colon">:</td>
                    <td class="col-value">{{ $data['pekerjaan_almarhum'] ?? 'Petani / Wiraswasta' }}</td>
                </tr>
                <tr>
                    <td class="col-label">No. KTP</td>
                    <td class="col-colon">:</td>
                    <td class="col-value">{{ $data['nik_almarhum'] ?? ($user->nik ?? '-') }}</td>
                </tr>
                <tr>
                    <td class="col-label">Alamat</td>
                    <td class="col-colon">:</td>
                    <td class="col-value">{{ $data['alamat_almarhum'] ?? ($user->alamat ?? 'Desa Rombiya Barat, Kecamatan Ganding, Kabupaten Sumenep') }}</td>
                </tr>
            </table>

            <p class="no-indent" style="margin-top: 10px;">Telah meninggal dunia pada :</p>

            <table class="table-data">
                <tr>
                    <td class="col-label">Hari, Tanggal</td>
                    <td class="col-colon">:</td>
                    <td class="col-value">{{ $data['hari_tanggal_kematian'] ?? $tanggalSurat }}</td>
                </tr>
                <tr>
                    <td class="col-label">Pukul</td>
                    <td class="col-colon">:</td>
                    <td class="col-value">{{ $data['pukul_kematian'] ?? '08:00 WIB' }}</td>
                </tr>
                <tr>
                    <td class="col-label">Bertempat di</td>
                    <td class="col-colon">:</td>
                    <td class="col-value">{{ $data['tempat_kematian'] ?? 'Rumah Duka, Desa Rombiya Barat' }}</td>
                </tr>
                <tr>
                    <td class="col-label">Dimakamkan di</td>
                    <td class="col-colon">:</td>
                    <td class="col-value">{{ $data['tempat_pemakaman'] ?? 'Tempat Pemakaman Umum Desa Rombiya Barat' }}</td>
                </tr>
            </table>

            <p class="no-indent" style="margin-top: 10px;">Surat Keterangan ini dibuat berdasarkan keterangan pelapor :</p>

            <table class="table-data">
                <tr>
                    <td class="col-label">Nama</td>
                    <td class="col-colon">:</td>
                    <td class="col-value"><strong>{{ strtoupper($data['nama_pelapor'] ?? ($user->name ?? '-')) }}</strong></td>
                </tr>
                <tr>
                    <td class="col-label">Jenis Kelamin</td>
                    <td class="col-colon">:</td>
                    <td class="col-value">{{ $data['jenis_kelamin_pelapor'] ?? 'Laki-laki' }}</td>
                </tr>
                <tr>
                    <td class="col-label">Tempat, Tanggal Lahir</td>
                    <td class="col-colon">:</td>
                    <td class="col-value">{{ $data['ttl_pelapor'] ?? 'Sumenep, -' }}</td>
                </tr>
                <tr>
                    <td class="col-label">Agama</td>
                    <td class="col-colon">:</td>
                    <td class="col-value">{{ $data['agama_pelapor'] ?? 'Islam' }}</td>
                </tr>
                <tr>
                    <td class="col-label">Pekerjaan</td>
                    <td class="col-colon">:</td>
                    <td class="col-value">{{ $data['pekerjaan_pelapor'] ?? 'Wiraswasta' }}</td>
                </tr>
                <tr>
                    <td class="col-label">No. KTP</td>
                    <td class="col-colon">:</td>
                    <td class="col-value">{{ $user->nik ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="col-label">Alamat</td>
                    <td class="col-colon">:</td>
                    <td class="col-value">{{ $user->alamat ?? 'Desa Rombiya Barat, Kecamatan Ganding, Kabupaten Sumenep' }}</td>
                </tr>
                <tr>
                    <td class="col-label">Hubungan pelapor</td>
                    <td class="col-colon">:</td>
                    <td class="col-value">{{ $data['hubungan_pelapor'] ?? 'Keluarga Kandung / Ahli Waris' }}</td>
                </tr>
            </table>

            <p style="margin-top: 12px;">Demikian surat keterangan kematian ini dibuat dengan sebenar-benarnya agar dapat dipergunakan sebagaimana mestinya.</p>

        {{-- ==================================================================== --}}
        {{-- CASE 2: SKTM - SURAT KETERANGAN TIDAK MAMPU                          --}}
        {{-- (Sesuai TEMPLATE_SURAT/Template_Surat_Keterangan_Tidak_Mampu.docx)   --}}
        {{-- ==================================================================== --}}
        @elseif($kode === 'sktm')
            <p class="no-indent">Yang bertanda tangan dibawah ini, Kepala Desa {{ $profil->nama_desa ?? 'Rombiya Barat' }} Kecamatan {{ $profil->kecamatan ?? 'Ganding' }} Kabupaten {{ $profil->kabupaten ?? 'Sumenep' }}, menerangkan :</p>

            <table class="table-data">
                <tr>
                    <td class="col-label">Nama</td>
                    <td class="col-colon">:</td>
                    <td class="col-value"><strong>{{ strtoupper($user->name ?? '-') }}</strong></td>
                </tr>
                <tr>
                    <td class="col-label">Jenis Kelamin</td>
                    <td class="col-colon">:</td>
                    <td class="col-value">{{ $data['jenis_kelamin'] ?? 'Laki-laki' }}</td>
                </tr>
                <tr>
                    <td class="col-label">Tempat Tgl Lahir</td>
                    <td class="col-colon">:</td>
                    <td class="col-value">{{ $data['ttl'] ?? 'Sumenep, -' }}</td>
                </tr>
                <tr>
                    <td class="col-label">NIK</td>
                    <td class="col-colon">:</td>
                    <td class="col-value">{{ $user->nik ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="col-label">Agama</td>
                    <td class="col-colon">:</td>
                    <td class="col-value">{{ $data['agama'] ?? 'Islam' }}</td>
                </tr>
                <tr>
                    <td class="col-label">Pekerjaan</td>
                    <td class="col-colon">:</td>
                    <td class="col-value">{{ $data['pekerjaan'] ?? 'Petani / Buruh Harian Lepas' }}</td>
                </tr>
                <tr>
                    <td class="col-label">Alamat</td>
                    <td class="col-colon">:</td>
                    <td class="col-value">{{ $user->alamat ?? 'Desa Rombiya Barat, Kecamatan Ganding, Kabupaten Sumenep' }}</td>
                </tr>
            </table>

            <p style="margin-top: 10px;">Bahwa orang tersebut di atas berdasarkan data kependudukan dan hasil penelitian kami betul-betul keadaan ekonominya kurang Mampu / Lemah.</p>

            <p class="no-indent" style="margin-top: 6px;">Surat Keterangan ini diberikan untuk :</p>
            <p class="no-indent" style="font-weight: bold; margin-left: 20px;">
                MELENGKAPI PERSYARATAN {{ strtoupper($data['keperluan'] ?? 'PERMOHONAN BEASISWA PENDIDIKAN / BANTUAN SOSIAL') }}
            </p>

            <p class="no-indent" style="margin-top: 10px;">Dengan ini menerangkan bahwa anaknya / tanggungannya :</p>

            <table class="table-data">
                <tr>
                    <td class="col-label">Nama</td>
                    <td class="col-colon">:</td>
                    <td class="col-value"><strong>{{ strtoupper($data['nama_anak'] ?? ($user->name ?? '-')) }}</strong></td>
                </tr>
                <tr>
                    <td class="col-label">Jenis Kelamin</td>
                    <td class="col-colon">:</td>
                    <td class="col-value">{{ $data['jk_anak'] ?? 'Laki-laki' }}</td>
                </tr>
                <tr>
                    <td class="col-label">Tempat Tgl Lahir</td>
                    <td class="col-colon">:</td>
                    <td class="col-value">{{ $data['ttl_anak'] ?? 'Sumenep, -' }}</td>
                </tr>
                <tr>
                    <td class="col-label">NIK</td>
                    <td class="col-colon">:</td>
                    <td class="col-value">{{ $data['nik_anak'] ?? ($user->nik ?? '-') }}</td>
                </tr>
                <tr>
                    <td class="col-label">Agama</td>
                    <td class="col-colon">:</td>
                    <td class="col-value">{{ $data['agama_anak'] ?? 'Islam' }}</td>
                </tr>
                <tr>
                    <td class="col-label">Pekerjaan / Sekolah</td>
                    <td class="col-colon">:</td>
                    <td class="col-value">{{ $data['pekerjaan_anak'] ?? 'Pelajar / Mahasiswa' }}</td>
                </tr>
                <tr>
                    <td class="col-label">Alamat</td>
                    <td class="col-colon">:</td>
                    <td class="col-value">{{ $user->alamat ?? 'Desa Rombiya Barat, Kecamatan Ganding, Kabupaten Sumenep' }}</td>
                </tr>
            </table>

            <p style="margin-top: 10px;">Demikian surat keterangan ini dibuat dan diberikan untuk digunakan seperlunya.</p>

        {{-- ==================================================================== --}}
        {{-- CASE 3: SKU - SURAT KETERANGAN USAHA                                 --}}
        {{-- (Sesuai TEMPLATE_SURAT/Template_Surat_Keterangan_Usaha.docx)         --}}
        {{-- ==================================================================== --}}
        @elseif($kode === 'sku')
            <p class="no-indent">Yang bertanda tangan dibawah ini Kepala Desa {{ $profil->nama_desa ?? 'Rombiya Barat' }} Kecamatan {{ $profil->kecamatan ?? 'Ganding' }} Kabupaten {{ $profil->kabupaten ?? 'Sumenep' }}, dengan ini menerangkan bahwa :</p>

            <table class="table-data">
                <tr>
                    <td class="col-label">Nama</td>
                    <td class="col-colon">:</td>
                    <td class="col-value"><strong>{{ strtoupper($user->name ?? '-') }}</strong></td>
                </tr>
                <tr>
                    <td class="col-label">Tempat/Tanggal Lahir</td>
                    <td class="col-colon">:</td>
                    <td class="col-value">{{ $data['ttl'] ?? 'Sumenep, -' }}</td>
                </tr>
                <tr>
                    <td class="col-label">Jenis Kelamin</td>
                    <td class="col-colon">:</td>
                    <td class="col-value">{{ $data['jenis_kelamin'] ?? 'Laki-laki' }}</td>
                </tr>
                <tr>
                    <td class="col-label">Agama</td>
                    <td class="col-colon">:</td>
                    <td class="col-value">{{ $data['agama'] ?? 'Islam' }}</td>
                </tr>
                <tr>
                    <td class="col-label">NIK. KTP</td>
                    <td class="col-colon">:</td>
                    <td class="col-value">{{ $user->nik ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="col-label">Status Perkawinan</td>
                    <td class="col-colon">:</td>
                    <td class="col-value">{{ $data['status_perkawinan'] ?? 'Kawin' }}</td>
                </tr>
                <tr>
                    <td class="col-label">Pekerjaan</td>
                    <td class="col-colon">:</td>
                    <td class="col-value">{{ $data['pekerjaan'] ?? 'Wiraswasta / Pedagang' }}</td>
                </tr>
                <tr>
                    <td class="col-label">Alamat</td>
                    <td class="col-colon">:</td>
                    <td class="col-value">{{ $user->alamat ?? 'Desa Rombiya Barat, Kecamatan Ganding, Kabupaten Sumenep' }}</td>
                </tr>
            </table>

            <p style="margin-top: 10px;">Nama yang tersebut diatas adalah benar Warga / Penduduk Desa {{ $profil->nama_desa ?? 'Rombiya Barat' }}, menurut pendataan kami Pemerintah Desa {{ $profil->nama_desa ?? 'Rombiya Barat' }}, nama tersebut mempunyai pekerjaan sehari - hari / usaha sebagai berikut :</p>

            <ol style="margin: 6px 0 6px 20px; padding-left: 10px;">
                <li><strong>{{ $data['nama_usaha_1'] ?? ($data['nama_usaha'] ?? 'Usaha Perdagangan / UMKM Mandiri') }}</strong></li>
                <li>{{ $data['nama_usaha_2'] ?? ($data['komoditas'] ?? 'Pertanian Tembakau / Pengolahan Hasil Pangan Desa') }}</li>
            </ol>

            <p>Usaha tersebut sudah berjalan sejak Tahun <strong>{{ $data['tahun_usaha'] ?? '2022' }}</strong> sampai sekarang.</p>

            <p style="margin-top: 10px;">Demikianlah surat keterangan ini kami keluarkan untuk dapat dimaklumi dan dipergunakan sebagaimana mestinya.</p>

        {{-- ==================================================================== --}}
        {{-- CASE 4: SKN - SURAT KETERANGAN / PENGANTAR NIKAH                     --}}
        {{-- (Sesuai TEMPLATE_SURAT/Template_Surat_Keterangan_Nikah.docx)         --}}
        {{-- ==================================================================== --}}
        @elseif($kode === 'skn')
            <p class="no-indent">Yang bertanda tangan dibawah ini Kepala Desa {{ $profil->nama_desa ?? 'Rombiya Barat' }} Kecamatan {{ $profil->kecamatan ?? 'Ganding' }} Kabupaten {{ $profil->kabupaten ?? 'Sumenep' }}, menerangkan bahwa :</p>

            <table class="table-data">
                <tr>
                    <td class="col-label">Nama</td>
                    <td class="col-colon">:</td>
                    <td class="col-value"><strong>{{ strtoupper($user->name ?? '-') }}</strong></td>
                </tr>
                <tr>
                    <td class="col-label">Bin</td>
                    <td class="col-colon">:</td>
                    <td class="col-value">{{ $data['bin'] ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="col-label">Tempat Tanggal Lahir</td>
                    <td class="col-colon">:</td>
                    <td class="col-value">{{ $data['ttl'] ?? 'Sumenep, -' }}</td>
                </tr>
                <tr>
                    <td class="col-label">Kewarganegaraan</td>
                    <td class="col-colon">:</td>
                    <td class="col-value">{{ $data['kewarganegaraan'] ?? 'WNI' }}</td>
                </tr>
                <tr>
                    <td class="col-label">Agama</td>
                    <td class="col-colon">:</td>
                    <td class="col-value">{{ $data['agama'] ?? 'Islam' }}</td>
                </tr>
                <tr>
                    <td class="col-label">Alamat</td>
                    <td class="col-colon">:</td>
                    <td class="col-value">{{ $user->alamat ?? 'Desa Rombiya Barat, Kecamatan Ganding, Kabupaten Sumenep' }}</td>
                </tr>
            </table>

            <p class="no-indent" style="margin-top: 8px;">Dengan seorang perempuan :</p>

            <table class="table-data">
                <tr>
                    <td class="col-label">Nama</td>
                    <td class="col-colon">:</td>
                    <td class="col-value"><strong>{{ strtoupper($data['nama_pasangan'] ?? '-') }}</strong></td>
                </tr>
                <tr>
                    <td class="col-label">Binti</td>
                    <td class="col-colon">:</td>
                    <td class="col-value">{{ $data['binti_pasangan'] ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="col-label">Tempat Tanggal Lahir</td>
                    <td class="col-colon">:</td>
                    <td class="col-value">{{ $data['ttl_pasangan'] ?? 'Sumenep, -' }}</td>
                </tr>
                <tr>
                    <td class="col-label">Kewarganegaraan</td>
                    <td class="col-colon">:</td>
                    <td class="col-value">{{ $data['kewarganegaraan_pasangan'] ?? 'WNI' }}</td>
                </tr>
                <tr>
                    <td class="col-label">Agama</td>
                    <td class="col-colon">:</td>
                    <td class="col-value">{{ $data['agama_pasangan'] ?? 'Islam' }}</td>
                </tr>
                <tr>
                    <td class="col-label">Alamat</td>
                    <td class="col-colon">:</td>
                    <td class="col-value">{{ $data['alamat_pasangan'] ?? 'Kecamatan Ganding, Kabupaten Sumenep' }}</td>
                </tr>
            </table>

            <p style="margin-top: 10px;">Menerangkan bahwa nama tersebut diatas adalah benar-benar warga yang bertempat tinggal di wilayah Desa {{ $profil->nama_desa ?? 'Rombiya Barat' }} yang bermaksud untuk melangsungkan Akad Nikah pada tanggal {{ $data['tanggal_akad'] ?? $tanggalSurat }}, untuk dipergunakan dalam pengurusan administrasi pernikahan pada Kantor Urusan Agama (KUA) Kecamatan Ganding.</p>

            <p style="margin-top: 8px;">Demikian surat keterangan ini dibuat dan dapat dipergunakan dengan mana mestinya.</p>

        {{-- ==================================================================== --}}
        {{-- CASE 5: SKD - SURAT KETERANGAN PINDAH DOMISILI                       --}}
        {{-- (Sesuai TEMPLATE_SURAT/Template_Surat_Keterangan_Pindah_Domisili.docx)--}}
        {{-- ==================================================================== --}}
        @elseif($kode === 'skd')
            <table class="table-butir">
                <tr>
                    <td class="col-num">1.</td>
                    <td class="col-label">Nama Lengkap</td>
                    <td class="col-colon">:</td>
                    <td><strong>{{ strtoupper($user->name ?? '-') }}</strong></td>
                </tr>
                <tr>
                    <td class="col-num">2.</td>
                    <td class="col-label">Jenis Kelamin</td>
                    <td class="col-colon">:</td>
                    <td>{{ $data['jenis_kelamin'] ?? 'Laki-laki' }}</td>
                </tr>
                <tr>
                    <td class="col-num">3.</td>
                    <td class="col-label">Dilahirkan di</td>
                    <td class="col-colon">:</td>
                    <td>{{ $data['tempat_lahir'] ?? 'Sumenep' }}, tgl : {{ $data['tanggal_lahir'] ?? ($data['ttl'] ?? '-') }}</td>
                </tr>
                <tr>
                    <td class="col-num">4.</td>
                    <td class="col-label">Kewarganegaraan</td>
                    <td class="col-colon">:</td>
                    <td>WNRI</td>
                </tr>
                <tr>
                    <td class="col-num">5.</td>
                    <td class="col-label">Agama</td>
                    <td class="col-colon">:</td>
                    <td>{{ $data['agama'] ?? 'Islam' }}</td>
                </tr>
                <tr>
                    <td class="col-num">6.</td>
                    <td class="col-label">Status Perkawinan</td>
                    <td class="col-colon">:</td>
                    <td>{{ $data['status_perkawinan'] ?? 'Kawin' }}</td>
                </tr>
                <tr>
                    <td class="col-num">7.</td>
                    <td class="col-label">Pekerjaan (uraikan)</td>
                    <td class="col-colon">:</td>
                    <td>{{ $data['pekerjaan'] ?? 'Wiraswasta / Petani' }}</td>
                </tr>
                <tr>
                    <td class="col-num">8.</td>
                    <td class="col-label">Pendidikan Terakhir</td>
                    <td class="col-colon">:</td>
                    <td>{{ $data['pendidikan'] ?? 'SLTA / SMA Sederajat' }}</td>
                </tr>
                <tr>
                    <td class="col-num">9.</td>
                    <td class="col-label">Alamat asal</td>
                    <td class="col-colon">:</td>
                    <td>{{ $user->alamat ?? 'Dusun Rombiya, Desa Rombiya Barat, Kec. Ganding, Kab. Sumenep, Provinsi Jawa Timur' }}</td>
                </tr>
                <tr>
                    <td class="col-num">10.</td>
                    <td class="col-label">No. dan Tanggal KTP</td>
                    <td class="col-colon">:</td>
                    <td>{{ $user->nik ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="col-num">11.</td>
                    <td class="col-label">Pindah ke</td>
                    <td class="col-colon">:</td>
                    <td>
                        Desa / Kelurahan : {{ $data['desa_tujuan'] ?? '-' }}<br>
                        Kecamatan : {{ $data['kecamatan_tujuan'] ?? '-' }}<br>
                        Kab. / Kodya : {{ $data['kabupaten_tujuan'] ?? 'Sumenep' }}<br>
                        Propinsi : {{ $data['provinsi_tujuan'] ?? 'Jawa Timur' }}<br>
                        Pada tanggal : {{ $data['tanggal_pindah'] ?? $tanggalSurat }}
                    </td>
                </tr>
                <tr>
                    <td class="col-num">12.</td>
                    <td class="col-label">Alasan pindah</td>
                    <td class="col-colon">:</td>
                    <td>{{ $data['alasan_pindah'] ?? 'Mengikuti Tempat Tinggal Keluarga / Pekerjaan' }}</td>
                </tr>
            </table>

            <p style="margin-top: 8px;">Demikian surat keterangan pindah domisili ini dibuat dengan sebenarnya untuk dapat dipergunakan sebagaimana mestinya.</p>

        {{-- ==================================================================== --}}
        {{-- DEFAULT: FORMAT SURAT KETERANGAN RESMI DESA ROMBIYA BARAT            --}}
        {{-- (Untuk SKT, SKBM, dan Surat Keterangan Umum Lainnya)                 --}}
        {{-- ==================================================================== --}}
        @else
            <p class="no-indent">Yang bertanda tangan di bawah ini Kepala Desa {{ $profil->nama_desa ?? 'Rombiya Barat' }}, Kecamatan {{ $profil->kecamatan ?? 'Ganding' }}, Kabupaten {{ $profil->kabupaten ?? 'Sumenep' }}, menerangkan dengan sebenarnya bahwa:</p>

            <table class="table-data">
                <tr>
                    <td class="col-label">Nama Lengkap</td>
                    <td class="col-colon">:</td>
                    <td class="col-value"><strong>{{ strtoupper($user->name ?? '-') }}</strong></td>
                </tr>
                <tr>
                    <td class="col-label">NIK</td>
                    <td class="col-colon">:</td>
                    <td class="col-value">{{ $user->nik ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="col-label">Jenis Kelamin</td>
                    <td class="col-colon">:</td>
                    <td class="col-value">{{ $data['jenis_kelamin'] ?? 'Laki-laki' }}</td>
                </tr>
                <tr>
                    <td class="col-label">Tempat/Tanggal Lahir</td>
                    <td class="col-colon">:</td>
                    <td class="col-value">{{ $data['ttl'] ?? 'Sumenep, -' }}</td>
                </tr>
                <tr>
                    <td class="col-label">Agama</td>
                    <td class="col-colon">:</td>
                    <td class="col-value">{{ $data['agama'] ?? 'Islam' }}</td>
                </tr>
                <tr>
                    <td class="col-label">Pekerjaan</td>
                    <td class="col-colon">:</td>
                    <td class="col-value">{{ $data['pekerjaan'] ?? 'Wiraswasta / Petani' }}</td>
                </tr>
                <tr>
                    <td class="col-label">Alamat Domisili</td>
                    <td class="col-colon">:</td>
                    <td class="col-value">{{ $user->alamat ?? 'Desa Rombiya Barat, Kecamatan Ganding, Kabupaten Sumenep' }}</td>
                </tr>
            </table>

            <p>Orang tersebut di atas adalah benar-benar warga yang bertempat tinggal di wilayah Desa {{ $profil->nama_desa ?? 'Rombiya Barat' }}, Kecamatan {{ $profil->kecamatan ?? 'Ganding' }}, Kabupaten {{ $profil->kabupaten ?? 'Sumenep' }}. Surat keterangan ini diterbitkan secara sah dan resmi berdasarkan verifikasi berkas persyaratan permohonan <strong>{{ $permohonan->jenisSurat->nama ?? '' }}</strong>.</p>

            <p style="margin-top: 8px;">Demikian Surat Keterangan ini dibuat dengan sebenarnya untuk dapat dipergunakan sebagaimana mestinya.</p>
        @endif

    </div>

    <!-- 4. BLOK TANDA TANGAN RESMI KEPALA DESA & LEGALITAS DIGITAL -->
    <table class="ttd-table">
        <tr>
            <td width="55%">&nbsp;</td>
            <td width="45%" class="ttd-col">
                <p class="ttd-tanggal">Rombiya Barat, {{ $tanggalSurat }}</p>
                <p class="ttd-jabatan">Kepala Desa Rombiya Barat</p>
                <div class="ttd-space"></div>
                <p class="ttd-nama"><strong><u>{{ $kadesName }}</u></strong></p>
            </td>
        </tr>
    </table>

</body>
</html>
