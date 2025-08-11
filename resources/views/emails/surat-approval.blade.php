<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Persetujuan Surat</title>
</head>

<body style="margin: 0; padding: 0; background-color: #f8fafc; font-family: Arial, Helvetica, sans-serif;">
    <table style="width: 100%; max-width: 600px; margin: 0 auto; background-color: #ffffff;" cellpadding="0"
        cellspacing="0" role="presentation">
        <tr>
            <td style="padding: 40px 20px 20px 20px; text-align: center;">

                @php
                    $logoPath = public_path('assets/img/logo.png');
                    $logoBase64 = '';
                    if (file_exists($logoPath)) {
                        $logoBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath));
                    }
                @endphp
                @if ($logoBase64)
                    <img src="{{ $logoBase64 }}" alt="Logo Karanganyar" width="80"
                        style="max-width: 80px; height: auto; margin: 0; padding: 0;">
                @else
                    <div sstyle="width: 120px; height: auto; display: block; margin: 0 auto;">
                        LOGO
                    </div>
                @endif
            </td>
        </tr>
        <tr>
            <td style="padding: 0 40px;">
                <h1
                    style="font-family: Arial, Helvetica, sans-serif; font-weight: 700; font-size: 24px; color: #0d9488; margin-bottom: 20px; text-align: center;">
                    Pemberitahuan Persetujuan Surat {{ $surat->jenisSurat->nama_jenis }}
                </h1>

                <p style="font-family: Arial, Helvetica, sans-serif; color: #111; line-height: 1.6;">
                    Yth. <strong>{{ $pemohon->nama_lengkap }}</strong>,
                </p>

                <p style="font-family: Arial, Helvetica, sans-serif; color: #111; line-height: 1.6;">
                    Dengan hormat,<br>
                    Kami informasikan bahwa permohonan <strong>Surat {{ $surat->jenisSurat->nama_jenis }}</strong> Anda
                    telah
                    <span style="color: #059669; font-weight: 600;">disetujui</span> oleh Pemerintah Desa Jeruksawit.
                </p>

                <h2
                    style="font-family: Arial, Helvetica, sans-serif; font-weight: 600; font-size: 18px; margin-top: 30px; margin-bottom: 10px; color: #111;">
                    Detail Surat
                </h2>

                <ul
                    style="font-family: Arial, Helvetica, sans-serif; list-style-type: none; padding-left: 0; font-size: 14px; line-height: 1.6; color: #111;">
                    <li style="margin-bottom: 8px;"><strong>Jenis Surat:</strong> {{ $surat->jenisSurat->nama_jenis }}
                    </li>
                    <li style="margin-bottom: 8px;"><strong>Nomor Surat:</strong> {{ $surat->nomor_surat }}</li>
                    <li style="margin-bottom: 8px;"><strong>Tanggal Persetujuan:</strong>
                        {{ \Carbon\Carbon::parse($surat->updated_at)->format('d F Y') }}</li>
                </ul>

                <p style="font-family: Arial, Helvetica, sans-serif; color: #111; line-height: 1.6;">
                    Surat resmi dalam format PDF telah kami lampirkan pada email ini. Silakan unduh dan simpan untuk
                    keperluan administrasi Anda.
                </p>

                <p style="font-family: Arial, Helvetica, sans-serif; color: #111; line-height: 1.6;">
                    Terima kasih atas kepercayaan dan kerjasama Anda menggunakan layanan kami.
                </p>

                <br>

                <p style="font-family: Arial, Helvetica, sans-serif; color: #111; line-height: 1.6;">
                    Hormat kami,<br>
                    <strong>Pemerintah Desa Jeruksawit</strong>
                </p>
            </td>
        </tr>
        <tr>
            <td style="text-align: center; padding: 20px; background-color: #f8fafc; color: #6b7280; font-size: 12px;">
                <p style="margin: 0;">Email ini dikirim secara otomatis dari sistem Pemerintah Desa Jeruksawit</p>
            </td>
        </tr>
    </table>
</body>

</html>
