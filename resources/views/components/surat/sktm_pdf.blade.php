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
        <h3><u>SURAT SKTM</u></h3>
        <p>Nomor: { $nomor ?? '___' } / { $bulan ?? 'VIII' } / { $tahun ?? '2025' }</p>
    </div>

    <div class="content">
        <p class="indent">No.Kode Desa/Kelurahan</p>
        <p class="indent">33.13.13.2007</p>
        <p class="indent">SURAT KETERANGAN TIDAK MAMPU</p>
        <p class="indent">Nomor : 474 / 047 / II / 2025</p>
        <p class="indent">Yang bertanda tangan dibawah ini :</p>
        <p class="indent">Nama : MIDI</p>
        <p class="indent">Jabatan : Kepala Desa Jeruksawit</p>
        <p class="indent">Alamat : Kantor Kepala Desa Jeruksawit, Kecamatan Gondangrejo, Kabupaten Karanganyar</p>
        <p class="indent">Menerangkan Bahwa :</p>
        <p class="indent">Nama : SRI LESTARI</p>
        <p class="indent">Tempat Tanggal Lahir : Karanganyar, 29-01-1973</p>
        <p class="indent">NIK / NO.KK : 3313136901730001 / 372051406120003</p>
        <p class="indent">Pekerjaan : Karyawan Swasta</p>
        <p class="indent">Status : Kawin</p>
        <p class="indent">Pendidikan : -</p>
        <p class="indent">Alamat : Jurangkambil rt.002/04, , Desa Jeruksawit, Kec.Gondangrejo, Karanganyar</p>
        <p class="indent">Keterangan : Bahwa orang tersebut Benar Warga Penduduk Desa Jeruksawit yang berdomisili</p>
        <p class="indent">dan bertempat tinggal di alamat tersebut diatas dengan</p>
        <p class="indent">Kondisi Ekonomi yang tidak mampu.</p>
        <p class="indent">Demikian Surat keterangan ini diberikan agar dapat dipergunakan sebagai mana mestinya</p>
    </div>

    <div class="signature">
        <p style="margin-bottom: 0;">Jeruksawit, { $tanggal ?? '06 August 2025' }</p>
        <p style="margin-top: 0;">Kepala Desa Jeruksawit</p>
        <br><br><br>
        <p><strong>{ $nama_kepala ?? 'MIDI' }</strong></p>
    </div>
</body>

</html>
