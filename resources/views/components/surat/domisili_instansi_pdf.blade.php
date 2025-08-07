<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Surat Keterangan Belum Nikah</title>
    <style>
        body {
            font-family: 'Times New Roman', serif;
            font-size: 12pt;
            margin: 0;
            padding: 0;
        }

        .page {
            margin: 1cm 1.2cm;
        }

        p {
            margin: 2pt 0;
            line-height: 1.3;
        }

        .center {
            text-align: center;
        }

        .left {
            text-align: left;
        }

        .header {
            text-align: center;
            border-bottom: 3px double black;
            padding-bottom: 5px;
            margin-bottom: 10px;
        }

        .header-title {
            font-size: 15pt;
            font-weight: bold;
        }

        .header-subtitle {
            font-size: 18pt;
            font-weight: bold;
        }

        .header-info {
            font-style: italic;
            font-size: 12pt;
        }

        .kode-desa {
            margin-top: 5px;
            text-align: left;
            font-weight: bold;
        }

        .indent {
            text-indent: 40px;
        }

        .signature {
            width: 40%;
            margin-left: auto;
            margin-top: 50px;
            text-align: left;
            display: block;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        table td {
            vertical-align: top;
            padding: 2px 0;
        }
    </style>
</head>


<body>
    <div class="page">
        <x-surat.kop_surat />

        <div class="kode-desa">
            No. Kode Desa/Kelurahan: 33.13.13.2007
        </div>

        <div class="center">
            <h3><u>SURAT KETERANGAN DOMISILI INSTANSI</u></h3>
            <p>Nomor: {{ $nomor ?? '475 / 208 / VII / 2025' }}</p>
        </div>

        <div class="content">
            <p class="indent">Yang bertanda tangan di bawah ini Kepala Desa Jeruksawit, Kecamatan Gondangrejo, Kabupaten
                Karanganyar, menerangkan bahwa instansi berikut:</p>
            <br>

            <table>
                <tr>
                    <td width="180">Nama Instansi</td>
                    <td>: {{ $nama_instansi ?? 'PT Contoh Indonesia' }}</td>
                </tr>
                <tr>
                    <td>Nama Pimpinan</td>
                    <td>: {{ $nama_pimpinan ?? 'Budi Santoso' }}</td>
                </tr>
                <tr>
                    <td>NIP Pimpinan</td>
                    <td>: {{ $nip_pimpinan ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Email Pimpinan</td>
                    <td>: {{ $email_pimpinan ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Alamat Instansi</td>
                    <td>: {{ $alamat_instansi ?? 'Jl. Mawar No. 1, Jeruksawit' }}</td>
                </tr>
                <tr>
                    <td>Keterangan Lokasi</td>
                    <td>: {{ $keterangan_lokasi ?? '-' }}</td>
                </tr>
            </table>

            <br>

            <p class="indent">Adalah benar berdomisili di wilayah Desa Jeruksawit, Kecamatan Gondangrejo, Kabupaten
                Karanganyar.</p>
            <p class="indent">Demikian surat keterangan ini dibuat untuk dipergunakan sebagaimana mestinya.</p>
        </div>

        <div class="signature">
            <p style="margin-bottom: 0;">Jeruksawit, {{ $tanggal ?? '03 Maret 2025' }}</p>
            <p style="margin-top: 0;">Kepala Desa Jeruksawit</p>

            <br><br><br>

            <p style="font-weight:bold">{{ $nama_kepala ?? 'MIDI' }}</p>
        </div>
    </div>
</body>

</html>
