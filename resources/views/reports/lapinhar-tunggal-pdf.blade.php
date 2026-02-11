<!DOCTYPE html>
<html>

<head>
    <title>Laporan Informasi Harian Satuan</title>
    <style>
        body {
            font-family: 'Times New Roman', serif;
            font-size: 12pt;
            line-height: 1.5;
            padding: 20px;
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

        .ref-box {
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .ref-box table {
            border: none;
            width: 100%;
        }

        .ref-box td {
            border: none;
            padding: 2px;
            vertical-align: top;
        }

        .title-doc {
            text-align: center;
            font-weight: bold;
            text-decoration: underline;
            margin-bottom: 20px;
        }

        .section-title {
            font-weight: bold;
            margin-top: 15px;
            text-decoration: underline;
        }

        .section-content {
            text-align: justify;
            margin-left: 20px;
            margin-top: 5px;
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

    <div class="ref-box">
        <table>
            <tr>
                <td width="15%">Nomor</td>
                <td width="2%">:</td>
                <td>{{ $item->nomor_surat }}</td>
            </tr>
            <tr>
                <td>Sifat</td>
                <td>:</td>
                <td>{{ strtoupper($item->status) }}</td>
            </tr>
            <tr>
                <td>Lampiran</td>
                <td>:</td>
                <td>-</td>
            </tr>
            <tr>
                <td>Perihal</td>
                <td>:</td>
                <td><strong>LAPORAN INFORMASI HARIAN (LAPINHAR) BIDANG {{ strtoupper($item->bidang) }}</strong></td>
            </tr>
        </table>
    </div>

    <div class="title-doc">LAPORAN INFORMASI</div>

    <div class="section-title">I. PERISTIWA / FAKTA-FAKTA :</div>
    <div class="section-content">
        {{ $item->peristiwa }}
    </div>

    <div class="section-title">II. SUMBER INFORMASI :</div>
    <div class="section-content">
        Bahwa informasi tersebut diperoleh melalui : {{ $item->sumber_informasi }}
    </div>

    <div class="section-title">III. PENDAPAT / ANALISA :</div>
    <div class="section-content">
        {{ $item->pendapat }}
    </div>

    <div class="section-title">IV. SARAN / TINDAK LANJUT :</div>
    <div class="section-content">
        Diharapkan pimpinan dapat mempertimbangkan langkah-langkah strategis lebih lanjut guna mengantisipasi potensi kerawanan yang ada.
    </div>

    <div class="footer">
        <div class="ttd">
            <p>Banjarmasin, {{ \Carbon\Carbon::parse($item->tanggal_surat)->translatedFormat('d F Y') }}</p>
            <p><strong>KEPALA SEKSI INTELIJEN</strong></p>
            <br><br><br><br>
            <p><u><strong>DIMAS PURNAMA PUTRA, S.H., M.H.</strong></u></p>
            <p>Jaksa Madya NIP. 19850101 201001 1 001</p>
        </div>
    </div>
</body>

</html>