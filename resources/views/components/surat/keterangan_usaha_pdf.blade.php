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
            <h3><u>SURAT KETERANGAN USAHA</u></h3>
            <p>Nomor: {{ $nomor ?? '474 / 172 / IV / 2025' }}</p>
        </div>

        <div class="content">
            <p class="indent">Yang bertanda tangan di bawah ini:</p>

            <table>
                <tr>
                    <td class="label">Nama</td>
                    <td>: {{ $nama_kepala ?? 'MIDI' }}</td>
                </tr>
                <tr>
                    <td>Jabatan</td>
                    <td>: Kepala Desa Jeruksawit, Kec. Gondangrejo</td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td>: Kantor Kepala Desa Jeruksawit, Kec. Gondangrejo</td>
                </tr>
            </table>

            <p class="indent" style="margin-top: 12pt;">Menerangkan bahwa:</p>

            <table>
                <tr>
                    <td class="label">Nama</td>
                    <td>: {{ $nama ?? 'SUPARNO' }}</td>
                </tr>
                <tr>
                    <td>Tempat Tanggal Lahir</td>
                    <td>: {{ $ttl ?? 'Karanganyar, 09-11-1971' }}</td>
                </tr>
                <tr>
                    <td>Pekerjaan</td>
                    <td>: {{ $pekerjaan ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Status</td>
                    <td>: {{ $status ?? 'Kawin' }}</td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td>: {{ $alamat ?? 'Plosokerep, RT 001/001, Desa Jeruksawit' }}</td>
                </tr>
                <tr>
                    <td>No. NIK / KK</td>
                    <td>: {{ $nik ?? '3313130911710002' }} / {{ $kk ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Mulai Usaha</td>
                    <td>: {{ $mulai_usaha ?? 'Tahun 2018 s/d Sekarang' }}</td>
                </tr>
            </table>

            <p class="indent" style="margin-top: 12pt;">
                Orang tersebut saat ini benar mempunyai usaha
                <strong>{{ $jenis_usaha ?? 'PETERNAKAN KAMBING' }}</strong> yang beralamat di
                {{ $alamat_usaha ?? 'Plosokerep, RT 001/001, Desa Jeruksawit, Kec. Gondangrejo' }}.
            </p>

            <p class="indent">Demikian surat keterangan ini diberikan untuk dipergunakan sebagaimana mestinya.</p>
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
