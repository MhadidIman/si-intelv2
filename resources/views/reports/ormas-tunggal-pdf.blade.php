<!DOCTYPE html>
<html>

<head>
    <title>Profil Ormas - {{ $item->nama_organisasi }}</title>
    <style>
        body {
            font-family: 'Times New Roman', serif;
            font-size: 12pt;
            line-height: 1.6;
        }

        .header {
            text-align: center;
            border-bottom: 3px double #000;
            padding-bottom: 10px;
            margin-bottom: 30px;
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
            margin-bottom: 30px;
        }

        .logo-ormas {
            float: right;
            width: 120px;
            border: 1px solid #ccc;
            padding: 5px;
        }

        table {
            border: none;
            width: 100%;
            margin-top: 20px;
        }

        td {
            padding: 6px;
            vertical-align: top;
        }

        .label {
            font-weight: bold;
            width: 35%;
        }

        .footer {
            margin-top: 50px;
            clear: both;
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

    <div class="title-doc">LEMBAR PROFIL ORGANISASI KEMASYARAKATAN</div>

    <div style="width: 100%;">
        <div class="logo-ormas">
            @if($item->foto_lambang)
            <img src="{{ public_path('storage/' . $item->foto_lambang) }}" style="width: 100%;">
            @else
            <div style="height: 100px; background: #eee; text-align: center; padding-top: 40px; font-size: 10pt;">TANPA LOGO</div>
            @endif
        </div>

        <table>
            <tr>
                <td class="label">Nama Organisasi</td>
                <td>: {{ $item->nama_organisasi }}</td>
            </tr>
            <tr>
                <td class="label">Bentuk Organisasi</td>
                <td>: {{ $item->bentuk_organisasi }}</td>
            </tr>
            <tr>
                <td class="label">Nama Pimpinan</td>
                <td>: {{ $item->nama_pimpinan }}</td>
            </tr>
            <tr>
                <td class="label">Alamat Sekretariat</td>
                <td>: {{ $item->alamat_sekretariat }}</td>
            </tr>
            <tr>
                <td class="label">Status Legalitas</td>
                <td>: {{ $item->status_legalitas }}</td>
            </tr>
            <tr>
                <td class="label">Nomor SK / AHU</td>
                <td>: {{ $item->nomor_sk ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Kegiatan Utama</td>
                <td>: {{ $item->kegiatan_utama }}</td>
            </tr>
            <tr>
                <td class="label">Jumlah Anggota</td>
                <td>: {{ $item->jumlah_anggota ?? '0' }} Orang</td>
            </tr>
            <tr>
                <td class="label">Status Pengawasan</td>
                <td>: <strong>{{ strtoupper($item->status_pengawasan) }}</strong></td>
            </tr>
        </table>
    </div>

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