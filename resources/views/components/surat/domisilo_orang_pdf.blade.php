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

        .indent {
            text-indent: 40px;
        }

        .kode-desa {
            margin-top: 5px;
            text-align: left;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table td {
            padding: 2px 0;
            vertical-align: top;
        }

        .signature {
            width: 40%;
            margin-left: auto;
            text-align: left;
            margin-top: 60px;
        }

        .signature p:last-child {
            text-align: center;
        }
    </style>
</head>
<body>

    <x-surat.kop_surat />

    <div class="kode-desa">
        Nomor: 300 / {{ $nomor ?? '174' }} / VI / 33.13.13.2007 / {{ $tahun ?? '2025' }}
    </div>

    <br>
    <div class="center">
        <h3><u>SURAT PENGANTAR SKCK</u></h3>
    </div>

    <p>Yang bertanda tangan di bawah ini menerangkan bahwa:</p>

    <table>
        <tr>
            <td width="200px">1. Nama</td>
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
            <td>: KTP: {{ $ktp ?? '3313131505930003' }}<br> &nbsp; KK : {{ $kk ?? '3313132212220006' }}</td>
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

    <p>Demikian harap menjadikan maklum bagi yang berkepentingan.</p>

    <br><br>
    <table width="100%">
        <tr>
            <td width="50%" class="center">
                <p>Tanda Tangan Pemegang</p><br><br><br>
                <p><strong>{{ $nama ?? 'TRIYONO' }}</strong></p>
            </td>
            <td width="50%" class="center">
                <p>Jeruksawit, {{ $tanggal ?? '12 Juni 2025' }}<br>
                    Kepala Desa Jeruksawit</p><br><br><br>
                <p><strong>{{ $nama_kepala ?? 'MIDI' }}</strong></p>
            </td>
        </tr>
    </table>

</body>
</html>
