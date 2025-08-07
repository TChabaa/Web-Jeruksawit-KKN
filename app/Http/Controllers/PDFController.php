<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Surat;
use App\Models\DetailSkck;
use App\Models\DetailIzinKeramaian;
use App\Models\DetailKeteranganUsaha;
use App\Models\DetailSktm;
use App\Models\DetailBelumMenikah;
use App\Models\DetailKematian;
use App\Models\DetailKelahiran;
use App\Models\DetailOrangYangSama;
use App\Models\DetailPindahKeluar;
use App\Models\DetailDomisiliInstansi;
use App\Models\DetailDomisiliKelompok;
use App\Models\DetailDomisiliOrang;

class PDFController extends Controller
{
    /**
     * Generate PDF for a specific surat
     */
    public function generatePDF(Request $request, $suratId = null)
    {
        // If no surat ID provided, use a default example
        if (!$suratId) {
            return $this->generateExamplePDF();
        }

        try {
            // Find the surat
            $surat = Surat::with(['pemohon', 'jenisSurat'])->findOrFail($suratId);

            // Only generate PDF for approved surat
            if ($surat->status !== 'disetujui') {
                return response()->json(['error' => 'PDF hanya dapat dibuat untuk surat yang telah disetujui.'], 400);
            }

            $pdfPath = $this->generateSuratPdf($surat);
            $cleanNomorSurat = str_replace(['/', '\\'], '_', $surat->nomor_surat);
            $fileName = 'surat_' . str_replace(' ', '_', strtolower($surat->jenisSurat->nama_jenis)) . '_' . $cleanNomorSurat . '.pdf';

            return response()->download($pdfPath, $fileName)->deleteFileAfterSend(true);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Surat tidak ditemukan.'], 404);
        } catch (\Exception $e) {
            Log::error('PDF Generation Error', [
                'surat_id' => $suratId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => 'Terjadi kesalahan saat mengunduh PDF: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Generate example PDF (for testing purposes)
     */
    private function generateExamplePDF()
    {
        $data = [
            'nomor' => '208',
            'tahun' => date('Y'),
            'nama_kepala' => 'MIDI',
            'nama' => 'John Doe',
            'ttl' => 'Jakarta, 01-01-1990',
            'ktp' => '1234567890123456',
            'kk' => '1234567890123456',
            'agama' => 'Islam',
            'pekerjaan' => 'Wiraswasta',
            'alamat' => 'Jl. Contoh No. 123, RT 01/RW 02',
            'status' => 'Belum Kawin',
            'kewarganegaraan' => 'Indonesia',
            'tanggal' => now()->format('d F Y'),
            'nama1' => 'John Doe',
            'ttl1' => 'Jakarta, 01-01-1990',
            'nik1' => '1234567890123456',
            'alamat1' => 'Jl. Contoh No. 123, RT 01/RW 02',
            'nama2' => 'John Doe',
            'ttl2' => 'Jakarta, 01-01-1990',
            'ayah1' => 'Budi Doe',
            'ayah2' => 'Budi Doe',
            'buku_nikah' => 'Akta Nikah No. 123/2020'
        ];

        $customPaper = [0, 0, 595.276, 935.433];
        $pdf = Pdf::loadView('components.surat.orang_yang_sama_pdf', $data)->setPaper($customPaper, 'portrait');

        return $pdf->download('surat_orang_yang_sama_example.pdf');
    }

    /**
     * Generate PDF for surat
     */
    private function generateSuratPdf($surat)
    {
        $detail = $this->getDetailSurat($surat);

        // Validate that detail exists for the surat type
        if (!$detail && $this->requiresDetail($surat->jenisSurat->nama_jenis)) {
            throw new \Exception('Data detail surat tidak ditemukan untuk jenis: ' . $surat->jenisSurat->nama_jenis);
        }

        $data = $this->preparePdfData($surat, $detail);
        $templateName = $this->getPdfTemplateName($surat->jenisSurat->nama_jenis);

        // Check if template exists
        $templatePath = 'components.surat.' . $templateName;
        if (!view()->exists($templatePath)) {
            throw new \Exception('Template PDF tidak ditemukan: ' . $templateName);
        }

        $customPaper = [0, 0, 595.276, 935.433]; // A4 size in points
        $pdf = Pdf::loadView($templatePath, $data)
            ->setPaper($customPaper, 'portrait');

        // Ensure storage directory exists
        if (!Storage::exists('public/surat-pdf')) {
            Storage::makeDirectory('public/surat-pdf');
        }

        $fileName = 'surat_' . $surat->id_surat . '_' . time() . '.pdf';
        $filePath = storage_path('app/public/surat-pdf/' . $fileName);

        $pdf->save($filePath);

        return $filePath;
    }

    /**
     * Check if surat type requires detail data
     */
    private function requiresDetail($jenisSurat)
    {
        return !in_array($jenisSurat, ['Domisili Orang']);
    }

    /**
     * Prepare data for PDF generation
     */
    private function preparePdfData($surat, $detail)
    {
        $pemohon = $surat->pemohon;

        // Base data for all surat types
        $data = [
            'nomor' => $this->extractNomorFromSurat($surat->nomor_surat ?? ''),
            'tahun' => date('Y'),
            'nama_kepala' => 'MIDI', // You may want to make this configurable
            'nama' => $pemohon->nama_lengkap ?? '',
            'ttl' => ($pemohon->tempat_lahir ?? '') . ', ' . ($pemohon->tanggal_lahir ? \Carbon\Carbon::parse($pemohon->tanggal_lahir)->format('d-m-Y') : ''),
            'ktp' => $pemohon->nik ?? '',
            'kk' => $pemohon->nomor_kk ?? '',
            'agama' => $pemohon->agama ?? '',
            'pekerjaan' => $pemohon->pekerjaan ?? '',
            'alamat' => $pemohon->alamat ?? '',
            'status' => $pemohon->status_perkawinan ?? '',
            'kewarganegaraan' => 'Indonesia',
            'tanggal' => $surat->tanggal_surat ? \Carbon\Carbon::parse($surat->tanggal_surat)->format('d F Y') : now()->format('d F Y')
        ];

        // Add specific data based on surat type
        if ($detail) {
            switch ($surat->jenisSurat->nama_jenis) {
                case 'SKCK':
                    $data['keperluan'] = $detail->keperluan ?? '';
                    $data['mulai'] = $detail->tanggal_mulai_berlaku ? \Carbon\Carbon::parse($detail->tanggal_mulai_berlaku)->format('d-m-Y') : '';
                    $data['berakhir'] = $detail->tanggal_akhir_berlaku ? \Carbon\Carbon::parse($detail->tanggal_akhir_berlaku)->format('d-m-Y') : '';
                    break;

                case 'Izin Keramaian':
                    $data['keperluan'] = $detail->keperluan ?? '';
                    $data['jenis_hiburan'] = $detail->jenis_hiburan ?? '';
                    $data['tempat_acara'] = $detail->tempat_acara ?? '';
                    $data['hari_acara'] = $detail->hari_acara ?? '';
                    $data['tanggal_acara'] = $detail->tanggal_acara ? \Carbon\Carbon::parse($detail->tanggal_acara)->format('d F Y') : '';
                    $data['jumlah_undangan'] = $detail->jumlah_undangan ?? '';
                    break;

                case 'Keterangan Usaha':
                    $data['mulai_usaha'] = $detail->mulai_usaha ? \Carbon\Carbon::parse($detail->mulai_usaha)->format('d F Y') : '';
                    $data['jenis_usaha'] = $detail->jenis_usaha ?? '';
                    $data['alamat_usaha'] = $detail->alamat_usaha ?? '';
                    break;

                case 'SKTM':
                    $data['pendidikan'] = $detail->pendidikan ?? '';
                    $data['penghasilan'] = $detail->penghasilan ? 'Rp ' . number_format($detail->penghasilan, 0, ',', '.') : '-';
                    $data['jumlah_tanggungan'] = $detail->jumlah_tanggungan ?? '';
                    break;

                case 'Belum Menikah':
                    $data['keperluan'] = $detail->keperluan ?? '';
                    break;

                case 'Keterangan Kematian':
                    $data['nama_almarhum'] = $detail->nama_almarhum ?? '';
                    $data['nik_almarhum'] = $detail->nik_almarhum ?? '';
                    $data['jenis_kelamin_almarhum'] = ($detail->jenis_kelamin ?? '') == 'L' ? 'Laki-laki' : 'Perempuan';
                    $data['alamat_almarhum'] = $detail->alamat ?? '';
                    $data['umur'] = $detail->umur ?? '';
                    $data['hari_kematian'] = $detail->hari_kematian ?? '';
                    $data['tanggal_kematian'] = $detail->tanggal_kematian ? \Carbon\Carbon::parse($detail->tanggal_kematian)->format('d F Y') : '';
                    $data['tempat_kematian'] = $detail->tempat_kematian ?? '';
                    $data['penyebab_kematian'] = $detail->penyebab_kematian ?? '';
                    $data['hubungan_pelapor'] = $detail->hubungan_pelapor ?? '';
                    break;

                case 'Keterangan Kelahiran':
                    $data['nama_anak'] = $detail->nama_anak ?? '';
                    $data['jenis_kelamin_anak'] = ($detail->jenis_kelamin_anak ?? '') == 'L' ? 'Laki-laki' : 'Perempuan';
                    $data['hari_lahir'] = $detail->hari_lahir ?? '';
                    $data['tanggal_lahir_anak'] = $detail->tanggal_lahir ? \Carbon\Carbon::parse($detail->tanggal_lahir)->format('d F Y') : '';
                    $data['tempat_lahir_anak'] = $detail->tempat_lahir ?? '';
                    $data['penolong_kelahiran'] = $detail->penolong_kelahiran ?? '';
                    break;

                case 'Orang yang Sama':
                    $data['nama1'] = $pemohon->nama_lengkap ?? '';
                    $data['ttl1'] = ($pemohon->tempat_lahir ?? '') . ', ' . ($pemohon->tanggal_lahir ? \Carbon\Carbon::parse($pemohon->tanggal_lahir)->format('d-m-Y') : '');
                    $data['nik1'] = $pemohon->nik ?? '';
                    $data['alamat1'] = $pemohon->alamat ?? '';
                    $data['nama2'] = $detail->nama_2 ?? '';
                    $data['ttl2'] = ($detail->tempat_lahir_2 ?? '') . ', ' . ($detail->tanggal_lahir_2 ? \Carbon\Carbon::parse($detail->tanggal_lahir_2)->format('d-m-Y') : '');
                    $data['ayah1'] = $detail->nama_ayah_2 ?? '';
                    $data['ayah2'] = $detail->nama_ayah_2 ?? '';
                    $data['buku_nikah'] = $detail->dasar_dokumen_1 ?? '';
                    break;

                case 'Pindah Keluar':
                    $data['alamat_tujuan'] = $detail->alamat_tujuan ?? '';
                    $data['alasan_pindah'] = $detail->alasan_pindah ?? '';
                    $data['tanggal_pindah'] = $detail->tanggal_pindah ? \Carbon\Carbon::parse($detail->tanggal_pindah)->format('d F Y') : '';
                    break;

                case 'Domisili Instansi':
                    $data['nama_instansi'] = $detail->nama_instansi ?? '';
                    $data['nama_pimpinan'] = $detail->nama_pimpinan ?? '';
                    $data['nip_pimpinan'] = $detail->nip_pimpinan ?? '';
                    $data['email_pimpinan'] = $detail->email_pimpinan ?? '';
                    $data['alamat_instansi'] = $detail->alamat_instansi ?? '';
                    $data['keterangan_lokasi'] = $detail->keterangan_lokasi ?? '';
                    break;

                case 'Domisili Kelompok':
                    $data['nama_kelompok'] = $detail->nama_kelompok ?? '';
                    $data['alamat_kelompok'] = $detail->alamat_kelompok ?? '';
                    $data['ketua'] = $detail->ketua ?? '';
                    $data['email_ketua'] = $detail->email_ketua ?? '';
                    $data['sekretaris'] = $detail->sekretaris ?? '';
                    $data['bendahara'] = $detail->bendahara ?? '';
                    $data['keterangan_lokasi'] = $detail->keterangan_lokasi ?? '';
                    break;

                case 'Domisili Orang':
                    // No additional data needed, uses base data only
                    break;
            }
        }

        return $data;
    }

    /**
     * Get PDF template name based on surat type
     */
    private function getPdfTemplateName($jenisSurat)
    {
        return match ($jenisSurat) {
            'SKCK' => 'skck_pdf',
            'Izin Keramaian' => 'izin_keramaian_pdf',
            'Keterangan Usaha' => 'keterangan_usaha_pdf',
            'SKTM' => 'sktm_pdf',
            'Belum Menikah' => 'belum_menikah_pdf',
            'Keterangan Kematian' => 'keterangan_kematian_pdf',
            'Keterangan Kelahiran' => 'keterangan_kelahiran_pdf',
            'Orang yang Sama' => 'orang_yang_sama_pdf',
            'Pindah Keluar' => 'pindah_keluar_pdf',
            'Domisili Instansi' => 'domisili_instansi_pdf',
            'Domisili Kelompok' => 'domisili_kelompok_pdf',
            'Domisili Orang' => 'domisili_orang_pdf',
            default => 'skck_pdf'
        };
    }

    /**
     * Extract number from surat number format (474/123/XII/2025)
     */
    private function extractNomorFromSurat($nomorSurat)
    {
        if (empty($nomorSurat)) {
            return '1';
        }

        if (preg_match('/474\/(\d+)\//', $nomorSurat, $matches)) {
            return $matches[1];
        }
        return '1';
    }

    /**
     * Get detail data for specific surat type
     */
    private function getDetailSurat($surat)
    {
        $jenis = $surat->jenisSurat->nama_jenis;

        return match ($jenis) {
            'SKCK' => DetailSkck::where('id_surat', $surat->id_surat)->first(),
            'Izin Keramaian' => DetailIzinKeramaian::where('id_surat', $surat->id_surat)->first(),
            'Keterangan Usaha' => DetailKeteranganUsaha::where('id_surat', $surat->id_surat)->first(),
            'SKTM' => DetailSktm::where('id_surat', $surat->id_surat)->first(),
            'Belum Menikah' => DetailBelumMenikah::where('id_surat', $surat->id_surat)->first(),
            'Keterangan Kematian' => DetailKematian::where('id_surat', $surat->id_surat)->first(),
            'Keterangan Kelahiran' => DetailKelahiran::where('id_surat', $surat->id_surat)->first(),
            'Orang yang Sama' => DetailOrangYangSama::where('id_surat', $surat->id_surat)->first(),
            'Pindah Keluar' => DetailPindahKeluar::where('id_surat', $surat->id_surat)->first(),
            'Domisili Instansi' => DetailDomisiliInstansi::where('id_surat', $surat->id_surat)->first(),
            'Domisili Kelompok' => DetailDomisiliKelompok::where('id_surat', $surat->id_surat)->first(),
            'Domisili Orang' => DetailDomisiliOrang::where('id_surat', $surat->id_surat)->first(),
            default => null
        };
    }
}
