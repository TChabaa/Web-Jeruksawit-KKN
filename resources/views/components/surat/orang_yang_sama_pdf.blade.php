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
            <h3><u>SURAT KETERANGAN ORANG YANG SAMA</u></h3>
            <p>Nomor: 474 / {{ $nomor ?? '___' }} / VI / {{ $tahun ?? '2025' }}</p>
        </div>

        <div class="content">
            <p class="indent">Yang bertanda tangan di bawah ini Kepala Desa Jeruksawit, Kec. Gondangrejo, Kab.
                Karanganyar:
            </p>
            <br>

            <table>
                <tr>
                    <td width="150">Nama</td>
                    <td>: {{ $nama_kepala ?? 'MIDI' }}</td>
                </tr>
                <tr>
                    <td>Jabatan</td>
                    <td>: Kepala Desa Jeruksawit</td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td>: Kantor Kepala Desa Jeruksawit, Kec. Gondangrejo</td>
                </tr>
            </table>

            <p>Menerangkan bahwa:</p>

            <table>
                <tr>
                    <td width="150">Nama</td>
                    <td>: {{ $nama1 ?? 'Nama' }}</td>
                </tr>
                <tr>
                    <td>Tempat, Tgl Lahir</td>
                    <td>: {{ $ttl1 ?? 'Tanggal' }}</td>
                </tr>
                <tr>
                    <td>NIK</td>
                    <td>: {{ $nik1 ?? 'NIK' }}</td>
                </tr>
                <tr>
                    <td>Nama Ayah</td>
                    <td>: {{ $ayah1 ?? 'Nama' }}</td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td>: {{ $alamat1 ?? 'Alamat' }}</td>
                </tr>
                <tr>
                    <td colspan="2">Yang tertulis di kartu KK No: {{ $kk ?? 'KK' }} atas nama kepala
                        keluarga {{ $nama1 ?? 'Nama' }}</td>
                </tr>
            </table>

            <p class="center">DENGAN</p>

            <table>
                <tr>
                    <td width="150">Nama</td>
                    <td>: {{ $nama2 ?? 'Nama' }}</td>
                </tr>
                <tr>
                    <td>Tempat, Tgl Lahir</td>
                    <td>: {{ $ttl2 ?? 'Karanganyar, 09-05-1981' }}</td>
                </tr>
                <tr>
                    <td>Nama Ayah</td>
                    <td>: {{ $ayah2 ?? 'Nama' }}</td>
                </tr>
                <tr>
                    <td colspan="2">Yang tercatat pada Kutipan Buku Nikah No: {{ $buku_nikah ?? 'Nomor' }}</td>
                </tr>
            </table>

            <br>
            <p style="font-weight:bold; font-style:italic">Adalah benar-benar 1 (satu) orang dan merupakan orang yang
                sama.</p>
            <p>Demikian surat keterangan ini dibuat untuk dipergunakan sebagaimana mestinya.</p>
        </div>

        <div class="signature">
            <p style="margin-bottom: 0;">Jeruksawit, {{ $tanggal ?? '03 Maret 2025' }}</p>
            <p style="margin-top: 0;">Kepala Desa Jeruksawit</p>

            <br><br><br>

            <p style="font-weight:bold">MIDI</p>
        </div>
    </div>
</body>

</html>
