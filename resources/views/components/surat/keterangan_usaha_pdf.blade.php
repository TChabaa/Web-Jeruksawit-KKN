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
        <h3><u>SURAT USAHA</u></h3>
        <p>Nomor: { $nomor ?? '___' } / { $bulan ?? 'VIII' } / { $tahun ?? '2025' }</p>
    </div>

    <div class="content">
        <p class="indent">No.Kode Desa/Kelurahan</p>
        <p class="indent">33.13.13.2007</p>
        <p class="indent">SURAT KETERANGAN USAHA</p>
        <p class="indent">Nomor : 474 / 172 / IV / 2025</p>
        <p class="indent">Yang bertanda tangan di bahwa ini :</p>
        <p class="indent">Nama : MIDI</p>
        <p class="indent">Jabatan : Kepala Desa Jeruksawit, Kec.Gondangrejo</p>
        <p class="indent">Alamat : Kantor Kepala Desa Jeruksawit, Kec.Gondangrejo</p>
        <p class="indent">Menerangkan Bahwa :</p>
        <p class="indent">Nama : SUPARNO</p>
        <p class="indent">Tempat Tanggal Lahir : Karanganyar, 09-11-1971</p>
        <p class="indent">Pekerjaan : Islam</p>
        <p class="indent">Status : Kawin</p>
        <p class="indent">Alamat : Plosokerep, RT 001/001, Desa Jeruksawit</p>
        <p class="indent">Kec. Gondangrejo, Kab.Karanganyar</p>
        <p class="indent">No.NIK / KK : 3313130911710002 / -</p>
        <p class="indent">Mulai Usaha : Tahun 2018 s/d Sekarang</p>
        <p class="indent">Orang tersebut saat ini benar mempunyai usaha PETERNAKAN KAMBING di Plosokerep, RT 001/001,
            Desa Jeruksawit, Kec. Gondangrejo. Demikian Surat keterangan ini diberikan untuk dipergunakan sebagaimana
            mestinya</p>
    </div>

    <div class="signature">
        <p style="margin-bottom: 0;">Jeruksawit, { $tanggal ?? '06 August 2025' }</p>
        <p style="margin-top: 0;">Kepala Desa Jeruksawit</p>
        <br><br><br>
        <p><strong>{ $nama_kepala ?? 'MIDI' }</strong></p>
    </div>
</body>

</html>
