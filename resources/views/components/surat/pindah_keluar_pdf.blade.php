<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Surat Pengantar Pindah Keluar</title>
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


        .label {
            width: 180px;
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
            <h3><u>SURAT PENGANTAR PINDAH KELUAR</u></h3>
            <p>Nomor: {{ $nomor ?? '475 / 208 / VII / 2025' }}</p>
        </div>

        <div class="content">
            <p class="indent">Yang bertanda tangan di bawah ini menerangkan bahwa:</p>

            <table>
                <tr>
                    <td class="label">Nama Lengkap</td>
                    <td>: {{ $nama ?? 'ISNA' }}</td>
                </tr>
                <tr>
                    <td>Nomor Kartu Keluarga</td>
                    <td>: {{ $no_kk ?? '3313132605080001' }}</td>
                </tr>
                <tr>
                    <td>NIK</td>
                    <td>: {{ $nik ?? '3313130607830002' }}</td>
                </tr>
                <tr>
                    <td>Jenis Kelamin</td>
                    <td>: {{ $jenis_kelamin ?? 'Laki-laki' }}</td>
                </tr>
                <tr>
                    <td>Tempat & Tanggal Lahir</td>
                    <td>: {{ $ttl ?? 'Karanganyar, 06-07-1983' }}</td>
                </tr>
                <tr>
                    <td>Kewarganegaraan</td>
                    <td>: {{ $kewarganegaraan ?? 'Indonesia' }}</td>
                </tr>
                <tr>
                    <td>Agama</td>
                    <td>: {{ $agama ?? 'Islam' }}</td>
                </tr>
                <tr>
                    <td>Status Perkawinan</td>
                    <td>: {{ $status_perkawinan ?? 'Kawin' }}</td>
                </tr>
                <tr>
                    <td>Alamat Terakhir</td>
                    <td>: {{ $alamat_terakhir ?? 'Kedunggong, RT.004/002, Desa Jeruksawit' }}</td>
                </tr>
            </table>

            <br>

            <p class="indent"><strong>Alamat Tujuan Pindah:</strong></p>
            <table>
                <tr>
                    <td class="label">Alamat</td>
                    <td>: {{ $alamat_tujuan ?? 'DADAPAN, RT.006/007, Desa XXX, Kecamatan YYY, Kabupaten ZZZ' }}</td>
                </tr>
            </table>

            <br>

            <table>
                <tr>
                    <td class="label">Alasan Pindah</td>
                    <td>: {{ $alasan_pindah ?? 'Menikah' }}</td>
                </tr>
                <tr>
                    <td>Tanggal Pindah</td>
                    <td>: {{ $tanggal_pindah ?? '14 Juli 2025' }}</td>
                </tr>
            </table>

            <br>

            <p class="indent">Demikian surat pengantar ini dibuat untuk dipergunakan sebagaimana mestinya.</p>
        </div>

        <div class="signature">
            <p style="margin-bottom: 0;">Jeruksawit, {{ $tanggal ?? '06 Agustus 2025' }}</p>
            <p style="margin-top: 0;">Kepala Desa Jeruksawit</p>
            <br><br><br>
            <p><strong>{{ $nama_kepala ?? 'MIDI' }}</strong></p>
        </div>
    </div>
</body>

</html>
