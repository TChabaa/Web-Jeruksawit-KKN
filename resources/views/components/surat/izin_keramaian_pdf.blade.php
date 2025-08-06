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
        <h3><u>SURAT KERAMAIAN</u></h3>
        <p>Nomor: { $nomor ?? '___' } / { $bulan ?? 'VIII' } / { $tahun ?? '2025' }</p>
    </div>

    <div class="content">
        <p class="indent">No.Kode Desa/Kelurahan</p>
        <p class="indent">33.13.13.2007</p>
        <p class="indent">SURAT PENGANTAR IJIN KERAMAIAN</p>
        <p class="indent">Nomor : 330 / 175 / VI /33.13.13.2007/2025</p>
        <p class="indent">Yang bertandatangan dibawah ini menerangkan bahwa :</p>
        <p class="indent">1.Nama : JOKO CHRISTANTO</p>
        <p class="indent">2.Tempat Tanggal Lahir : SURAKARTA, 13 Nvember 1970</p>
        <p class="indent">3.Kewarganegaraan &Agama : Indonesia & Islam</p>
        <p class="indent">4.Pekerjaan : Wira Swasta</p>
        <p class="indent">5.Tempat Tinggal : Jebres Krajan, RT.001 RW.025, Jebres, Jebres, Surakarta,</p>
        <p class="indent">6.Surat Bukti : KTP :33720413117000062 KK :</p>
        <p class="indent">7.Keperluan : Permohonan ijin keramaian dalam acara Hajatan</p>
        <p class="indent">Pernikahan ke Polsek Gondangrejo dengan</p>
        <p class="indent">Hiburan CAMPURSARI LOKALAN</p>
        <p class="indent">8.Tempat : Rumah Sendiri Perum Marison Blok C08, Desa</p>
        <p class="indent">Jeruksawit.</p>
        <p class="indent">9. Hari/Tanggal : Sabtu /14 Juni 2025</p>
        <p class="indent">10.Keterangan Lain-lain : Undangan + 300 orang</p>
        <p class="indent">Demikian harap menjadikan maklum yang berkepentingan</p>
        <p class="indent">Nomor :…………………….</p>
        <p class="indent">Tanggal :…………………….</p>
    </div>

    <div class="signature">
        <p style="margin-bottom: 0;">Jeruksawit, { $tanggal ?? '06 August 2025' }</p>
        <p style="margin-top: 0;">Kepala Desa Jeruksawit</p>
        <br><br><br>
        <p><strong>{ $nama_kepala ?? 'MIDI' }</strong></p>
    </div>
</body>

</html>
