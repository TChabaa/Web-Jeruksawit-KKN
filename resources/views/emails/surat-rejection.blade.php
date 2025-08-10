@component('mail::message')
<table style="width: 100%; font-family: Arial, Helvetica, sans-serif; color: #111; line-height: 1.6;" cellpadding="0" cellspacing="0" role="presentation">
    <tr>
        <td align="center" style="padding-bottom: 20px;">
            <img src="{{ asset('assets/img/logo.png') }}" alt="Logo Pemerintah Desa Jeruk Sawit" style="width: 120px; height: auto; display: block; margin: 0 auto;">
        </td>
    </tr>
    <tr>
        <td>
            <h1 style="font-family: Arial, Helvetica, sans-serif; font-weight: 700; margin-bottom: 20px; text-align: left;">Pemberitahuan Penolakan Surat</h1>

            <p style="font-family: Arial, Helvetica, sans-serif;">Yth. <strong>{{ $pemohon->nama_lengkap }}</strong>,</p>

            <p style="font-family: Arial, Helvetica, sans-serif;">Dengan hormat,</p>

            <p style="font-family: Arial, Helvetica, sans-serif;">
                Kami mohon maaf untuk memberitahukan bahwa permohonan surat Anda saat ini belum dapat kami setujui.
            </p>

            <h2 style="font-family: Arial, Helvetica, sans-serif; margin-top: 30px; margin-bottom: 10px;">Detail Pengajuan</h2>

            <table style="font-family: Arial, Helvetica, sans-serif; font-size: 14px; border-collapse: collapse; width: 100%;" cellpadding="4" cellspacing="0" role="presentation">
                <tbody>
                    <tr>
                        <td style="font-weight: 600; width: 150px;">Jenis Surat:</td>
                        <td>{{ $surat->jenisSurat->nama_jenis }}</td>
                    </tr>
                    <tr style="background-color: #f9f9f9;">
                        <td style="font-weight: 600;">Nama Pemohon:</td>
                        <td>{{ $pemohon->nama_lengkap }}</td>
                    </tr>
                    <tr>
                        <td style="font-weight: 600;">NIK:</td>
                        <td>{{ $pemohon->nik }}</td>
                    </tr>
                    <tr style="background-color: #f9f9f9;">
                        <td style="font-weight: 600;">Status:</td>
                        <td><span style="color: #dc2626; font-weight: 600;">Ditolak</span></td>
                    </tr>
                </tbody>
            </table>

            @if ($catatan)
            <h2 style="font-family: Arial, Helvetica, sans-serif; margin-top: 30px; margin-bottom: 10px;">Alasan Penolakan</h2>
            <p style="font-family: Arial, Helvetica, sans-serif; background-color: #fee2e2; padding: 15px; border-radius: 6px; color: #b91c1c;">
                {{ $catatan }}
            </p>
            @endif

            <p style="font-family: Arial, Helvetica, sans-serif;">
                Anda dapat mengajukan kembali permohonan surat dengan melengkapi persyaratan yang diperlukan, atau menghubungi kantor desa untuk mendapatkan informasi lebih lanjut.
            </p>

            <p style="font-family: Arial, Helvetica, sans-serif;">
                Terima kasih atas pengertian dan kerjasama Anda.
            </p>

            <p style="font-family: Arial, Helvetica, sans-serif;">
                Salam hormat,<br><strong>Tim Layanan Surat Desa Jeruk Sawit</strong>
            </p>
        </td>
    </tr>
</table>
@endcomponent
