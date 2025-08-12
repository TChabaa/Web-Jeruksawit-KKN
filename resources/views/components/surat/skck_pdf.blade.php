<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Surat Pengantar SKCK</title>
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

        .content table {
            width: 100%;
        }

        .content table td {
            vertical-align: top;
            padding: 2px 0;
        }

        .signature-table {
            width: 100%;
            margin-top: 50px;
        }

        .signature-table td {
            vertical-align: top;
            text-align: center;
        }

        .ttd-space {
            height: 80px;
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
            <h3><u>SURAT PENGANTAR SKCK</u></h3>
            <p>Nomor: {{ $nomor ?? '474 / 047 / II / 2025' }}</p>
        </div>

        <p>Yang bertandatangan di bawah ini menerangkan bahwa:</p>

        <div class="content">
            <table>
                <tr>
                    <td width="200">1. Nama</td>
                    <td>: {{ $nama ?? 'TRIYONO' }}</td>
                </tr>
                <tr>
                    <td>2. Tempat Tanggal Lahir</td>
                    <td>: {{ $ttl ?? 'Karanganyar, 15-05-1993' }}</td>
                </tr>
                <tr>
                    <td>3. Kewarganegaraan & Agama</td>
                    <td>: {{ $kewarganegaraan ?? 'Indonesia' }} & {{ $agama ?? 'Islam' }}</td>
                </tr>
                <tr>
                    <td>4. Pekerjaan</td>
                    <td>: {{ $pekerjaan ?? 'Karyawan Swasta' }}</td>
                </tr>
                <tr>
                    <td>5. Tempat Tinggal</td>
                    <td>: {{ $alamat ?? 'Kedunggong, RT.003/002, Desa Jeruksawit, Kec. Gondangrejo' }}</td>
                </tr>
                <tr>
                    <td>6. Status</td>
                    <td>: {{ $status ?? '-' }}</td>
                </tr>
                <tr>
                    <td>7. Surat Bukti</td>
                    <td>: KTP: {{ $ktp ?? '3313131505930003' }} | KK: {{ $kk ?? '3313132212220006' }}</td>
                </tr>
                <tr>
                    <td>8. Keperluan</td>
                    <td>: {{ $keperluan ?? 'Mengurus surat SKCK ke POLSEK Gondangrejo' }}</td>
                </tr>
                <tr>
                    <td>9. Mulai Berlaku</td>
                    <td>: {{ $mulai ?? '12-06-2025' }} s/d {{ $berakhir ?? '12-07-2025' }}</td>
                </tr>
                <tr>
                    <td>10. Keterangan Lain-lain</td>
                    <td>: Orang tersebut benar warga kami yang berkelakuan dan beradat istiadat baik</td>
                </tr>
            </table>

            <br>
            <p>Demikian harap menjadikan maklum yang berkepentingan.</p>

            <br><br>
            <p>Nomor: .....................................</p>
            <p>Tanggal: ...................................</p>
        </div>

        <table class="signature-table">
            <tr>
                <td width="50%">
                    <p>Tanda Tangan Pemegang</p>
                    <div class="ttd-space"></div>
                    <p><strong>{{ $nama ?? 'TRIYONO' }}</strong></p>
                </td>
                <td width="50%">
                    <p>Jeruksawit, {{ $tanggal ?? '12 Juni 2025' }}</p>
                    <p>Kepala Desa Jeruksawit</p>
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
                </td>
            </tr>
        </table>

        <x-surat.qr_verification :qrCodePath="$qr_code_path ?? null" />
    </div>

</body>

</html>
