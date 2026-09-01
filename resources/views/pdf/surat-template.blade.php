<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Resmi — {{ $permohonan->nomor_permohonan }}</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            line-height: 1.5;
            color: #000;
            margin: 0;
            padding: 20px;
        }
        .kop-header {
            text-align: center;
            border-bottom: 3px double #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .kop-header h3 {
            margin: 0;
            font-size: 14pt;
            text-transform: uppercase;
        }
        .kop-header h2 {
            margin: 2px 0;
            font-size: 16pt;
            text-transform: uppercase;
        }
        .kop-header p {
            margin: 0;
            font-size: 10pt;
            font-style: italic;
        }
        .judul-surat {
            text-align: center;
            margin-bottom: 25px;
        }
        .judul-surat h4 {
            margin: 0;
            font-size: 14pt;
            text-decoration: underline;
            text-transform: uppercase;
        }
        .judul-surat p {
            margin: 2px 0;
            font-size: 11pt;
        }
        .isi-surat {
            text-align: justify;
            margin-bottom: 20px;
        }
        .table-data {
            width: 100%;
            margin: 15px 0 20px 20px;
        }
        .table-data td {
            vertical-align: top;
            padding: 3px 0;
        }
        .ttd-box {
            width: 100%;
            margin-top: 40px;
        }
        .ttd-right {
            float: right;
            width: 250px;
            text-align: center;
        }
    </style>
</head>
<body>

    <!-- Kop Surat -->
    <div class="kop-header">
        <h3>PEMERINTAH KABUPATEN {{ strtoupper($profil->kabupaten ?? 'SUMENEP') }}</h3>
        <h3>KECAMATAN {{ strtoupper($profil->kecamatan ?? 'GANDING') }}</h3>
        <h2>PEMERINTAH DESA {{ strtoupper($profil->nama_desa ?? 'ROMBIYAH BARAT') }}</h2>
        <p>{{ $profil->kontak['alamat_kantor'] ?? 'Jl. Raya Ganding - Rombiyah Barat No. 01, Kec. Ganding, Kab. Sumenep 69462' }} | Telp: {{ $profil->kontak['telepon'] ?? '082334567890' }}</p>
    </div>

    <!-- Judul & Nomor Surat -->
    <div class="judul-surat">
        <h4>{{ $permohonan->jenisSurat->nama ?? 'SURAT KETERANGAN' }}</h4>
        <p>Nomor: {{ $permohonan->nomor_permohonan }}</p>
    </div>

    <!-- Isi Surat -->
    <div class="isi-surat">
        <p>Yang bertanda tangan di bawah ini Kepala Desa {{ $profil->nama_desa ?? 'Rombiyah Barat' }}, Kecamatan {{ $profil->kecamatan ?? 'Ganding' }}, Kabupaten {{ $profil->kabupaten ?? 'Sumenep' }}, menerangkan dengan sebenarnya bahwa:</p>

        <table class="table-data">
            <tr>
                <td width="160">Nama Lengkap</td>
                <td width="10">:</td>
                <td><strong>{{ strtoupper($permohonan->user->name ?? '-') }}</strong></td>
            </tr>
            <tr>
                <td>NIK</td>
                <td>:</td>
                <td>{{ $permohonan->user->nik ?? '-' }}</td>
            </tr>
            <tr>
                <td>Nomor Telepon/WA</td>
                <td>:</td>
                <td>{{ $permohonan->user->telepon ?? '-' }}</td>
            </tr>
            <tr>
                <td>Alamat Domisili</td>
                <td>:</td>
                <td>{{ $permohonan->user->alamat ?? '-' }}</td>
            </tr>
        </table>

        <p>Orang tersebut di atas adalah benar-benar warga yang bertempat tinggal di wilayah Desa {{ $profil->nama_desa ?? 'Rombiyah Barat' }}, Kecamatan {{ $profil->kecamatan ?? 'Ganding' }}, Kabupaten {{ $profil->kabupaten ?? 'Sumenep' }}. Surat keterangan ini diterbitkan secara sah dan digital berdasarkan verifikasi berkas persyaratan permohonan {{ $permohonan->jenisSurat->nama ?? '' }}.</p>

        <p>Demikian Surat Keterangan ini dibuat dengan sebenarnya untuk dapat dipergunakan sebagaimana mestinya.</p>
    </div>

    <!-- Tanda Tangan Block -->
    <div class="ttd-box">
        <div class="ttd-right">
            <p>Rombiyah Barat, {{ $permohonan->updated_at ? $permohonan->updated_at->format('d F Y') : date('d F Y') }}</p>
            <p>Kepala Desa Rombiyah Barat</p>
            <br><br><br><br>
            <p><strong><u>{{ strtoupper($profil->kepala_desa ?? 'FARHAH') }}</u></strong></p>
        </div>
    </div>

</body>
</html>
