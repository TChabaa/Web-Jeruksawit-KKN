<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Pengajuan Surat</title>
</head>

<body style="margin: 0; padding: 0; background-color: #f8fafc; font-family: 'Calibri', Arial, sans-serif;">
    <table style="width: 100%; max-width: 600px; margin: 0 auto; background-color: #ffffff;" cellpadding="0"
        cellspacing="0" role="presentation">
        <tr>
            <td style="padding: 40px;">
                <h1
                    style="font-family: 'Calibri', Arial, sans-serif; font-weight: 700; color: #0d4d99; margin-bottom: 20px; text-align: center;">
                    Konfirmasi Pengajuan Surat
                </h1>

                <p style="font-family: 'Calibri', Arial, sans-serif; color: #111; line-height: 1.6;">
                    Yth. <strong>{{ $pemohon->nama_lengkap }}</strong>,
                </p>

                <p style="font-family: 'Calibri', Arial, sans-serif; color: #111; line-height: 1.6;">
                    Terima kasih telah mengisi formulir pengajuan layanan surat di Desa Jeruk Sawit. Permohonan Anda
                    saat
                    ini sedang kami proses dengan seksama.
                </p>

                <h2
                    style="font-family: 'Calibri', Arial, sans-serif; margin-top: 30px; margin-bottom: 10px; color: #111;">
                    Detail Pengajuan
                </h2>

                <table
                    style="font-family: 'Calibri', Arial, sans-serif; font-size: 14px; border-collapse: collapse; width: 100%;"
                    cellpadding="4" cellspacing="0" role="presentation">
                    <tbody>
                        <tr>
                            <td
                                style="font-weight: 600; width: 150px; font-family: 'Calibri', Arial, sans-serif; color: #111;">
                                Jenis Surat:</td>
                            <td style="font-family: 'Calibri', Arial, sans-serif; color: #111;">
                                {{ $surat->jenisSurat->nama_jenis }}</td>
                        </tr>
                        <tr style="background-color: #f9f9f9;">
                            <td style="font-weight: 600; font-family: 'Calibri', Arial, sans-serif; color: #111;">Nama
                                Pemohon:</td>
                            <td style="font-family: 'Calibri', Arial, sans-serif; color: #111;">
                                {{ $pemohon->nama_lengkap }}</td>
                        </tr>
                        <tr>
                            <td style="font-weight: 600; font-family: 'Calibri', Arial, sans-serif; color: #111;">NIK:
                            </td>
                            <td style="font-family: 'Calibri', Arial, sans-serif; color: #111;">{{ $pemohon->nik }}</td>
                        </tr>
                        <tr style="background-color: #f9f9f9;">
                            <td style="font-weight: 600; font-family: 'Calibri', Arial, sans-serif; color: #111;">Email:
                            </td>
                            <td style="font-family: 'Calibri', Arial, sans-serif; color: #111;">{{ $pemohon->email }}
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: 600; font-family: 'Calibri', Arial, sans-serif; color: #111;">
                                Status:</td>
                            <td style="font-family: 'Calibri', Arial, sans-serif; color: #111;"><span
                                    style="color: #2563eb; font-weight: 600;">Sedang diproses</span></td>
                        </tr>
                    </tbody>
                </table>

                <p style="font-family: 'Calibri', Arial, sans-serif; color: #111; line-height: 1.6;">
                    Kami akan menghubungi Anda melalui email ini untuk memberikan informasi lebih lanjut terkait
                    perkembangan status permohonan surat Anda.
                </p>

                <p style="font-family: 'Calibri', Arial, sans-serif; color: #111; line-height: 1.6;">
                    Terima kasih atas kepercayaan Anda menggunakan layanan kami.
                </p>

                <p style="font-family: 'Calibri', Arial, sans-serif; color: #111; line-height: 1.6;">
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
