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
        <h3><u>SURAT KEMATIAN</u></h3>
        <p>Nomor: { $nomor ?? '___' } / { $bulan ?? 'VIII' } / { $tahun ?? '2025' }</p>
    </div>

    <div class="content">
        <p class="indent">SURAT KEMATIAN</p>
        <p class="indent">Nomor : 474.3/23 / III/ 2016</p>
        <p class="indent">Yang bertanda tangan dibawah ini</p>
        <p class="indent">Kepala Desa Jeruksawit menerangkan</p>
        <p class="indent">bahwa:</p>
        <p class="indent">Nama : KARTONO</p>
        <p class="indent">NIK : -</p>
        <p class="indent">Jenis Kelamin : LAKI-LAKI</p>
        <p class="indent">Alamat : MOJOREJO,</p>
        <p class="indent">RT.002/006</p>
        <p class="indent">DESA JERUKSAWIT</p>
        <p class="indent">Umur : 58 TAHUN</p>
        <p class="indent">Telah Meninggal Dunia pada :</p>
        <p class="indent">Hari : KAMIS</p>
        <p class="indent">Tanggal : 24 FEBRUARI 2000</p>
        <p class="indent">Di : RUMAH</p>
        <p class="indent">Disebabkan karena : SAKIT TUA</p>
        <p class="indent">Surat keterangan ini dibuat atas dasar</p>
        <p class="indent">yang sebenarnya.</p>
        <p class="indent">Nama yang melapor: MULYONO</p>
        <p class="indent">Hub. Dengan yang mati : ANAK</p>
        <p class="indent">Jeruksawit, 21-05-2024</p>
        <p class="indent">Kepala Desa Jeruksawi</p>
        <p class="indent">MIDI</p>
    </div>

    <div class="signature">
        <p style="margin-bottom: 0;">Jeruksawit, { $tanggal ?? '06 August 2025' }</p>
        <p style="margin-top: 0;">Kepala Desa Jeruksawit</p>
        <br><br><br>
        <p><strong>{ $nama_kepala ?? 'MIDI' }</strong></p>
    </div>
</body>

</html>
