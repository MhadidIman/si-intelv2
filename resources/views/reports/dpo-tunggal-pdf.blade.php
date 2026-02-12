<!DOCTYPE html>
<html>

<head>
    <title>Data DPO - {{ $item->nama_lengkap }}</title>
    <style>
        body {
            font-family: 'Times New Roman', serif;
            font-size: 12pt;
            line-height: 1.5;
            color: #333;
        }

        .header {
            text-align: center;
            border-bottom: 3px double #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
            position: relative;
        }

        .logo {
            position: absolute;
            left: 0;
            top: 0;
            width: 70px;
        }

        .header h3 {
            margin: 0;
            font-size: 12pt;
            text-transform: uppercase;
        }

        .header h2 {
            margin: 0;
            font-size: 14pt;
            font-weight: bold;
            text-transform: uppercase;
        }

        .title-doc {
            text-align: center;
            font-weight: bold;
            text-decoration: underline;
            margin-top: 20px;
            margin-bottom: 30px;
            font-size: 13pt;
        }

        .content-wrapper {
            width: 100%;
        }

        .photo-column {
            width: 30%;
            float: left;
            text-align: left;
        }

        .photo-column img {
            width: 150px;
            height: 200px;
            object-fit: cover;
            border: 1px solid #ccc;
            padding: 2px;
        }

        .data-column {
            width: 70%;
            float: right;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border: none;
        }

        td {
            padding: 5px;
            vertical-align: top;
            border: none;
        }

        .label {
            font-weight: bold;
            width: 35%;
        }

        .separator {
            width: 3%;
        }

        .full-width {
            clear: both;
            padding-top: 20px;
        }

        .description-box {
            margin-top: 10px;
            padding: 10px;
            border: 1px solid #eee;
            background-color: #fafafa;
        }

        .section-label {
            font-weight: bold;
            text-decoration: underline;
            margin-bottom: 5px;
            display: block;
        }

        .footer {
            margin-top: 50px;
            width: 100%;
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
        <h3>KEJAKSAAN TINGGI KALIMANTAN SELATAN</h3>
        <h2>KEJAKSAAN NEGERI BANJARMASIN</h2>
    </div>

    <div class="title-doc">IDENTITAS DAFTAR PENCARIAN ORANG (DPO)</div>

    <div class="content-wrapper">
        <div class="photo-column">
            @if($item->foto)
            <img src="{{ public_path('storage/' . $item->foto) }}">
            @else
            <div style="width:150px; height:200px; border:1px solid #ccc; background:#f0f0f0; text-align:center; padding-top:80px; font-size:10pt; color:#999;">
                FOTO TIDAK TERSEDIA
            </div>
            @endif
        </div>

        <div class="data-column">
            <table>
                <tr>
                    <td class="label">Nama Lengkap</td>
                    <td class="separator">:</td>
                    <td>{{ $item->nama_lengkap }}</td>
                </tr>
                <tr>
                    <td class="label">Tempat Lahir</td>
                    <td class="separator">:</td>
                    <td>{{ $item->tempat_lahir }}</td>
                </tr>
                <tr>
                    <td class="label">Tanggal Lahir</td>
                    <td class="separator">:</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal_lahir)->translatedFormat('d F Y') }}</td>
                </tr>
                <tr>
                    <td class="label">Status Hukum</td>
                    <td class="separator">:</td>
                    <td>{{ $item->status_hukum }}</td>
                </tr>
                <tr>
                    <td class="label">Status Pencarian</td>
                    <td class="separator">:</td>
                    <td style="font-weight: bold; color: {{ $item->status_pencarian == 'buron' ? 'red' : 'green' }}">
                        {{ strtoupper($item->status_pencarian) }}
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div class="full-width">
        <div class="section-label">Ciri-Ciri Fisik :</div>
        <div class="description-box">
            {{ $item->ciri_fisik ?? 'Tidak ada data ciri fisik spesifik.' }}
        </div>

        <div class="section-label" style="margin-top: 15px;">Perkara / Kasus yang Dilanggar :</div>
        <div class="description-box">
            {{ $item->kasus }}
        </div>
    </div>

    <div class="footer">
        <div class="ttd">
            <p>Banjarmasin, {{ now()->translatedFormat('d F Y') }}</p>
            <p><strong>KEPALA SEKSI INTELIJEN</strong></p>
            <br><br><br><br>
            <p><u><strong>BUDI SANTOSO, S.H., M.H.</strong></u></p>
            <p>Jaksa Madya NIP. 198501012010121001</p>
        </div>
    </div>
</body>

</html>