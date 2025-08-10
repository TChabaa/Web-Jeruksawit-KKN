@component('mail::message')
<div style="font-family: Calibri, Arial, sans-serif; color: #111; line-height: 1.6;">
    <div style="text-align: center; margin-bottom: 20px;">
        <img src="{{ asset('assets/img/logo.png') }}" alt="Logo Pemerintah Desa Jeruk Sawit" style="width: 120px; height: auto; margin: 0 auto;">
    </div>

    <h1 style="font-weight: 700; margin-bottom: 20px;">Pemberitahuan Penolakan Surat</h1>

    <p>Yth. <strong>{{ $pemohon->nama_lengkap }}</strong>,</p>

    <p>Dengan hormat,</p>

    <p>Kami mohon maaf untuk memberitahukan bahwa permohonan surat Anda saat ini belum dapat kami setujui.</p>

    <h2 style="margin-top: 30px; margin-bottom: 10px;">Detail Pengajuan</h2>
    <ul style="list-style: none; padding-left: 0; font-size: 14px;">
        <li><strong>Jenis Surat:</strong> {{ $surat->jenisSurat->nama_jenis }}</li>
        <li><strong>Nama Pemohon:</strong> {{ $pemohon->nama_lengkap }}</li>
        <li><strong>NIK:</strong> {{ $pemohon->nik }}</li>
        <li><strong>Status:</strong> <span style="color: #dc2626; font-weight: 600;">Ditolak</span></li>
    </ul>

    @if ($catatan)
        <h2 style="margin-top: 30px; margin-bottom: 10px;">Alasan Penolakan</h2>
        <p style="background-color: #fee2e2; padding: 15px; border-radius: 6px; color: #b91c1c;">
            {{ $catatan }}
        </p>
    @endif

    <p>Anda dapat mengajukan kembali permohonan surat dengan melengkapi persyaratan yang diperlukan, atau menghubungi kantor desa untuk mendapatkan informasi lebih lanjut.</p>

    <p>Terima kasih atas pengertian dan kerjasama Anda.</p>

    <p>Salam hormat,<br><strong>Tim Layanan Surat Desa Jeruk Sawit</strong></p>
</div>
@endcomponent
