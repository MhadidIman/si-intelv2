<!DOCTYPE html>
<html>

<head>
    <title>Laporan Informasi Harian</title>
    <style>
        body {
            font-family: 'Times New Roman', serif;
            font-size: 12pt;
            line-height: 1.5;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 3px double #000;
            padding-bottom: 10px;
            position: relative;
        }

        .logo {
            position: absolute;
            left: 0;
            top: 0;
            width: 80px;
        }

        .header h3 {
            margin: 0;
            font-size: 14pt;
            text-transform: uppercase;
        }

        .header h2 {
            margin: 0;
            font-size: 16pt;
            font-weight: bold;
            text-transform: uppercase;
        }

        .header p {
            margin: 0;
            font-size: 10pt;
        }

        .content-title {
            text-align: center;
            font-weight: bold;
            text-decoration: underline;
            margin-bottom: 20px;
            text-transform: uppercase;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
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

        .footer-table {
            margin-top: 30px;
            border: none;
        }

        .footer-table td {
            border: none;
        }

        .ttd {
            width: 40%;
            text-align: center;
            float: right;
        }
    </style>
</head>

<body>
    <div class="header">
        <img src="{{ public_path('img/logo-kejaksaan.png') }}" class="logo">
        <h3>KEJAKSAAN REPUBLIK INDONESIA</h3>
        <h3>KEJAKSAAN TINGGI KALIMANTAN SELATAN</h3>
        <h2>KEJAKSAAN NEGERI BANJARMASIN</h2>
        <p>Jl. Brig Jend. H. Hasan Basri No.3, Kayu Tangi, Banjarmasin</p>
    </div>

    <div class="content-title">REKAPITULASI LAPORAN INFORMASI HARIAN</div>

    <table>
        <thead>
            <tr>
                <th width="5%">NO</th>
                <th width="20%">TANGGAL / NO SURAT</th>
                <th width="15%">BIDANG</th>
                <th>PERISTIWA / INFORMASI</th>
                <th width="15%">STATUS</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $index => $item)
            <tr>
                <td align="center">{{ $index + 1 }}</td>
                <td>
                    {{ \Carbon\Carbon::parse($item->tanggal_surat)->format('d-m-Y') }}<br>
                    <small>{{ $item->nomor_surat }}</small>
                </td>
                <td align="center">{{ strtoupper($item->bidang) }}</td>
                <td>
                    <strong>Peristiwa:</strong> {{ $item->peristiwa }}<br><br>
                    <strong>Analisa:</strong> {{ $item->pendapat }}
                </td>
                <td align="center">{{ strtoupper($item->status_verifikasi) }}</td>
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