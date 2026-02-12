<!DOCTYPE html>
<html>

<head>
    <title>Rekapitulasi Data DPO</title>
    <style>
        body {
            font-family: 'Times New Roman', serif;
            font-size: 11pt;
            line-height: 1.3;
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
            font-size: 13pt;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            table-layout: fixed;
        }

        th,
        td {
            border: 1px solid black;
            padding: 6px;
            vertical-align: top;
            word-wrap: break-word;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-align: center;
            font-size: 10pt;
        }

        td {
            font-size: 10pt;
        }

        .ttd-container {
            margin-top: 30px;
            width: 100%;
        }

        .ttd {
            float: right;
            width: 40%;
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

    <div class="title-doc">DAFTAR PENCARIAN ORANG (DPO) BIDANG INTELIJEN</div>

    <table>
        <thead>
            <tr>
                <th width="5%">NO</th>
                <th width="20%">NAMA / IDENTITAS</th>
                <th width="25%">KASUS / PASAL</th>
                <th width="15%">STATUS HUKUM</th>
                <th width="20%">CIRI FISIK</th>
                <th width="15%">KETERANGAN</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $index => $item)
            <tr>
                <td align="center">{{ $index + 1 }}</td>
                <td>
                    <strong>{{ strtoupper($item->nama_lengkap) }}</strong><br>
                    <small>{{ $item->tempat_lahir }}, {{ \Carbon\Carbon::parse($item->tanggal_lahir)->format('d-m-Y') }}</small>
                </td>
                <td>{{ $item->kasus }}</td>
                <td align="center">{{ $item->status_hukum }}</td>
                <td>{{ $item->ciri_fisik ?? '-' }}</td>
                <td align="center">
                    <strong>{{ strtoupper($item->status_pencarian) }}</strong>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" align="center">Data DPO Kosong</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="ttd-container">
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