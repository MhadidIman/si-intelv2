<!DOCTYPE html>
<html>

<head>
    <title>Laporan Giat PAM - {{ $item->nama_kegiatan }}</title>
    <style>
        body {
            font-family: 'Times New Roman', serif;
            font-size: 12pt;
            line-height: 1.5;
        }

        .header {
            text-align: center;
            border-bottom: 3px double #000;
            padding-bottom: 10px;
            margin-bottom: 25px;
            position: relative;
        }

        .logo {
            position: absolute;
            left: 0;
            top: 0;
            width: 70px;
        }

        .title-doc {
            text-align: center;
            font-weight: bold;
            text-decoration: underline;
            margin-bottom: 25px;
        }

        table {
            border: none;
            width: 100%;
        }

        td {
            padding: 5px;
            vertical-align: top;
        }

        .label {
            font-weight: bold;
            width: 30%;
        }

        .photo-box {
            margin-top: 20px;
            text-align: center;
        }

        .photo-box img {
            max-width: 400px;
            border: 1px solid #000;
        }

        .footer {
            margin-top: 50px;
        }

        .ttd {
            float: right;
            width: 45%;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="header">
        <img src="{{ public_path('img/logo-kejaksaan.png') }}" class="logo">
        <h3>KEJAKSAAN REPUBLIK INDONESIA</h3>
        <h2>KEJAKSAAN NEGERI BANJARMASIN</h2>
    </div>

    <div class="title-doc">LAPORAN HASIL PENGAMANAN (PAM SDO)</div>

    <table>
        <tr>
            <td class="label">Nama Kegiatan</td>
            <td>: {{ $item->nama_kegiatan }}</td>
        </tr>
        <tr>
            <td class="label">Kategori PAM</td>
            <td>: {{ $item->kategori_pam }}</td>
        </tr>
        <tr>
            <td class="label">Waktu Pelaksanaan</td>
            <td>: {{ \Carbon\Carbon::parse($item->tanggal_kegiatan)->translatedFormat('l, d F Y') }}</td>
        </tr>
        <tr>
            <td class="label">Lokasi</td>
            <td>: {{ $item->lokasi }}</td>
        </tr>
        <tr>
            <td class="label">Petugas Pelaksana</td>
            <td>: {{ $item->pelaksana }}</td>
        </tr>
        <tr>
            <td class="label">Kondisi / Status</td>
            <td>: <strong>{{ strtoupper($item->status) }}</strong></td>
        </tr>
    </table>

    <div style="margin-top: 20px; font-weight: bold;">URAIAN KEGIATAN / HASIL :</div>
    <div style="text-align: justify;">{{ $item->keterangan ?? 'Kegiatan pengamanan berjalan lancar tanpa kendala berarti.' }}</div>

    @if($item->foto_dokumentasi)
    <div class="photo-box">
        <p style="font-weight: bold;">DOKUMENTASI KEGIATAN</p>
        <img src="{{ public_path('storage/' . $item->foto_dokumentasi) }}">
    </div>
    @endif

    <div class="footer">
        <div class="ttd">
            <p>Banjarmasin, {{ now()->translatedFormat('d F Y') }}</p>
            <p><strong>KEPALA SEKSI INTELIJEN</strong></p>
            <br><br><br><br>
            <p><u><strong>DIMAS PURNAMA PUTRA, S.H., M.H.</strong></u></p>
            <p>Jaksa Madya NIP. 19850101 201001 1 001</p>
        </div>
    </div>
</body>

</html>