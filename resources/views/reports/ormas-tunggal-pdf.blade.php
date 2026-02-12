<!DOCTYPE html>
<html>

<head>
    <title>Profil Ormas - {{ $item->nama_organisasi }}</title>
    <style>
        body {
            font-family: 'Times New Roman', serif;
            font-size: 12pt;
            line-height: 1.4;
            margin: 1cm 2cm;
        }

        /* HEADER STYLE */
        .header {
            text-align: center;
            border-bottom: 3px double #000;
            padding-bottom: 10px;
            margin-bottom: 25px;
            position: relative;
        }

        .logo-instansi {
            position: absolute;
            left: 0;
            top: 0;
            width: 75px;
            height: auto;
        }

        .header h3 {
            margin: 0;
            font-size: 14pt;
            text-transform: uppercase;
        }

        .header h2 {
            margin: 5px 0 0 0;
            font-size: 16pt;
            text-transform: uppercase;
        }

        .header p {
            margin: 0;
            font-size: 10pt;
            font-style: italic;
        }

        /* TITLE STYLE */
        .title-doc {
            text-align: center;
            font-weight: bold;
            text-decoration: underline;
            margin-bottom: 30px;
            font-size: 14pt;
            text-transform: uppercase;
        }

        /* LAYOUT TABLE (PEMISAH KIRI & KANAN) */
        .layout-table {
            width: 100%;
            border-collapse: collapse;
            border: none;
        }

        .col-data {
            vertical-align: top;
            padding-right: 15px;
        }

        .col-photo {
            width: 140px;
            /* Lebar area foto fix agar tidak tertabrak */
            vertical-align: top;
            text-align: center;
        }

        /* LOGO BOX STYLE */
        .logo-box {
            width: 130px;
            height: 160px;
            border: 1px solid #000;
            padding: 5px;
            display: block;
            margin: 0 auto;
            text-align: center;
        }

        .logo-box img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        .logo-placeholder {
            margin-top: 60px;
            font-size: 9pt;
            color: #555;
            font-weight: bold;
        }

        /* DATA TABLE STYLE */
        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table td {
            padding: 4px 0;
            vertical-align: top;
        }

        .label {
            font-weight: bold;
            width: 32%;
            white-space: nowrap;
        }

        .separator {
            width: 3%;
            text-align: center;
        }

        .value {
            text-align: justify;
        }

        /* FOOTER STYLE */
        .footer {
            margin-top: 50px;
            width: 100%;
        }

        .ttd-box {
            float: right;
            width: 45%;
            text-align: center;
        }
    </style>
</head>

<body>

    <div class="header">
        <img src="{{ public_path('img/logo-kejaksaan.png') }}" class="logo-instansi">
        <h3>KEJAKSAAN REPUBLIK INDONESIA</h3>
        <h2>KEJAKSAAN NEGERI BANJARMASIN</h2>
        <p>Jl. Brigjend H. Hasan Basry No. 3, Banjarmasin, Kalimantan Selatan</p>
    </div>

    <div class="title-doc">LEMBAR PROFIL ORGANISASI KEMASYARAKATAN</div>

    <table class="layout-table">
        <tr>
            <td class="col-data">
                <table class="data-table">
                    <tr>
                        <td class="label">Nama Organisasi</td>
                        <td class="separator">:</td>
                        <td class="value"><strong>{{ strtoupper($item->nama_organisasi) }}</strong></td>
                    </tr>
                    <tr>
                        <td class="label">Bentuk Organisasi</td>
                        <td class="separator">:</td>
                        <td class="value">{{ $item->bentuk_organisasi }}</td>
                    </tr>
                    <tr>
                        <td class="label">Nama Pimpinan</td>
                        <td class="separator">:</td>
                        <td class="value">{{ $item->nama_pimpinan }}</td>
                    </tr>
                    <tr>
                        <td class="label">Alamat Sekretariat</td>
                        <td class="separator">:</td>
                        <td class="value">{{ $item->alamat_sekretariat }}</td>
                    </tr>
                    <tr>
                        <td class="label">Status Legalitas</td>
                        <td class="separator">:</td>
                        <td class="value">{{ $item->status_legalitas }}</td>
                    </tr>
                    <tr>
                        <td class="label">Nomor SK / AHU</td>
                        <td class="separator">:</td>
                        <td class="value">{{ $item->nomor_sk ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Kegiatan Utama</td>
                        <td class="separator">:</td>
                        <td class="value">{{ $item->kegiatan_utama }}</td>
                    </tr>
                    <tr>
                        <td class="label">Afiliasi</td>
                        <td class="separator">:</td>
                        <td class="value">{{ $item->afiliasi ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Jumlah Anggota</td>
                        <td class="separator">:</td>
                        <td class="value">{{ $item->jumlah_anggota ? $item->jumlah_anggota . ' Orang' : '-' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Status Pengawasan</td>
                        <td class="separator">:</td>
                        <td class="value" style="text-transform: uppercase;">
                            <strong>{{ $item->status_pengawasan }}</strong>
                        </td>
                    </tr>
                </table>
            </td>

            <td class="col-photo">
                <div class="logo-box">
                    @if($item->foto_lambang)
                    <img src="{{ public_path('storage/' . $item->foto_lambang) }}">
                    @else
                    <div class="logo-placeholder">TANPA LOGO</div>
                    @endif
                </div>
            </td>
        </tr>
    </table>

    <div class="footer">
        <div class="ttd-box">
            <p>Banjarmasin, {{ now()->translatedFormat('d F Y') }}</p>
            <p><strong>KEPALA SEKSI INTELIJEN</strong></p>
            <br><br><br><br>
            <p style="text-decoration: underline; font-weight: bold;">BUDI SANTOSO, S.H., M.H.</p>
            <p>Jaksa Madya NIP. 198501012010121001</p>
        </div>
    </div>

</body>

</html>