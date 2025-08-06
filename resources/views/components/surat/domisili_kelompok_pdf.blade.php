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
        <h3><u>SURAT DOMISILI ORANG</u></h3>
        <p>Nomor: { $nomor ?? '___' } / { $bulan ?? 'VIII' } / { $tahun ?? '2025' }</p>
    </div>

    <div class="content">
        <p class="indent">No.Kode Desa/Kelurahan</p>
        <p class="indent">33.13.13.2007</p>
        <p class="indent">SURAT KETERANGAN DOMISILI</p>
        <p class="indent">Nomor : 474 / 116 / IV / 2025</p>
        <p class="indent">Yang bertanda tangan bahwa ini Kepala Desa Jeruksawit,Kec.Gondangrejo, Kab.Karanganyar :</p>
        <p class="indent">Nama : MIDI</p>
        <p class="indent">Jabatan : Kepala Desa Jeruksawit</p>
        <p class="indent">Alamat : Kantor Kepala Desa Jeruksawit, Kec.Gondangrejo</p>
        <p class="indent">Menerangkan Bahwa :</p>
        <p class="indent">Nama : MI SUDIRMAN BANYUANYAR</p>
        <p class="indent">Kepala Sekolah : UMIYATUN,S.PdI,M.Pd</p>
        <p class="indent">NIP : 197306162007102002</p>
        <p class="indent">Alamat : Banyuanyar, rt.003/001, Desa Jeruksawit, Kec.Gondangrejo</p>
        <p class="indent">Kab.Karanganyar</p>
        <p class="indent">MI SUDIRMAN BANYUANYAR Tersebut benar keberadaanya di wilayah kami di Dusun Banyuanyar,
            rt.003/001, Desa Jeruksawit Kec.Gondangrejo Kab.Karanganyar</p>
        <p class="indent">Demikian surat keterangan ini dibuat agar digunakan sebagaimana mestinya.</p>
    </div>

    <div class="signature">
        <p style="margin-bottom: 0;">Jeruksawit, { $tanggal ?? '06 August 2025' }</p>
        <p style="margin-top: 0;">Kepala Desa Jeruksawit</p>
        <br><br><br>
        <p><strong>{ $nama_kepala ?? 'MIDI' }</strong></p>
    </div>
</body>

</html>
