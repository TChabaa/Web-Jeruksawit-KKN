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
        <h3><u>SURAT BELUM NIKAH</u></h3>
        <p>Nomor: { $nomor ?? '___' } / { $bulan ?? 'VIII' } / { $tahun ?? '2025' }</p>
    </div>

    <div class="content">
        <p class="indent">No.Kode Desa/Kelurahan</p>
        <p class="indent">33.13.13.2007</p>
        <p class="indent">SURAT KETERANGAN BELUM MENIKAH</p>
        <p class="indent">Nomor : 474 / 173 / VI / 2025</p>
        <p class="indent">Yang bertanda tangan dibawah ini :</p>
        <p class="indent">Nama : MIDI</p>
        <p class="indent">Jabatan : Kepala Desa Jeruksawit</p>
        <p class="indent">Alamat : Kantor Kepala Desa Jeruksawit, Kecamatan Gondangrejo, Kabupaten Karanganyar</p>
        <p class="indent">Menerangkan Bahwa :</p>
        <p class="indent">Nama : IIN AYUIKA ASPIRANI</p>
        <p class="indent">Tempat Tanggal Lahir : Surakarta, 11-11-1998</p>
        <p class="indent">Agama : Islam</p>
        <p class="indent">Pekerjaan : Karyawan Swasta</p>
        <p class="indent">Status : Belum Kawin</p>
        <p class="indent">Alamat : Perumhan Taman Permata Regency Blok B16, Desa Jeruksawit,</p>
        <p class="indent">Kec.Gondangrejo</p>
        <p class="indent">No.NIK / KK : 3372045111960006 / 3372041907210008</p>
        <p class="indent">Keperluan : Menerangkan bahwa orang tersebut sampai saat ini benar-benar belum</p>
        <p class="indent">Menikah.</p>
        <p class="indent">Surat keterangan ini di buat berdasarkan data yang tercantum di Kartu Identitsas</p>
        <p class="indent">KTP maupun Kartu KK, dan pengakuan yang bersangkutan</p>
        <p class="indent">Kegunaan : Surat Keterangan ini di buat untuk keperluan Persyaratan pengajuan pinjaman</p>
        <p class="indent">KUR</p>
    </div>

    <div class="signature">
        <p style="margin-bottom: 0;">Jeruksawit, { $tanggal ?? '06 August 2025' }</p>
        <p style="margin-top: 0;">Kepala Desa Jeruksawit</p>
        <br><br><br>
        <p><strong>{ $nama_kepala ?? 'MIDI' }</strong></p>
    </div>
</body>

</html>
