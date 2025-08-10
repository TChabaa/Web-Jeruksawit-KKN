@component('mail::message')
    <table style="width: 100%; font-family: 'Calibri', Arial, sans-serif; color: #111; line-height: 1.6;" cellpadding="0"
        cellspacing="0" role="presentation">
        <tr>
            <td>
                <h1
                    style="font-family: 'Calibri', Arial, sans-serif; font-weight: 700; color: #0d4d99; margin-bottom: 20px;">
                    Konfirmasi Pengajuan Surat
                </h1>

                <p style="font-family: 'Calibri', Arial, sans-serif;">
                    Yth. <strong>{{ $pemohon->nama_lengkap }}</strong>,
                </p>

                <p style="font-family: 'Calibri', Arial, sans-serif;">
                    Terima kasih telah mengisi formulir pengajuan layanan surat di Desa Jeruk Sawit. Permohonan Anda saat
                    ini sedang kami proses dengan seksama.
                </p>

                <h2 style="font-family: 'Calibri', Arial, sans-serif; margin-top: 30px; margin-bottom: 10px;">
                    Detail Pengajuan
                </h2>

                <table
                    style="font-family: 'Calibri', Arial, sans-serif; font-size: 14px; border-collapse: collapse; width: 100%;"
                    cellpadding="4" cellspacing="0" role="presentation">
                    <tbody>
                        <tr>
                            <td style="font-weight: 600; width: 150px; font-family: 'Calibri', Arial, sans-serif;">Jenis
                                Surat:</td>
                            <td style="font-family: 'Calibri', Arial, sans-serif;">{{ $surat->jenisSurat->nama_jenis }}</td>
                        </tr>
                        <tr style="background-color: #f9f9f9;">
                            <td style="font-weight: 600; font-family: 'Calibri', Arial, sans-serif;">Nama Pemohon:</td>
                            <td style="font-family: 'Calibri', Arial, sans-serif;">{{ $pemohon->nama_lengkap }}</td>
                        </tr>
                        <tr>
                            <td style="font-weight: 600; font-family: 'Calibri', Arial, sans-serif;">NIK:</td>
                            <td style="font-family: 'Calibri', Arial, sans-serif;">{{ $pemohon->nik }}</td>
                        </tr>
                        <tr style="background-color: #f9f9f9;">
                            <td style="font-weight: 600; font-family: 'Calibri', Arial, sans-serif;">Email:</td>
                            <td style="font-family: 'Calibri', Arial, sans-serif;">{{ $pemohon->email }}</td>
                        </tr>
                        <tr>
                            <td style="font-weight: 600; font-family: 'Calibri', Arial, sans-serif;">Status:</td>
                            <td style="font-family: 'Calibri', Arial, sans-serif;"><span
                                    style="color: #2563eb; font-weight: 600;">Sedang diproses</span></td>
                        </tr>
                    </tbody>
                </table>

                <p style="font-family: 'Calibri', Arial, sans-serif;">
                    Kami akan menghubungi Anda melalui email ini untuk memberikan informasi lebih lanjut terkait
                    perkembangan status permohonan surat Anda.
                </p>

                <p style="font-family: 'Calibri', Arial, sans-serif;">
                    Terima kasih atas kepercayaan Anda menggunakan layanan kami.
                </p>

                <p style="font-family: 'Calibri', Arial, sans-serif;">
                    Salam hormat,<br><strong>Tim Layanan Surat Desa Jeruk Sawit</strong>
                </p>
            </td>
        </tr>
    </table>
@endcomponent
