<!DOCTYPE html>
<html>

<head>
    <title>Biodata WNA - {{ $item->nama_lengkap }}</title>
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

        .photo-section {
            float: right;
            width: 150px;
            border: 1px solid #000;
            padding: 2px;
        }

        .data-section {
            width: 75%;
        }

        table {
            border: none;
            width: 100%;
        }

        td {
            padding: 4px;
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

    <div class="title-doc">LEMBAR PENGAWASAN ORANG ASING</div>

    <div style="width: 100%;">
        <div class="photo-section" style="float: right;">
            @if($item->foto)
            <img src="{{ public_path('storage/' . $item->foto) }}" style="width: 100%;">
            @else
            <div style="height: 200px; background: #eee; text-align: center; padding-top: 80px;">TANPA FOTO</div>
            @endif
        </div>

        <div class="data-section">
            <table>
                <tr>
                    <td class="label">Nama Lengkap</td>
                    <td>: {{ $item->nama_lengkap }}</td>
                </tr>
                <tr>
                    <td class="label">Negara Asal</td>
                    <td>: {{ $item->negara_asal }}</td>
                </tr>
                <tr>
                    <td class="label">Nomor Paspor</td>
                    <td>: {{ $item->nomor_paspor }}</td>
                </tr>
                <tr>
                    <td class="label">Tempat/Tgl Lahir</td>
                    <td>: {{ $item->tempat_lahir }}, {{ \Carbon\Carbon::parse($item->tanggal_lahir)->format('d-m-Y') }}</td>
                </tr>
                <tr>
                    <td class="label">Tujuan Kunjungan</td>
                    <td>: {{ $item->tujuan_kunjungan }}</td>
                </tr>
                <tr>
                    <td class="label">Sponsor/Penjamin</td>
                    <td>: {{ $item->sponsor ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">Alamat di Indonesia</td>
                    <td>: {{ $item->tempat_tinggal }}</td>
                </tr>
                <tr>
                    <td class="label">Berlaku Izin s/d</td>
                    <td>: <strong>{{ \Carbon\Carbon::parse($item->masa_berlaku_izin)->translatedFormat('d F Y') }}</strong></td>
                </tr>
            </table>
        </div>
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