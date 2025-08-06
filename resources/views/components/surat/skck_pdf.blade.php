<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Surat Pengantar SKCK</title>
    <style>
        body {
            font-family: 'Times New Roman', serif;
            font-size: 12pt;
            margin: 1.5cm;
        }

        .center {
            text-align: center;
        }

        .left {
            text-align: left;
        }

        .kode-desa {
            margin-top: 10px;
            font-weight: bold;
        }

        .content table {
            width: 100%;
        }

        .content table td {
            vertical-align: top;
            padding: 2px 0;
        }

        .signature-table {
            width: 100%;
            margin-top: 50px;
        }

        .signature-table td {
            vertical-align: top;
            text-align: center;
        }

        .ttd-space {
            height: 80px;
        }
    </style>
</head>

<body>

    <x-surat.kop_surat />

    <div class="kode-desa">
        Nomor: 300 / {{ $nomor ?? '174' }} / VI / 33.13.13.2007 / {{ $tahun ?? '2025' }}
    </div>

    <div class="center">
        <h3><u>SURAT PENGANTAR SKCK</u></h3>
    </div>

    <p>Yang bertandatangan di bawah ini menerangkan bahwa:</p>

    <div class="content">
        <table>
            <tr>
                <td width="200">1. Nama</td>
                <td>: {{ $nama ?? 'TRIYONO' }}</td>
            </tr>
            <tr>
                <td>2. Tempat Tanggal Lahir</td>
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
                <td>: KTP: {{ $ktp ?? '3313131505930003' }} | KK: {{ $kk ?? '3313132212220006' }}</td>
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
                <td>: Orang tersebut benar warga kami yang berkelakuan dan beradat istiadat baik</td>
            </tr>
        </table>

        <br>
        <p>Demikian harap menjadikan maklum yang berkepentingan.</p>

        <br><br>
        <p>Nomor: .....................................</p>
        <p>Tanggal: ...................................</p>
    </div>

    <table class="signature-table">
        <tr>
            <td width="50%">
                <p>Tanda Tangan Pemegang</p>
                <div class="ttd-space"></div>
                <p><strong>{{ $nama ?? 'TRIYONO' }}</strong></p>
            </td>
            <td width="50%">
                <p>Jeruksawit, {{ $tanggal ?? '12 Juni 2025' }}</p>
                <p>Kepala Desa Jeruksawit</p>
                <div class="ttd-space"></div>
                <p><strong>{{ $nama_kepala ?? 'MIDI' }}</strong></p>
            </td>
        </tr>
    </table>

</body>

</html>
