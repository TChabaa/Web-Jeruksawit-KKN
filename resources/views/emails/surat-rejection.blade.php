<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemberitahuan Penolakan Surat</title>
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
                    <div style="width: 120px; height: auto; display: block; margin: 0 auto;">
                        LOGO
                    </div>
                @endif
            </td>
        </tr>
        <tr>
            <td style="padding: 0 40px;">
                <h1
                    style="font-family: Arial, Helvetica, sans-serif; font-weight: 700; margin-bottom: 20px; text-align: center; color: #111;">
                    Pemberitahuan Penolakan Surat</h1>

                <p style="font-family: Arial, Helvetica, sans-serif; color: #111; line-height: 1.6;">Yth.
                    <strong>{{ $pemohon->nama_lengkap }}</strong>,
                </p>

                <p style="font-family: Arial, Helvetica, sans-serif; color: #111; line-height: 1.6;">Dengan hormat,</p>

                <p style="font-family: Arial, Helvetica, sans-serif; color: #111; line-height: 1.6;">
                    Kami mohon maaf untuk memberitahukan bahwa permohonan surat Anda saat ini belum dapat kami setujui.
                </p>

                <h2
                    style="font-family: Arial, Helvetica, sans-serif; margin-top: 30px; margin-bottom: 10px; color: #111;">
                    Detail Pengajuan</h2>

                <table
                    style="font-family: Arial, Helvetica, sans-serif; font-size: 14px; border-collapse: collapse; width: 100%;"
                    cellpadding="4" cellspacing="0" role="presentation">
                    <tbody>
                        <tr>
                            <td style="font-weight: 600; width: 150px; color: #111;">Jenis Surat:</td>
                            <td style="color: #111;">{{ $surat->jenisSurat->nama_jenis }}</td>
                        </tr>
                        <tr style="background-color: #f9f9f9;">
                            <td style="font-weight: 600; color: #111;">Nama Pemohon:</td>
                            <td style="color: #111;">{{ $pemohon->nama_lengkap }}</td>
                        </tr>
                        <tr>
                            <td style="font-weight: 600; color: #111;">NIK:</td>
                            <td style="color: #111;">{{ $pemohon->nik }}</td>
                        </tr>
                        <tr style="background-color: #f9f9f9;">
                            <td style="font-weight: 600; color: #111;">Status:</td>
                            <td style="color: #111;"><span style="color: #dc2626; font-weight: 600;">Ditolak</span></td>
                        </tr>
                    </tbody>
                </table>

                @if ($catatan)
                    <h2
                        style="font-family: Arial, Helvetica, sans-serif; margin-top: 30px; margin-bottom: 10px; color: #111;">
                        Alasan Penolakan</h2>
                    <p
                        style="font-family: Arial, Helvetica, sans-serif; background-color: #fee2e2; padding: 15px; border-radius: 6px; color: #b91c1c; line-height: 1.6;">
                        {{ $catatan }}
                    </p>
                @endif

                <p style="font-family: Arial, Helvetica, sans-serif; color: #111; line-height: 1.6;">
                    Anda dapat mengajukan kembali permohonan surat dengan melengkapi persyaratan yang diperlukan, atau
                    menghubungi kantor desa untuk mendapatkan informasi lebih lanjut.
                </p>

                <p style="font-family: Arial, Helvetica, sans-serif; color: #111; line-height: 1.6;">
                    Terima kasih atas pengertian dan kerjasama Anda.
                </p>

                <p style="font-family: Arial, Helvetica, sans-serif; color: #111; line-height: 1.6;">
                    Salam hormat,<br><strong>Tim Layanan Surat Desa Jeruk Sawit</strong>
                </p>
            </td>
        </tr>
        <tr>
            <td style="text-align: center; padding: 20px; background-color: #f8fafc; color: #6b7280; font-size: 12px;">
                <p style="margin: 0;">Email ini dikirim secara otomatis dari sistem Pemerintah Desa Jeruk Sawit</p>
            </td>
        </tr>
    </table>
</body>

</html>
