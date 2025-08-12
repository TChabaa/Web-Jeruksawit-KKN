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
            <h3><u>SURAT KETERANGAN BELUM NIKAH</u></h3>
            <p>Nomor: {{ $nomor ?? '475 / 208 / VII / 2025' }}</p>
        </div>

        <div class="content">
            <p class="indent">Yang bertanda tangan di bawah ini Kepala Desa Jeruksawit, Kec. Gondangrejo, Kab.
                Karanganyar:</p>
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
                    <td>: {{ $nama ?? 'IIN AYUIKA ASPIRANI' }}</td>
                </tr>
                <tr>
                    <td>Tempat, Tgl Lahir</td>
                    <td>: {{ $ttl ?? 'Surakarta, 11-11-1998' }}</td>
                </tr>
                <tr>
                    <td>Agama</td>
                    <td>: {{ $agama ?? 'Islam' }}</td>
                </tr>
                <tr>
                    <td>Pekerjaan</td>
                    <td>: {{ $pekerjaan ?? 'Karyawan Swasta' }}</td>
                </tr>
                <tr>
                    <td>Status</td>
                    <td>: {{ $status ?? 'Belum Kawin' }}</td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td>: {{ $alamat ?? 'Perumahan Taman Permata Regency Blok B16, Desa Jeruksawit, Kec. Gondangrejo' }}
                    </td>
                </tr>
                <tr>
                    <td>No. NIK / KK</td>
                    <td>: {{ $nik ?? '3372045111960006' }} / {{ $kk ?? '3372041907210008' }}</td>
                </tr>
                <tr>
                    <td>Keperluan</td>
                    <td>:
                        {{ $keperluan ?? 'Menerangkan bahwa orang tersebut sampai saat ini benar-benar belum menikah.' }}
                    </td>
                </tr>
                <tr>
                    <td>Kegunaan</td>
                    <td>: {{ $kegunaan ?? 'Untuk keperluan pengajuan pinjaman KUR.' }}</td>
                </tr>
            </table>

            <br>

            <p class="indent">Surat keterangan ini dibuat berdasarkan data yang tercantum pada KTP dan Kartu Keluarga
                serta pengakuan yang bersangkutan.</p>
            <p class="indent">Demikian surat keterangan ini dibuat untuk dipergunakan sebagaimana mestinya.</p>
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

            <p style="font-weight:bold">{{ $nama_kepala ?? 'MIDI' }}</p>
        </div>

        <x-surat.qr_verification :qrCodePath="$qr_code_path ?? null" />
    </div>
</body>

</html>
