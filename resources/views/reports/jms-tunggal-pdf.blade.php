<!DOCTYPE html>
<html>

<head>
    <title>Laporan JMS - {{ $item->nama_sekolah }}</title>
    <style>
        @page {
            margin: 1cm;
        }

        body {
            font-family: 'Times New Roman', serif;
            font-size: 12pt;
            line-height: 1.4;
            color: #000;
        }

        /* Kop Surat */
        .header {
            text-align: center;
            border-bottom: 3px double #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
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

        .logo {
            float: left;
            width: 70px;
            margin-bottom: -70px;
        }

        /* Judul */
        .title-doc {
            text-align: center;
            font-weight: bold;
            text-decoration: underline;
            margin: 20px 0;
            text-transform: uppercase;
        }

        /* Isi Laporan */
        .info-table {
            width: 100%;
            margin-bottom: 15px;
        }

        .info-table td {
            padding: 3px;
            vertical-align: top;
        }

        .label {
            font-weight: bold;
            width: 25%;
        }

        .content-section {
            text-align: justify;
            margin-bottom: 20px;
        }

        .section-title {
            font-weight: bold;
            margin-bottom: 5px;
        }

        /* Dokumentasi */
        .photo-box {
            text-align: center;
            margin-bottom: 20px;
            page-break-inside: avoid;
        }

        .photo-box img {
            max-width: 400px;
            max-height: 280px;
            border: 1px solid #000;
        }

        /* Perbaikan Tanda Tangan Menggunakan Tabel */
        .ttd-table {
            width: 100%;
            margin-top: 20px;
            border: none;
            /* Memaksa tabel tidak boleh pecah halaman */
            page-break-inside: avoid;
        }

        .ttd-table td {
            border: none;
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

    <div class="title-doc">LAPORAN KEGIATAN JAKSA MASUK SEKOLAH (JMS)</div>

    <table class="info-table">
        <tr>
            <td class="label">Hari / Tanggal</td>
            <td width="3%">:</td>
            <td>{{ \Carbon\Carbon::parse($item->tanggal_kegiatan)->translatedFormat('l, d F Y') }}</td>
        </tr>
        <tr>
            <td class="label">Sekolah</td>
            <td>:</td>
            <td>{{ $item->nama_sekolah }}</td>
        </tr>
        <tr>
            <td class="label">Materi</td>
            <td>:</td>
            <td>{{ $item->materi }}</td>
        </tr>
        <tr>
            <td class="label">Peserta</td>
            <td>:</td>
            <td>{{ $item->jumlah_peserta }} Siswa/i</td>
        </tr>
        <tr>
            <td class="label">Narasumber</td>
            <td>:</td>
            <td>{{ $item->narasumber }}</td>
        </tr>
    </table>

    <div class="content-section">
        <div class="section-title">RINGKASAN KEGIATAN :</div>
        {{ $item->keterangan ?? 'Telah dilaksanakan kegiatan penyuluhan hukum Jaksa Masuk Sekolah (JMS) di '.$item->nama_sekolah.' dengan tertib dan lancar.' }}
    </div>

    @if($item->foto_kegiatan)
    <div class="photo-box">
        <div class="section-title">DOKUMENTASI KEGIATAN</div>
        <img src="{{ public_path('storage/' . $item->foto_kegiatan) }}">
    </div>
    @endif

    <table class="ttd-table">
        <tr>
            <td width="55%"></td>
            <td width="45%">
                Banjarmasin, {{ now()->translatedFormat('d F Y') }}<br>
                <strong>KEPALA SEKSI INTELIJEN,</strong>
                <br><br><br><br><br>
                <u><strong>DIMAS PURNAMA PUTRA, S.H., M.H.</strong></u><br>
                Jaksa Madya NIP. 19850101 201001 1 001
            </td>
        </tr>
    </table>
</body>

</html>