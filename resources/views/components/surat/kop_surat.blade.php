<div class="header">
    <table width="100%" cellspacing="0" cellpadding="0" style="margin: 0 auto;">
        <tr>
            <td width="5%" style="vertical-align: top; padding: 0; margin: 0;">
                @php
                    $logoPath = public_path('assets/img/logo.png');
                    $logoBase64 = '';
                    if (file_exists($logoPath)) {
                        $logoBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath));
                    }
                @endphp
                @if ($logoBase64)
                    <img src="{{ $logoBase64 }}" alt="Logo Karanganyar" width="80"
                        style="max-width: 80px; height: auto; margin: 0; padding: 0;">
                @else
                    <div
                        style="width: 80px; height: 80px; border: 1px solid #ccc; display: flex; align-items: center; justify-content: center; font-size: 8pt; margin: 0; padding: 0;">
                        LOGO
                    </div>
                @endif
            </td>
            <td width="40%" style="text-align: center; padding: 0; margin: 0;">
                <div class="header-title" style="margin: 0;">
                    PEMERINTAH KABUPATEN KARANGANYAR<br>
                    KECAMATAN GONDANGREJO
                </div>
                <div class="header-subtitle" style="margin: 0;">
                    KEPALA DESA JERUKSAWIT
                </div>
                <div class="header-info" style="margin: 0;">
                    Alamat : Desa Jeruksawit, Kec. Gondangrejo, Kab. Karanganyar 57773<br>
                    TELP. (0271) 2874420
                </div>
            </td>
        </tr>
    </table>
</div>
