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

        <div style="margin-top: 6px; font-weight: bold;">
            No. Kode Desa/Kelurahan: 33.13.13.2007
        </div>

        <div class="center" style="margin-top: 12px;">
            <h3><u>SURAT KETERANGAN TIDAK MAMPU</u></h3>
            <p>Nomor: {{ $nomor ?? '474 / 047 / II / 2025' }}</p>
        </div>

        <div class="content" style="margin-top: 12pt;">
            <p class="indent">Yang bertanda tangan di bawah ini menerangkan bahwa:</p>

            <table style="margin-top: 10px;">
                <tr>
                    <td style="width: 160px;">Nama</td>
                    <td style="width: 10px;">:</td>
                    <td>{{ $nama ?? 'SRI LESTARI' }}</td>
                </tr>
                <tr>
                    <td>Tempat Tanggal Lahir</td>
                    <td>:</td>
                    <td>{{ $ttl ?? 'Karanganyar, 29-01-1973' }}</td>
                </tr>
                <tr>
                    <td>NIK / No. KK</td>
                    <td>:</td>
                    <td>{{ $nik ?? '3313136901730001' }} / {{ $kk ?? '372051406120003' }}</td>
                </tr>
                <tr>
                    <td>Pekerjaan</td>
                    <td>:</td>
                    <td>{{ $pekerjaan ?? 'Karyawan Swasta' }}</td>
                </tr>
                <tr>
                    <td>Status</td>
                    <td>:</td>
                    <td>{{ $status ?? 'Kawin' }}</td>
                </tr>
                <tr>
                    <td>Pendidikan</td>
                    <td>:</td>
                    <td>{{ $pendidikan ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td>:</td>
                    <td>{{ $alamat ?? 'Jurangkambil RT.002/04, Desa Jeruksawit, Kec. Gondangrejo, Karanganyar' }}</td>
                </tr>
            </table>

            <p class="indent" style="margin-top: 12pt;">
                Keterangan: Bahwa orang tersebut benar warga penduduk Desa Jeruksawit yang berdomisili dan bertempat
                tinggal
                di alamat tersebut di atas dengan kondisi ekonomi yang tidak mampu.
            </p>

            <p class="indent">Demikian surat keterangan ini diberikan agar dapat dipergunakan sebagaimana mestinya.</p>
        </div>

        <div class="signature">
            <p style="margin-bottom: 0;">Jeruksawit, {{ $tanggal ?? '06 Agustus 2025' }}</p>
            <p style="margin-top: 0;">Kepala Desa Jeruksawit</p>
            @php
                $logoPath = public_path('assets/img/ttd.jpg');
                $logoBase64 = '';
                if (file_exists($logoPath)) {
                    $logoBase64 = 'data:image/jpg;base64,' . base64_encode(file_get_contents($logoPath));
                }
            @endphp
            @if ($logoBase64)
                <img src="{{ $logoBase64 }}" alt="Logo Karanganyar"
                    style="margin-top:15px; max-width: 150px; height: auto; margin: 0; padding: 0;">
            @else
                <div
                    style="width: 150px; height: 150px; border: 1px solid #ccc; display: flex; align-items: center; justify-content: center; font-size: 8pt; margin: 0; padding: 0;">
                    LOGO
                </div>
            @endif
            <p><strong>{{ $nama_kepala ?? 'MIDI' }}</strong></p>
        </div>
    </div>
</body>

</html>
