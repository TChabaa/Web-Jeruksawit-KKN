<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
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
     * Generate PDF for surat (public method for external use)
     * Optimized with caching and memory management
     */
    public function generateSuratPdf($surat)
    {
        // Create cache key based on surat ID and last update
        $cacheKey = "pdf_path_surat_{$surat->id_surat}_{$surat->updated_at->timestamp}";

        // Check if PDF already exists in cache
        $existingPdfPath = Cache::get($cacheKey);
        if ($existingPdfPath && file_exists($existingPdfPath)) {
            Log::info('Using cached PDF', ['surat_id' => $surat->id_surat, 'path' => $existingPdfPath]);
            return $existingPdfPath;
        }

        // Load detail data efficiently with selective loading
        $detail = $this->getDetailSuratOptimized($surat);

        // Validate that detail exists for the surat type
        if (!$detail && $this->requiresDetail($surat->jenisSurat->nama_jenis)) {
            throw new \Exception('Data detail surat tidak ditemukan untuk jenis: ' . $surat->jenisSurat->nama_jenis);
        }

        // Prepare data with memory optimization
        $data = $this->preparePdfDataOptimized($surat, $detail);
        $templateName = $this->getPdfTemplateName($surat->jenisSurat->nama_jenis);

        // Check if template exists
        $templatePath = 'components.surat.' . $templateName;
        if (!view()->exists($templatePath)) {
            throw new \Exception('Template PDF tidak ditemukan: ' . $templateName);
        }

        // Ensure storage directory exists
        if (!Storage::exists('public/surat-pdf')) {
            Storage::makeDirectory('public/surat-pdf');
        }

        $fileName = 'surat_' . $surat->id_surat . '_' . time() . '.pdf';
        $filePath = storage_path('app/public/surat-pdf/' . $fileName);

        // Generate PDF with memory optimization
        try {
            $customPaper = [0, 0, 595.276, 935.433]; // A4 size in points

            // Configure DomPDF for better memory usage
            $pdf = Pdf::loadView($templatePath, $data)
                ->setPaper($customPaper, 'portrait')
                ->setOptions([
                    'isHtml5ParserEnabled' => true,
                    'isPhpEnabled' => false,
                    'isRemoteEnabled' => false,
                    'defaultFont' => 'DejaVu Sans',
                    'chroot' => [storage_path(), public_path()],
                    'logOutputFile' => storage_path('logs/dompdf.log'),
                    'tempDir' => storage_path('app/temp')
                ]);

            $pdf->save($filePath);

            // Cache the PDF path for 24 hours
            Cache::put($cacheKey, $filePath, now()->addHours(24));

            Log::info('PDF generated successfully', [
                'surat_id' => $surat->id_surat,
                'file_size' => filesize($filePath),
                'path' => $filePath
            ]);

            return $filePath;
        } catch (\Exception $e) {
            Log::error('PDF generation failed', [
                'surat_id' => $surat->id_surat,
                'error' => $e->getMessage(),
                'memory_usage' => memory_get_peak_usage(true)
            ]);
            throw $e;
        } finally {
            // Force garbage collection to free memory
            if (function_exists('gc_collect_cycles')) {
                gc_collect_cycles();
            }
        }
    }

    /**
     * Check if surat type requires detail data
     */
    private function requiresDetail($jenisSurat)
    {
        return !in_array($jenisSurat, ['Domisili Orang']);
    }

    /**
     * Get detail data for specific surat type with memory optimization
     */
    private function getDetailSuratOptimized($surat)
    {
        $jenis = $surat->jenisSurat->nama_jenis;

        // Use select to only load required fields for PDF generation
        return match ($jenis) {
            'SKCK' => DetailSkck::select('id_surat', 'keperluan', 'tanggal_mulai_berlaku', 'tanggal_akhir_berlaku')
                ->where('id_surat', $surat->id_surat)->first(),
            'Izin Keramaian' => DetailIzinKeramaian::select('id_surat', 'keperluan', 'jenis_hiburan', 'tempat_acara', 'hari_acara', 'tanggal_acara', 'jumlah_undangan')
                ->where('id_surat', $surat->id_surat)->first(),
            'Keterangan Usaha' => DetailKeteranganUsaha::select('id_surat', 'mulai_usaha', 'jenis_usaha', 'alamat_usaha')
                ->where('id_surat', $surat->id_surat)->first(),
            'SKTM' => DetailSktm::select('id_surat', 'pendidikan', 'penghasilan', 'jumlah_tanggungan')
                ->where('id_surat', $surat->id_surat)->first(),
            'Belum Menikah' => DetailBelumMenikah::select('id_surat', 'keperluan')
                ->where('id_surat', $surat->id_surat)->first(),
            'Keterangan Kematian' => DetailKematian::select('id_surat', 'nama_almarhum', 'nik_almarhum', 'jenis_kelamin', 'alamat', 'umur', 'hari_kematian', 'tanggal_kematian', 'tempat_kematian', 'penyebab_kematian', 'hubungan_pelapor')
                ->where('id_surat', $surat->id_surat)->first(),
            'Keterangan Kelahiran' => DetailKelahiran::select('id_surat', 'nama_anak', 'jenis_kelamin_anak', 'hari_lahir', 'tanggal_lahir', 'tempat_lahir', 'penolong_kelahiran', 'ibu', 'ayah')
                ->where('id_surat', $surat->id_surat)->first(),
            'Orang yang Sama' => DetailOrangYangSama::select('id_surat', 'nama_2', 'tempat_lahir_2', 'tanggal_lahir_2', 'nama_ayah_2', 'dasar_dokumen_1')
                ->where('id_surat', $surat->id_surat)->first(),
            'Pindah Keluar' => DetailPindahKeluar::select('id_surat', 'alamat_tujuan', 'alasan_pindah', 'tanggal_pindah')
                ->where('id_surat', $surat->id_surat)->first(),
            'Domisili Instansi' => DetailDomisiliInstansi::select('id_surat', 'nama_instansi', 'nama_pimpinan', 'nip_pimpinan', 'email_pimpinan', 'alamat_instansi', 'keterangan_lokasi')
                ->where('id_surat', $surat->id_surat)->first(),
            'Domisili Kelompok' => DetailDomisiliKelompok::select('id_surat', 'nama_kelompok', 'alamat_kelompok', 'ketua', 'email_ketua', 'sekretaris', 'bendahara', 'keterangan_lokasi')
                ->where('id_surat', $surat->id_surat)->first(),
            'Domisili Orang' => DetailDomisiliOrang::select('id_surat', 'keperluan')
                ->where('id_surat', $surat->id_surat)->first(),
            default => null
        };
    }

    /**
     * Prepare data for PDF generation with memory optimization
     */
    private function preparePdfDataOptimized($surat, $detail)
    {
        // Use minimal pemohon data to reduce memory footprint
        $pemohon = $surat->pemohon;

        // Pre-calculate commonly used values
        $tempatLahir = $pemohon->tempat_lahir ?? '';
        $tanggalLahir = $pemohon->tanggal_lahir ? \Carbon\Carbon::parse($pemohon->tanggal_lahir)->format('d-m-Y') : '';

        // Construct TTL properly, avoiding empty values
        if ($tempatLahir && $tanggalLahir) {
            $ttl = $tempatLahir . ', ' . $tanggalLahir;
        } elseif ($tempatLahir) {
            $ttl = $tempatLahir;
        } elseif ($tanggalLahir) {
            $ttl = $tanggalLahir;
        } else {
            $ttl = '';
        }

        $tanggalSurat = $surat->tanggal_surat ? \Carbon\Carbon::parse($surat->tanggal_surat)->format('d F Y') : now()->format('d F Y');

        // Base data for all surat types (minimized)
        $data = [
            'nomor' => $surat->nomor_surat ?? '474/001/I/' . date('Y'),
            'tahun' => date('Y'),
            'nama_kepala' => 'MIDI',
            'nama' => $pemohon->nama_lengkap ?? '',
            'ttl' => $ttl,
            'ktp' => $pemohon->nik ?? '',
            'nik' => $pemohon->nik ?? '', // Add nik for template compatibility
            'kk' => $pemohon->nomor_kk ?? '',
            'agama' => $pemohon->agama ?? '',
            'pekerjaan' => $pemohon->pekerjaan ?? '',
            'alamat' => $pemohon->alamat ?? '',
            'status' => $pemohon->status_perkawinan ?? '',
            'kewarganegaraan' => 'Indonesia',
            'tanggal' => $tanggalSurat
        ];

        // Add specific data based on surat type (only if detail exists)
        if ($detail) {
            $data = array_merge($data, $this->getTypeSpecificData($surat->jenisSurat->nama_jenis, $detail, $pemohon));
        }

        return $data;
    }

    /**
     * Get type-specific data for PDF generation
     */
    private function getTypeSpecificData($jenisSurat, $detail, $pemohon)
    {
        return match ($jenisSurat) {
            'SKCK' => [
                'keperluan' => $detail->keperluan ?? '',
                'mulai' => $detail->tanggal_mulai_berlaku ? \Carbon\Carbon::parse($detail->tanggal_mulai_berlaku)->format('d-m-Y') : '',
                'berakhir' => $detail->tanggal_akhir_berlaku ? \Carbon\Carbon::parse($detail->tanggal_akhir_berlaku)->format('d-m-Y') : '',
            ],
            'Izin Keramaian' => [
                'keperluan' => $detail->keperluan ?? '',
                'jenis_hiburan' => $detail->jenis_hiburan ?? '',
                'tempat_acara' => $detail->tempat_acara ?? '',
                'hari_acara' => $detail->hari_acara ?? '',
                'tanggal_acara' => $detail->tanggal_acara ? \Carbon\Carbon::parse($detail->tanggal_acara)->format('d F Y') : '',
                'jumlah_undangan' => $detail->jumlah_undangan ?? '',
            ],
            'Keterangan Usaha' => [
                'mulai_usaha' => $detail->mulai_usaha ? \Carbon\Carbon::parse($detail->mulai_usaha)->format('d F Y') : '',
                'jenis_usaha' => $detail->jenis_usaha ?? '',
                'alamat_usaha' => $detail->alamat_usaha ?? '',
            ],
            'SKTM' => [
                'pendidikan' => $detail->pendidikan ?? '',
                'penghasilan' => $detail->penghasilan ? 'Rp ' . number_format($detail->penghasilan, 0, ',', '.') : '-',
                'jumlah_tanggungan' => $detail->jumlah_tanggungan ?? '',
            ],
            'Belum Menikah' => [
                'keperluan' => 'Menerangkan bahwa orang tersebut sampai saat ini benar-benar belum menikah.',
                'kegunaan' => $detail->keperluan ?? '',
            ],
            'Keterangan Kematian' => [
                'nama_almarhum' => $detail->nama_almarhum ?? '',
                'nik_almarhum' => $detail->nik_almarhum ?? '',
                'jenis_kelamin_almarhum' => ($detail->jenis_kelamin ?? '') == 'L' ? 'Laki-laki' : 'Perempuan',
                'alamat_almarhum' => $detail->alamat ?? '',
                'umur' => $detail->umur ?? '',
                'hari_kematian' => $detail->hari_kematian ?? '',
                'tanggal_kematian' => $detail->tanggal_kematian ? \Carbon\Carbon::parse($detail->tanggal_kematian)->format('d F Y') : '',
                'tempat_kematian' => $detail->tempat_kematian ?? '',
                'penyebab_kematian' => $detail->penyebab_kematian ?? '',
                'hubungan_pelapor' => $detail->hubungan_pelapor ?? '',
            ],
            'Keterangan Kelahiran' => [
                'nama_anak' => $detail->nama_anak ?? '',
                'jenis_kelamin_anak' => ($detail->jenis_kelamin_anak ?? '') == 'L' ? 'Laki-laki' : 'Perempuan',
                'hari_lahir' => $detail->hari_lahir ?? '',
                'tanggal_lahir_anak' => $detail->tanggal_lahir ? \Carbon\Carbon::parse($detail->tanggal_lahir)->format('d F Y') : '',
                'tempat_lahir_anak' => $detail->tempat_lahir ?? '',
                'penolong_kelahiran' => $detail->penolong_kelahiran ?? '',
                'ibu' => $detail->ibu ?? '', // New field for mother's name
                'ayah' => $detail->ayah ?? '', // New field for father's name
            ],
            'Orang yang Sama' => [
                'nama1' => $pemohon->nama_lengkap ?? '',
                'ttl1' => ($pemohon->tempat_lahir ?? '') . ', ' . ($pemohon->tanggal_lahir ? \Carbon\Carbon::parse($pemohon->tanggal_lahir)->format('d-m-Y') : ''),
                'nik1' => $pemohon->nik ?? '',
                'alamat1' => $pemohon->alamat ?? '',
                'dasar1' => $detail->dasar_dokumen_1 ?? '',
                'nama2' => $detail->nama_2 ?? '',
                'ttl2' => ($detail->tempat_lahir_2  ?? '') . ', ' . ($detail->tanggal_lahir_2 ? \Carbon\Carbon::parse($detail->tanggal_lahir_2)->format('d-m-Y') : ''),
                'ayah1' => $detail->nama_ayah_2 ?? '',
                'ayah2' => $detail->nama_ayah_2 ?? '',
                'dasar2' => $detail->dasar_dokumen_2 ?? '',
            ],
            'Pindah Keluar' => [
                'alamat_tujuan' => $detail->alamat_tujuan ?? '',
                'alasan_pindah' => $detail->alasan_pindah ?? '',
                'tanggal_pindah' => $detail->tanggal_pindah ? \Carbon\Carbon::parse($detail->tanggal_pindah)->format('d F Y') : '',
            ],
            'Domisili Instansi' => [
                'nama_instansi' => $detail->nama_instansi ?? '',
                'nama_pimpinan' => $detail->nama_pimpinan ?? '',
                'nip_pimpinan' => $detail->nip_pimpinan ?? '',
                'email_pimpinan' => $detail->email_pimpinan ?? '',
                'alamat_instansi' => $detail->alamat_instansi ?? '',
                'keterangan_lokasi' => $detail->keterangan_lokasi ?? '',
            ],
            'Domisili Kelompok' => [
                'nama_kelompok' => $detail->nama_kelompok ?? '',
                'alamat_kelompok' => $detail->alamat_kelompok ?? '',
                'ketua' => $detail->ketua ?? '',
                'email_ketua' => $detail->email_ketua ?? '',
                'sekretaris' => $detail->sekretaris ?? '',
                'bendahara' => $detail->bendahara ?? '',
                'keterangan_lokasi' => $detail->keterangan_lokasi ?? '',
            ],
            'Domisili Orang' => [
                'keperluan' => $detail->keperluan ?? '',
            ], // No additional data needed
            default => []
        };
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
     * Get detail data for specific surat type (public method for external use)
     */
    public function getDetailSurat($surat)
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
