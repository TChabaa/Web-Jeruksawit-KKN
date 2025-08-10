@component('mail::message')
    <div style="font-family: Calibri, Arial, sans-serif; color: #111; line-height: 1.6;">
        <h1 style="font-weight: 700; color: #0d4d99; margin-bottom: 20px;">Konfirmasi Pengajuan Surat</h1>

        <p>Yth. <strong>{{ $pemohon->nama_lengkap }}</strong>,</p>

        <p>
            Terima kasih telah mengisi formulir pengajuan layanan surat di Desa Jeruk Sawit. Permohonan Anda saat ini sedang
            kami proses dengan seksama.
        </p>

        <h2 style="margin-top: 30px; margin-bottom: 10px;">Detail Pengajuan</h2>
        <ul style="list-style: none; padding-left: 0; font-size: 14px;">
            <li><strong>Jenis Surat:</strong> {{ $surat->jenisSurat->nama_jenis }}</li>
            <li><strong>Nama Pemohon:</strong> {{ $pemohon->nama_lengkap }}</li>
            <li><strong>NIK:</strong> {{ $pemohon->nik }}</li>
            <li><strong>Email:</strong> {{ $pemohon->email }}</li>
            <li><strong>Status:</strong> <span style="color: #2563eb; font-weight: 600;">Sedang diproses</span></li>
        </ul>

        <p>
            Kami akan menghubungi Anda melalui email ini untuk memberikan informasi lebih lanjut terkait perkembangan status
            permohonan surat Anda.
        </p>

        <p>
            Terima kasih atas kepercayaan Anda menggunakan layanan kami.
        </p>

        <p>Salam hormat,<br><strong>Tim Layanan Surat Desa Jeruk Sawit</strong></p>
    </div>
@endcomponent
