<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Surat Keterangan Orang yang Sama</title>
    <style>
        body {
            font-family: 'Times New Roman', serif;
            font-size: 12pt;
            margin: 0;
            /* <--- Penting! */
            padding: 0;
        }

        .page {
            margin: 1cm 1.2cm;
            /* Kiri & Kanan: 1.2cm, Atas & Bawah: 1cm */
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

            {
            page-break-before: avoid !important;
            page-break-inside: avoid !important;
            page-break-after: avoid !important;
            box-sizing: border-box;
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
            <h3><u>SURAT DUPLIKAT KELAHIRAN</u></h3>
            <p>Nomor: {{ $nomor ?? '475 / 208 / VII / 2025' }}</p>
        </div>

        <div class="content">
            <p class="indent">Yang bertanda tangan di bawah ini menerangkan bahwa telah lahir seorang anak dengan data
                sebagai berikut:</p>
            <br>

            <table>
                <tr>
                    <td width="180">Nomor Surat Kelahiran</td>
                    <td>: {{ $nomor_kelahiran ?? '472.11/001/IX/1989' }}</td>
                </tr>
                <tr>
                    <td>Hari</td>
                    <td>: {{ $hari_lahir ?? 'JUMAT PON' }}</td>
                </tr>
                <tr>
                    <td>Tanggal Lahir</td>
                    <td>: {{ $tanggal_lahir_anak ?? '22-09-1989' }}</td>
                </tr>
                <tr>
                    <td>Tempat Lahir</td>
                    <td>: {{ $tempat_lahir_anak ?? 'Desa Jeruksawit' }}</td>
                </tr>
                <tr>
                    <td>Jenis Kelamin</td>
                    <td>: {{ $jenis_kelamin_anak ?? 'LAKI-LAKI' }}</td>
                </tr>
                <tr>
                    <td>Nama Anak</td>
                    <td>: {{ $nama_anak ?? 'MITRO DIKROMO / SIYUN' }}</td>
                </tr>
                <tr>
                    <td>Nama Ibu Kandung</td>
                    <td>: {{ $ibu ?? 'SARMI' }}</td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td>: {{ $alamat ?? 'Plosorejo, RT 003/003' }}, Desa {{ $desa ?? 'Jeruksawit' }}</td>
                </tr>
                <tr>
                    <td>Istri dari</td>
                    <td>: {{ $ayah ?? 'SENEN' }}</td>
                </tr>
                <tr>
                    <td>Penolong Kelahiran</td>
                    <td>: {{ $penolong_kelahiran ?? 'Tandur (Dukun Anak)' }}</td>
                </tr>
            </table>

            <br>
            <p>Surat keterangan ini dibuat dengan sebenar-benarnya untuk dapat dipergunakan sebagaimana mestinya.</p>
        </div>

        <div class="signature">
            <p style="margin-bottom: 0;">{{ $desa ?? 'Jeruksawit' }}, {{ $tanggal_surat ?? '06 Agustus 2025' }}</p>
            <p style="margin-top: 0;">Kepala Desa {{ $desa ?? 'Jeruksawit' }}</p>
            <br><br><br>
            <p style="font-weight: bold">{{ $nama_kepala ?? 'MIDI' }}</p>
        </div>
    </div>
</body>

</html>
