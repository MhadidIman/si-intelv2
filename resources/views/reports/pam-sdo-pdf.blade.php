<!DOCTYPE html>
<html>

<head>
    <title>Rekapitulasi Giat PAM SDO</title>
    <style>
        body {
            font-family: 'Times New Roman', serif;
            font-size: 11pt;
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
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            vertical-align: top;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-align: center;
        }

        .ttd {
            float: right;
            width: 40%;
            text-align: center;
            margin-top: 30px;
        }
    </style>
</head>

<body>
    <div class="header">
        <img src="{{ public_path('img/logo-kejaksaan.png') }}" class="logo">
        <h3>KEJAKSAAN REPUBLIK INDONESIA</h3>
        <h2>KEJAKSAAN NEGERI BANJARMASIN</h2>
    </div>

    <div class="title-doc">REKAPITULASI PENGAMANAN SUMBER DAYA ORGANISASI (PAM SDO)</div>

    <table>
        <thead>
            <tr>
                <th width="5%">NO</th>
                <th width="15%">TANGGAL</th>
                <th width="25%">NAMA KEGIATAN / LOKASI</th>
                <th width="20%">KATEGORI / PELAKSANA</th>
                <th>KETERANGAN / HASIL</th>
                <th width="10%">STATUS</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $index => $item)
            <tr>
                <td align="center">{{ $index + 1 }}</td>
                <td align="center">{{ \Carbon\Carbon::parse($item->tanggal_kegiatan)->format('d-m-Y') }}</td>
                <td>
                    <strong>{{ $item->nama_kegiatan }}</strong><br>
                    <small>Lokasi: {{ $item->lokasi }}</small>
                </td>
                <td>
                    {{ $item->kategori_pam }}<br>
                    <small>Oleh: {{ $item->pelaksana }}</small>
                </td>
                <td>{{ $item->keterangan ?? '-' }}</td>
                <td align="center"><strong>{{ strtoupper($item->status) }}</strong></td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="ttd">
        <p>Banjarmasin, {{ now()->translatedFormat('d F Y') }}</p>
        <p><strong>KEPALA SEKSI INTELIJEN</strong></p>
        <br><br><br><br>
        <p><u><strong>BUDI SANTOSO, S.H., M.H.</strong></u></p>
        <p>Jaksa Madya NIP. 198501012010121001</p>
    </div>
</body>

</html>