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
        <h3><u>SURAT PINDAH KELUAR</u></h3>
        <p>Nomor: { $nomor ?? '___' } / { $bulan ?? 'VIII' } / { $tahun ?? '2025' }</p>
    </div>

    <div class="content">
        <p class="indent">No.Kode Desa/Kelurahan</p>
        <p class="indent">33.13.13.2007</p>
        <p class="indent">SURAT PENGANTAR PINDAH KELUAR</p>
        <p class="indent">Nomor : 475 / 208 / VII / 2025</p>
        <p class="indent">Yang bertandatangan dibawah ini menerangkan bahwa :</p>
        <p class="indent">Nama Lengkap : ISNA</p>
        <p class="indent">Nomor KK : 3313132605080001</p>
        <p class="indent">Nomor Induk Penduduk ( NIK ) : 3313130607830002</p>
        <p class="indent">Jenis Kelamin : LAKI-LAKI</p>
        <p class="indent">Tempat & Tgl Lahir : KARANGANYAR,06-07-1983</p>
        <p class="indent">Kewarganegaraan : INDONESIA</p>
        <p class="indent">Agama : ISLAM</p>
        <p class="indent">Status Perkawinan : KAWIN</p>
        <p class="indent">Alamat Terakhir : KEDUNGGONG, RT.004/002</p>
        <p class="indent">Dusun : KEDUNGGONG</p>
        <p class="indent">Desa / Kelurahan : JERUKSAWIT</p>
        <p class="indent">Kecamatan : GONDANGREJo</p>
        <p class="indent">Kabupaten : KARANGANYAR</p>
        <p class="indent">Kode POS : 57773</p>
        <p class="indent">Nama Kepala Keluarga : ISNA</p>
        <p class="indent">Nomor Kartu Keluarga : 3313132605080001</p>
        <p class="indent">. Alamat Tujuan Pindah : DADAPAN, RT.006/007</p>
        <p class="indent">Dusun : DADAPAN</p>
        <p class="indent">Desa / Kelurahan : JATIKUWUNG</p>
        <p class="indent">Kecamatan : GONDANGREJO</p>
        <p class="indent">Kabupaten/Kota : KARANGANYAR</p>
        <p class="indent">Kode Pos : -</p>
        <p class="indent">Provinsi : JAWA TENGAH</p>
        <p class="indent">Alasan Pindah : MENIKAH</p>
        <p class="indent">Tanggal Pindah : 14-07-2025</p>
        <p class="indent">Dasar Pindah : -</p>
        <p class="indent">Keluarga yang Pindah : 1</p>
        <p class="indent">Keterangan SHDK 01. Kepala Keluarga 03.Istri 05.Menantu 07.Orang Tua. 09.Famili Lain
            11.Lainnya
        </p>
        <p class="indent">02.Suami 04.Anak 06.Cucu 08.Mertua 10.Pembantu</p>
        <p class="indent">Demikian untuk menjadikan periksa</p>
        <p class="indent">Karanganyar,14-07-2025</p>
        <p class="indent">Pemohon Kepala Desa Jeruksawit</p>
        <p class="indent">ISNA</p>
        <p class="indent">MIDI</p>
        <p class="indent">SUTRISNO</p>
    </div>

    <div class="signature">
        <p style="margin-bottom: 0;">Jeruksawit, { $tanggal ?? '06 August 2025' }</p>
        <p style="margin-top: 0;">Kepala Desa Jeruksawit</p>
        <br><br><br>
        <p><strong>{ $nama_kepala ?? 'MIDI' }</strong></p>
    </div>
</body>

</html>
