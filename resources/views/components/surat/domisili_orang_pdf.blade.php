<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Surat Keterangan Orang yang Sama</title>
    <style>
        body {
            font-family: 'Times New Roman', serif;
            font-size: 12pt;
            margin: 0;
            /* <--- Penting! */
            padding: 0;
        }

        .page {
            margin: 1cm 1.2cm;
            /* Kiri & Kanan: 1.2cm, Atas & Bawah: 1cm */
        }

        p {
            margin: 2pt 0;
            line-height: 1.3;
        }

        .center {
            text-align: center;
        }

        .left {
            text-align: left;
        }

        .header {
            text-align: center;
            border-bottom: 3px double black;
            padding-bottom: 5px;
            margin-bottom: 10px;
        }

        .header-title {
            font-size: 15pt;
            font-weight: bold;
        }

        .header-subtitle {
            font-size: 18pt;
            font-weight: bold;
        }

        .header-info {
            font-style: italic;
            font-size: 12pt;
        }

        .kode-desa {
            margin-top: 5px;
            text-align: left;
            font-weight: bold;
        }

        .indent {
            text-indent: 40px;
        }

        .signature {
            width: 40%;
            margin-left: auto;
            margin-top: 50px;
            text-align: left;
            display: block;
        }


        table {
            border-collapse: collapse;
            width: 100%;
        }

        table td {
            vertical-align: top;
            padding: 2px 0;
        }

            {
            page-break-before: avoid !important;
            page-break-inside: avoid !important;
            page-break-after: avoid !important;
            box-sizing: border-box;
        }
    </style>
</head>

<body>
    <div class="page">
        <x-surat.kop_surat />

        <div class="kode-desa">
            No. Kode Desa/Kelurahan: 33.13.13.2007
        </div>

        <div class="center">
            <h3><u>SURAT KETERANGAN DOMISILI</u></h3>
            <p>Nomor: {{ $nomor ?? '474 / 047 / II / 2025' }}</p>
        </div>

        <div class="content">
            <p>Yang bertanda tangan di bawah ini menerangkan bahwa:</p>

            <table>
                <tr>
                    <td width="200px">1. Nama</td>
                    <td>: {{ $nama ?? 'TRIYONO' }}</td>
                </tr>
                <tr>
                    <td>2. Tempat, Tanggal Lahir</td>
                    <td>: {{ $ttl ?? 'Karanganyar, 15-05-1993' }}</td>
                </tr>
                <tr>
                    <td>3. Kewarganegaraan & Agama</td>
                    <td>: {{ $kewarganegaraan ?? 'Indonesia' }} & {{ $agama ?? 'Islam' }}</td>
                </tr>
                <tr>
                    <td>4. Pekerjaan</td>
                    <td>: {{ $pekerjaan ?? 'Karyawan Swasta' }}</td>
                </tr>
                <tr>
                    <td>5. Tempat Tinggal</td>
                    <td>: {{ $alamat ?? 'Kedunggong, RT.003/002, Desa Jeruksawit, Kec. Gondangrejo' }}</td>
                </tr>
                <tr>
                    <td>6. Status</td>
                    <td>: {{ $status ?? '-' }}</td>
                </tr>
                <tr>
                    <td>7. Surat Bukti</td>
                    <td>: KTP: {{ $ktp ?? '3313131505930003' }}<br> &nbsp;&nbsp;&nbsp;KK :
                        {{ $kk ?? '3313132212220006' }}</td>
                </tr>
                <tr>
                    <td>8. Keperluan</td>
                    <td>: {{ $keperluan ?? 'Mengurus surat SKCK ke POLSEK Gondangrejo' }}</td>
                </tr>
                <tr>
                    <td>9. Mulai Berlaku</td>
                    <td>: {{ $mulai ?? '12-06-2025' }} s/d {{ $berakhir ?? '12-07-2025' }}</td>
                </tr>
                <tr>
                    <td>10. Keterangan Lain-lain</td>
                    <td>: Orang tersebut benar warga kami yang berkelakuan dan beradat istiadat baik.</td>
                </tr>
            </table>

            <br>
            <p>Demikian harap menjadikan maklum bagi yang berkepentingan.</p>
        </div>

        <br><br>
        <table class="signature-table" width="100%">
            <tr>
                <td width="50%">
                    <p>Tanda Tangan Pemegang</p>
                    <br><br><br>
                    <p><strong>{{ $nama ?? 'TRIYONO' }}</strong></p>
                </td>
                <td width="50%">
                    <p>Jeruksawit, {{ $tanggal ?? '12 Juni 2025' }}<br>
                        Kepala Desa Jeruksawit</p>
                    <br><br><br>
                    <p><strong>{{ $nama_kepala ?? 'MIDI' }}</strong></p>
                </td>
            </tr>
        </table>
    </div>
</body>

</html>
