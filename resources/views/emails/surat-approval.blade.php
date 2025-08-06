<x-mail::message>
    # Surat {{ $surat->jenisSurat->nama_jenis }} Disetujui

    Yth. {{ $pemohon->nama_lengkap }},

    Kami dengan senang hati menginformasikan bahwa permohonan surat {{ $surat->jenisSurat->nama_jenis }} Anda telah
    **disetujui**.

    ## Detail Surat
    - **Jenis Surat**: {{ $surat->jenisSurat->nama_jenis }}
    - **Nomor Surat**: {{ $surat->nomor_surat }}
    - **Tanggal Persetujuan**: {{ \Carbon\Carbon::parse($surat->updated_at)->format('d F Y') }}

    Surat resmi telah dilampirkan dalam email ini dalam format PDF. Silakan download dan simpan surat tersebut untuk
    keperluan Anda.

    Terima kasih atas kepercayaan Anda kepada layanan kami.

    Hormat kami,<br>
    **Pemerintah Desa Jeruksawit**
</x-mail::message>
