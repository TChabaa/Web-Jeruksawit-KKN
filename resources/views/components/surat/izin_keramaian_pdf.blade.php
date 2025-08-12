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
            <h3><u>SURAT KERAMAIAN</u></h3>
            <p>Nomor: {{ $nomor ?? '475 / 208 / VII / 2025' }}</p>
        </div>

        <div class="content">
            <p class="indent"><strong>SURAT PENGANTAR IJIN KERAMAIAN</strong></p>
            <p class="indent">Nomor: {{ $nomor_resmi ?? '330 / 175 / VI /33.13.13.2007/2025' }}</p>
            <p class="indent">Yang bertanda tangan di bawah ini menerangkan bahwa:</p>
            <br>

            <table>
                <tr>
                    <td width="180">Nama</td>
                    <td>: {{ $nama ?? 'JOKO CHRISTANTO' }}</td>
                </tr>
                <tr>
                    <td>Tempat, Tanggal Lahir</td>
                    <td>: {{ $ttl ?? 'SURAKARTA, 13 November 1970' }}</td>
                </tr>
                <tr>
                    <td>Kewarganegaraan & Agama</td>
                    <td>: {{ $kewarganegaraan ?? 'Indonesia' }} & {{ $agama ?? 'Islam' }}</td>
                </tr>
                <tr>
                    <td>Pekerjaan</td>
                    <td>: {{ $pekerjaan ?? 'Wira Swasta' }}</td>
                </tr>
                <tr>
                    <td>Tempat Tinggal</td>
                    <td>: {{ $alamat ?? 'Jebres Krajan, RT.001 RW.025, Jebres, Surakarta' }}</td>
                </tr>
                <tr>
                    <td>No. KTP / KK</td>
                    <td>: {{ $nik ?? '33720413117000062' }} / {{ $no_kk ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Keperluan</td>
                    <td>: {{ $keperluan ?? 'Permohonan ijin keramaian dalam acara Hajatan' }}</td>
                </tr>
                <tr>
                    <td>Jenis Hiburan</td>
                    <td>: {{ $jenis_hiburan ?? 'Campursari Lokalan' }}</td>
                </tr>
                <tr>
                    <td>Tempat Acara</td>
                    <td>: {{ $tempat_acara ?? 'Perum Marison Blok C08, Desa Jeruksawit' }}</td>
                </tr>
                <tr>
                    <td>Hari, Tanggal</td>
                    <td>: {{ $hari_acara ?? 'Sabtu' }}, {{ $tanggal_acara ?? '14 Juni 2025' }}</td>
                </tr>
                <tr>
                    <td>Jumlah Undangan</td>
                    <td>: ± {{ $jumlah_undangan ?? '300' }} orang</td>
                </tr>
            </table>

            <br>
            <p>Demikian surat pengantar ini dibuat untuk dipergunakan sebagaimana mestinya.</p>
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
            <p style="font-weight: bold">{{ $nama_kepala ?? 'MIDI' }}</p>
        </div>
        <x-surat.qr_verification :qrCodePath="$qr_code_path ?? null" />
    </div>
</body>

</html>
