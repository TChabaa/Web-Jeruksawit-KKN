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
        <h3><u>SURAT DUPLIKAT KELAHIRAN</u></h3>
        <p>Nomor: { $nomor ?? '___' } / { $bulan ?? 'VIII' } / { $tahun ?? '2025' }</p>
    </div>

    <div class="content">
        <p class="indent">SURAT KELAHIRAN</p>
        <p class="indent">No.472.11/001/IX/1989</p>
        <p class="indent">Yang bertanda tangan di bawahb ini</p>
        <p class="indent">Menerangkan bahwa pada :</p>
        <p class="indent">Hari : JUMAT PON</p>
        <p class="indent">Tanggal : 22-09-1989</p>
        <p class="indent">Di : Desa Jeruksawit</p>
        <p class="indent">Telah lahir seorang anak LAKI-LAKI</p>
        <p class="indent">Bernama:</p>
        <p class="indent">MITRO DIKROMO / SIYUN</p>
        <p class="indent">Dari seorang ibu bernama:</p>
        <p class="indent">SARMI</p>
        <p class="indent">Alamat :Plosorejo, rt.003/003</p>
        <p class="indent">Desa Jeruksawit</p>
        <p class="indent">Istri dari : SENEN</p>
        <p class="indent">Penolong : Tandur ( Dukun anak )</p>
        <p class="indent">Surat keterangan ini dibuat atas</p>
        <p class="indent">Dasar yang sebenarnya.</p>
        <p class="indent">Jeruksawit,25-02-2025</p>
        <p class="indent">Kepala Desa Jeruksawit</p>
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
