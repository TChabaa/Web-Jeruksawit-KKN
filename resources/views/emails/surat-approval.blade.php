<x-mail::message>
<table style="width: 100%; font-family: Arial, Helvetica, sans-serif; color: #111; line-height: 1.6;" cellpadding="0" cellspacing="0" role="presentation">
    <tr>
        <td align="center" style="padding-bottom: 20px;">
            <img src="{{ asset('assets/img/logo.png') }}" alt="Logo Pemerintah Desa Jeruksawit" style="width: 120px; height: auto; display: block; margin: 0 auto;">
        </td>
    </tr>
    <tr>
        <td>
            <h1 style="font-family: Arial, Helvetica, sans-serif; font-weight: 700; font-size: 24px; color: #0d9488; margin-bottom: 20px;">
                Pemberitahuan Persetujuan Surat {{ $surat->jenisSurat->nama_jenis }}
            </h1>

            <p style="font-family: Arial, Helvetica, sans-serif;">
                Yth. <strong>{{ $pemohon->nama_lengkap }}</strong>,
            </p>

            <p style="font-family: Arial, Helvetica, sans-serif;">
                Dengan hormat,<br>
                Kami informasikan bahwa permohonan <strong>Surat {{ $surat->jenisSurat->nama_jenis }}</strong> Anda telah
                <span style="color: #059669; font-weight: 600;">disetujui</span> oleh Pemerintah Desa Jeruksawit.
            </p>

            <h2 style="font-family: Arial, Helvetica, sans-serif; font-weight: 600; font-size: 18px; margin-top: 30px; margin-bottom: 10px;">
                Detail Surat
            </h2>

            <ul style="font-family: Arial, Helvetica, sans-serif; list-style-type: none; padding-left: 0; font-size: 14px; line-height: 1.6;">
                <li><strong>Jenis Surat:</strong> {{ $surat->jenisSurat->nama_jenis }}</li>
                <li><strong>Nomor Surat:</strong> {{ $surat->nomor_surat }}</li>
                <li><strong>Tanggal Persetujuan:</strong> {{ \Carbon\Carbon::parse($surat->updated_at)->format('d F Y') }}</li>
            </ul>

            <p style="font-family: Arial, Helvetica, sans-serif;">
                Surat resmi dalam format PDF telah kami lampirkan pada email ini. Silakan unduh dan simpan untuk keperluan administrasi Anda.
            </p>

            <p style="font-family: Arial, Helvetica, sans-serif;">
                Terima kasih atas kepercayaan dan kerjasama Anda menggunakan layanan kami.
            </p>

            <br>

            <p style="font-family: Arial, Helvetica, sans-serif;">
                Hormat kami,<br>
                <strong>Pemerintah Desa Jeruksawit</strong>
            </p>
        </td>
    </tr>
</table>
</x-mail::message>
