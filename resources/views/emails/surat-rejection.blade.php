@component('mail::message')
    # Pemberitahuan Penolakan Surat

    Halo {{ $pemohon->nama_lengkap }},

    Mohon maaf, permohonan surat Anda tidak dapat kami setujui pada saat ini.

    **Detail Pengajuan:**
    - Jenis Surat: {{ $surat->jenisSurat->nama_jenis }}
    - Nama Pemohon: {{ $pemohon->nama_lengkap }}
    - NIK: {{ $pemohon->nik }}
    - Status: Ditolak

    @if ($catatan)
        **Alasan Penolakan:**
        {{ $catatan }}
    @endif

    Anda dapat mengajukan kembali permohonan surat dengan melengkapi persyaratan yang diperlukan atau menghubungi kantor
    desa untuk informasi lebih lanjut.

    Terima kasih atas pengertian Anda.

    Salam hormat,<br>
    Tim Layanan Surat Desa Jeruk Sawit
@endcomponent
