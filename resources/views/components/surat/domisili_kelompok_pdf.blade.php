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
            <h3><u>SURAT KETERANGAN DOMISILI</u></h3>
            <p>Nomor: {{ $nomor ?? '474 / 047 / II / 2025' }}</p>
        </div>

        <div class="content">
            <p class="indent">Yang bertanda tangan di bawah ini Kepala Desa Jeruksawit, Kec. Gondangrejo, Kab.
                Karanganyar, menerangkan bahwa:</p>
            <br>

            <table>
                <tr>
                    <td width="180">Nama Kelompok</td>
                    <td>: {{ $nama_kelompok ?? 'Contoh Kelompok Tani Maju' }}</td>
                </tr>
                <tr>
                    <td>Alamat Kelompok</td>
                    <td>: {{ $alamat_kelompok ?? 'Dusun Banyuanyar, Desa Jeruksawit, Gondangrejo' }}</td>
                </tr>
                <tr>
                    <td>Ketua</td>
                    <td>: {{ $ketua ?? 'Budi Santoso' }}</td>
                </tr>
                <tr>
                    <td>Email Ketua</td>
                    <td>: {{ $email_ketua ?? 'budi@example.com' }}</td>
                </tr>
                <tr>
                    <td>Sekretaris</td>
                    <td>: {{ $sekretaris ?? 'Siti Aminah' }}</td>
                </tr>
                <tr>
                    <td>Bendahara</td>
                    <td>: {{ $bendahara ?? 'Rudi Hartono' }}</td>
                </tr>
                <tr>
                    <td>Keterangan Lokasi</td>
                    <td>: {{ $keterangan_lokasi ?? 'Bertempat di lahan persawahan Blok A RT 03 RW 01' }}</td>
                </tr>
            </table>

            <br>

            <p class="indent">Kelompok tersebut benar keberadaannya di wilayah kami dan aktif dalam kegiatan masyarakat
                setempat.</p>
            <p class="indent">Demikian surat keterangan ini dibuat agar digunakan sebagaimana mestinya.</p>
        </div>

        <div class="signature">
            <p style="margin-bottom: 0;">Jeruksawit, {{ $tanggal ?? '07 Agustus 2025' }}</p>
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
    </div>
</body>

</html>
