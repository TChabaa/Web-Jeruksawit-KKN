<!-- QR Code for Verification -->
@if (isset($qrCodePath) && $qrCodePath && file_exists($qrCodePath))
    <div style="margin-top: 20px; text-align: center;">
        @php
            $qrContent = file_get_contents($qrCodePath);
            $qrBase64 = 'data:image/png;base64,' . base64_encode($qrContent);
        @endphp
        <img src="{{ $qrBase64 }}" alt="QR Verifikasi"
            style="width: 100px; height: 100px; border: none; margin: 0; padding: 0;">
        <p style="font-size: 8pt; margin: 5px 0 0 0; color: #666; line-height: 1;">Scan untuk verifikasi</p>
    </div>
@endif
