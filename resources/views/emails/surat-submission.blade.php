@component('mail::message')
    # Konfirmasi Pengajuan Surat

    Halo {{ $pemohon->nama_lengkap }},

    Terimakasih sudah mengisi form layanan surat jeruk sawit. Kami akan segera memproses permohonan anda.

    **Detail Pengajuan:**
    - Jenis Surat: {{ $surat->jenisSurat->nama_jenis }}
    - Nama Pemohon: {{ $pemohon->nama_lengkap }}
    - NIK: {{ $pemohon->nik }}
    - Email: {{ $pemohon->email }}
    - Status: Sedang diproses

    Kami akan menghubungi Anda melalui email ini untuk informasi lebih lanjut mengenai status permohonan surat Anda.

    Terima kasih atas kepercayaan Anda kepada layanan kami.

    Salam hormat,<br>
    Tim Layanan Surat Desa Jeruk Sawit
@endcomponent
