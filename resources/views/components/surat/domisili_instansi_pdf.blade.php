<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Surat Keterangan Domisili Masjid</title>
    <style>
        body {
            font-family: 'Times New Roman', serif;
            font-size: 12pt;
            margin: 1.5cm;
        }

        .center {
            text-align: center;
        }

        .indent {
            text-indent: 40px;
        }

        .signature {
            width: 40%;
            margin-left: auto;
            margin-top: 50px;
            text-align: left;
        }

        .signature p:last-child {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            padding: 2px 0;
            vertical-align: top;
        }

        h3,
        p {
            margin: 5px 0;
        }
    </style>
</head>

<body>

    <x-surat.kop_surat />

    <div class="kode-desa">
        No. Kode Desa/Kelurahan: 33.13.13.2007
    </div>

    <div class="center">
        <h3><u>SURAT KETERANGAN DOMISILI MASJID</u></h3>
        <p>Nomor: 470 / {{ $nomor ?? '___' }} / {{ $bulan ?? 'VIII' }} / {{ $tahun ?? '2025' }}</p>
    </div>

    <p class="indent">Yang bertanda tangan di bawah ini Kepala Desa Jeruksawit, Kecamatan Gondangrejo, Kabupaten
        Karanganyar, menerangkan bahwa:</p>

    <table>
        <tr>
            <td width="180">Nama Masjid</td>
            <td>: {{ $nama_masjid ?? 'Masjid Nurul Huda' }}</td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>: {{ $alamat_masjid ?? 'Jeruksawit RT 01 RW 01, Kecamatan Gondangrejo' }}</td>
        </tr>
    </table>

    <p class="indent">Adalah benar berdomisili di wilayah Desa Jeruksawit, Kecamatan Gondangrejo, Kabupaten Karanganyar.
    </p>

    <p>Demikian surat keterangan ini dibuat untuk dipergunakan sebagaimana mestinya.</p>

    <div class="signature">
        <p>Jeruksawit, {{ $tanggal ?? '03 Maret 2025' }}</p>
        <p>Kepala Desa Jeruksawit</p>
        <br><br><br>
        <p><strong>{{ $nama_kepala ?? 'MIDI' }}</strong></p>
    </div>

</body>

</html>
