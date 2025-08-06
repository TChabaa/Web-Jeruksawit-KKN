<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Models\JenisSurat;
use App\Models\Pemohon;
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
use App\Http\Requests\SuratSkckRequest;
use App\Http\Requests\SuratIzinKeramaianRequest;
use App\Http\Requests\SuratKeteranganUsahaRequest;
use App\Http\Requests\SuratSktmRequest;
use App\Http\Requests\SuratBelumMenikahRequest;
use App\Http\Requests\SuratKeteranganKematianRequest;
use App\Http\Requests\SuratKeteranganKelahiranRequest;
use App\Http\Requests\SuratOrangYangSamaRequest;
use App\Http\Requests\SuratPindahKeluarRequest;
use App\Http\Requests\SuratDomisiliInstansiRequest;
use App\Http\Requests\SuratDomisiliKelompokRequest;
use App\Http\Requests\SuratDomisiliOrangRequest;
use App\Mail\SuratApprovalMail;
use App\Mail\SuratSubmissionMail;
use App\Mail\SuratRejectionMail;
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;

class LayananSuratController extends Controller
{
    /**
     * Display the admin dashboard for letter services
     */
    public function index(Request $request)
    {
        if (request()->ajax()) {
            // Remove the ->latest() to allow DataTables to handle sorting
            $surat = Surat::with(['pemohon', 'jenisSurat']);

            // Apply status filter if provided
            if ($request->has('status') && $request->status !== '' && $request->status !== 'all') {
                $surat->where('status', $request->status);
            }

            // Apply jenis surat filter if provided
            if ($request->has('jenis_surat') && $request->jenis_surat !== '' && $request->jenis_surat !== 'all') {
                $surat->where('id_jenis', $request->jenis_surat);
            }

            return DataTables::of($surat)
                ->addColumn('no_surat', function ($item) {
                    return $item->nomor_surat ?? 'Belum ada nomor';
                })
                ->addColumn('nama_pemohon', function ($item) {
                    return $item->pemohon->nama_lengkap ?? '-';
                })
                ->addColumn('jenis_surat', function ($item) {
                    return $item->jenisSurat->nama_jenis ?? '-';
                })
                ->addColumn('status', function ($item) {
                    $statusClass = match ($item->status) {
                        'belum_diverifikasi' => 'bg-yellow-100 text-yellow-800',
                        'disetujui' => 'bg-green-100 text-green-800',
                        'ditolak' => 'bg-red-100 text-red-800',
                        default => 'bg-gray-100 text-gray-800'
                    };

                    $statusText = match ($item->status) {
                        'belum_diverifikasi' => 'Belum Diverifikasi',
                        'disetujui' => 'Disetujui',
                        'ditolak' => 'Ditolak',
                        default => 'Unknown'
                    };

                    return '<span class="px-2 py-1 text-xs font-medium rounded-full ' . $statusClass . '">' . $statusText . '</span>';
                })
                ->editColumn('created_at', function ($item) {
                    return $item->created_at ? $item->created_at->format('d/m/Y H:i') : '-';
                })
                ->orderColumn('created_at', function ($query, $order) {
                    return $query->orderBy('created_at', $order);
                })
                ->addColumn('action', function ($item) {
                    $roleName = Auth::user()->role;
                    if (!in_array($roleName, ['admin', 'owner', 'super_admin'])) {
                        $roleName = 'admin';
                    }

                    $detailUrl = route($roleName . '.layanan-surat.show', $item->id_surat);

                    return '<a href="' . $detailUrl . '" class="text-blue-600 hover:text-blue-900">Lihat Detail</a>';
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        // Get statistics data and jenis surat for filters
        $statistics = $this->getStatistics();
        $jenisSurat = JenisSurat::all();

        return view('components.pages.dashboard.admin.layanan-surat.index', compact('statistics', 'jenisSurat'));
    }

    /**
     * Get statistics for dashboard cards
     */
    public function getStatistics()
    {
        $pending = Surat::where('status', 'belum_diverifikasi')->count();
        $approved = Surat::where('status', 'disetujui')->count();
        $rejected = Surat::where('status', 'ditolak')->count();
        $total = Surat::count();

        return [
            'pending' => $pending,
            'approved' => $approved,
            'rejected' => $rejected,
            'total' => $total
        ];
    }

    /**
     * Show the form selection page for creating a new letter
     */
    public function create()
    {
        return view('components.pages.dashboard.admin.layanan-surat.create');
    }

    /**
     * Display the form for a specific surat type
     */
    public function showForm($type)
    {
        $validTypes = [
            'skck',
            'izin-keramaian',
            'keterangan-usaha',
            'sktm',
            'belum-menikah',
            'keterangan-kematian',
            'keterangan-kelahiran',
            'orang-yang-sama',
            'pindah-keluar',
            'domisili-instansi',
            'domisili-kelompok',
            'domisili-orang'
        ];

        if (!in_array($type, $validTypes)) {
            abort(404, 'Jenis surat tidak ditemukan');
        }

        $titles = [
            'skck' => 'SKCK',
            'izin-keramaian' => 'Izin Keramaian',
            'keterangan-usaha' => 'Keterangan Usaha',
            'sktm' => 'SKTM',
            'belum-menikah' => 'Belum Menikah',
            'keterangan-kematian' => 'Keterangan Kematian',
            'keterangan-kelahiran' => 'Keterangan Kelahiran',
            'orang-yang-sama' => 'Orang yang Sama',
            'pindah-keluar' => 'Pindah Keluar',
            'domisili-instansi' => 'Domisili Instansi',
            'domisili-kelompok' => 'Domisili Kelompok',
            'domisili-orang' => 'Domisili Orang'
        ];

        return view('components.pages.dashboard.admin.layanan-surat.form.' . str_replace('-', '_', $type), [
            'type' => $type,
            'title' => $titles[$type]
        ]);
    }

    /**
     * Process the surat request based on type
     */
    public function submitForm(Request $request, $type)
    {
        // Validate the basic required fields first
        $basicRules = [
            'name' => 'required|string|max:255',
            'nik' => 'required|string|size:16',
            'nomor_kk' => 'required|string|size:16',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'address' => 'required|string|max:500',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'agama' => 'required|string|max:50',
            'pekerjaan' => 'required|string|max:100',
            'status_perkawinan' => 'required|string|max:50',
            'notes' => 'nullable|string|max:1000',
            'attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ];

        // Add type-specific validation rules
        $typeSpecificRules = $this->getTypeSpecificRules($type);
        $rules = array_merge($basicRules, $typeSpecificRules);

        $validatedData = $request->validate($rules);

        DB::beginTransaction();

        try {
            // Create or find pemohon
            $pemohon = $this->createOrUpdatePemohon($validatedData);

            // Get jenis surat
            $jenisSurat = $this->getJenisSurat($type);

            // Create surat without created_by (will be assigned during status update)
            $surat = $this->createSurat($pemohon->id_pemohon, $jenisSurat->id_jenis, $validatedData);

            // Create detail surat based on type
            $this->createDetailSurat($type, $surat->id_surat, $validatedData);

            DB::commit();

            // Send confirmation email to user
            try {
                // Reload surat with relationships for email
                $suratWithRelations = Surat::with(['pemohon', 'jenisSurat'])->find($surat->id_surat);
                Mail::to($pemohon->email)->send(new SuratSubmissionMail($suratWithRelations, $pemohon));
            } catch (\Exception $e) {
                // Log email error but don't fail the submission
                Log::error('Failed to send submission confirmation email: ' . $e->getMessage());
            }

            // Handle redirect based on authentication status
            if (Auth::check()) {
                $roleName = Auth::user()->role ?? 'admin';
                return redirect()->route($roleName . '.layanan-surat')
                    ->with('success', 'Permohonan surat berhasil diajukan.');
            } else {
                // For non-authenticated users, redirect to layanan-surat page
                return redirect()->route('layanan-surat')
                    ->with('success', 'Permohonan surat berhasil diajukan. Terima kasih!');
            }
        } catch (\Exception $e) {
            DB::rollback();

            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Show letter details
     */
    public function show($id)
    {
        $surat = Surat::with(['pemohon', 'jenisSurat'])->findOrFail($id);

        // Get detail based on type
        $detail = $this->getDetailSurat($surat);

        return view('components.pages.dashboard.admin.layanan-surat.show', compact('surat', 'detail'));
    }

    /**
     * Update letter status (approve/reject)
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:disetujui,ditolak',
            'catatan' => 'nullable|string|max:1000'
        ]);

        $surat = Surat::with(['pemohon', 'jenisSurat'])->findOrFail($id);
        $surat->status = $request->status;

        // Assign created_by when status is updated (not during form creation)
        if (!$surat->created_by) {
            $surat->created_by = Auth::id();
        }

        if ($request->status === 'disetujui' && !$surat->nomor_surat) {
            $surat->nomor_surat = $this->generateNomorSurat($surat->jenisSurat->nama_jenis, $surat->id_surat);
            $surat->tanggal_surat = now();
        }

        $surat->save();

        // Generate PDF and send email if approved
        if ($request->status === 'disetujui') {
            try {
                $pdfPath = $this->generateSuratPdf($surat);

                // Send email with PDF attachment
                Mail::to($surat->pemohon->email)->send(new SuratApprovalMail($surat, $surat->pemohon, $pdfPath));

                $statusText = 'disetujui dan PDF telah dikirim via email';
            } catch (\Exception $e) {
                $statusText = 'disetujui, namun terjadi kesalahan saat mengirim email: ' . $e->getMessage();
            }
        } else {
            // Send rejection email
            try {
                Mail::to($surat->pemohon->email)->send(new SuratRejectionMail($surat, $surat->pemohon, $request->catatan));
                $statusText = 'ditolak dan email pemberitahuan telah dikirim';
            } catch (\Exception $e) {
                $statusText = 'ditolak, namun terjadi kesalahan saat mengirim email: ' . $e->getMessage();
            }
        }

        return redirect()->back()->with('success', "Surat berhasil {$statusText}.");
    }

    /**
     * Download PDF for approved surat
     */
    public function downloadPdf($id)
    {
        $surat = Surat::with(['pemohon', 'jenisSurat'])->findOrFail($id);

        if ($surat->status !== 'disetujui') {
            return redirect()->back()->with('error', 'PDF hanya dapat diunduh untuk surat yang telah disetujui.');
        }

        try {
            $pdfPath = $this->generateSuratPdf($surat);
            $fileName = 'surat_' . str_replace(' ', '_', strtolower($surat->jenisSurat->nama_jenis)) . '_' . $surat->nomor_surat . '.pdf';

            return response()->download($pdfPath, $fileName)->deleteFileAfterSend(true);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengunduh PDF: ' . $e->getMessage());
        }
    }

    /**
     * Generate PDF for surat
     */
    private function generateSuratPdf($surat)
    {
        $detail = $this->getDetailSurat($surat);
        $data = $this->preparePdfData($surat, $detail);

        $templateName = $this->getPdfTemplateName($surat->jenisSurat->nama_jenis);

        $customPaper = [0, 0, 595.276, 935.433]; // A4 size in points
        $pdf = Pdf::loadView('components.surat.' . $templateName, $data)
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
     * Prepare data for PDF generation
     */
    private function preparePdfData($surat, $detail)
    {
        $pemohon = $surat->pemohon;

        // Base data for all surat types
        $data = [
            'nomor' => $this->extractNomorFromSurat($surat->nomor_surat),
            'tahun' => date('Y'),
            'nama_kepala' => 'MIDI', // You may want to make this configurable
            'nama' => $pemohon->nama_lengkap,
            'ttl' => $pemohon->tempat_lahir . ', ' . \Carbon\Carbon::parse($pemohon->tanggal_lahir)->format('d-m-Y'),
            'ktp' => $pemohon->nik,
            'kk' => $pemohon->nomor_kk,
            'agama' => $pemohon->agama,
            'pekerjaan' => $pemohon->pekerjaan,
            'alamat' => $pemohon->alamat,
            'status' => $pemohon->status_perkawinan,
            'kewarganegaraan' => 'Indonesia',
            'tanggal' => \Carbon\Carbon::parse($surat->tanggal_surat)->format('d F Y')
        ];

        // Add specific data based on surat type
        switch ($surat->jenisSurat->nama_jenis) {
            case 'SKCK':
                $data['keperluan'] = $detail->keperluan;
                $data['mulai'] = \Carbon\Carbon::parse($detail->tanggal_mulai_berlaku)->format('d-m-Y');
                $data['berakhir'] = \Carbon\Carbon::parse($detail->tanggal_akhir_berlaku)->format('d-m-Y');
                break;

            case 'Izin Keramaian':
                $data['keperluan'] = $detail->keperluan;
                $data['jenis_hiburan'] = $detail->jenis_hiburan;
                $data['tempat_acara'] = $detail->tempat_acara;
                $data['hari_acara'] = $detail->hari_acara;
                $data['tanggal_acara'] = \Carbon\Carbon::parse($detail->tanggal_acara)->format('d F Y');
                $data['jumlah_undangan'] = $detail->jumlah_undangan;
                break;

            case 'Keterangan Usaha':
                $data['mulai_usaha'] = \Carbon\Carbon::parse($detail->mulai_usaha)->format('d F Y');
                $data['jenis_usaha'] = $detail->jenis_usaha;
                $data['alamat_usaha'] = $detail->alamat_usaha;
                break;

            case 'SKTM':
                $data['pendidikan'] = $detail->pendidikan;
                $data['penghasilan'] = $detail->penghasilan ? 'Rp ' . number_format($detail->penghasilan, 0, ',', '.') : '-';
                $data['jumlah_tanggungan'] = $detail->jumlah_tanggungan;
                break;

            case 'Belum Menikah':
                $data['keperluan'] = $detail->keperluan;
                break;

            case 'Keterangan Kematian':
                $data['nama_almarhum'] = $detail->nama_almarhum;
                $data['nik_almarhum'] = $detail->nik_almarhum;
                $data['jenis_kelamin_almarhum'] = $detail->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan';
                $data['alamat_almarhum'] = $detail->alamat;
                $data['umur'] = $detail->umur;
                $data['hari_kematian'] = $detail->hari_kematian;
                $data['tanggal_kematian'] = \Carbon\Carbon::parse($detail->tanggal_kematian)->format('d F Y');
                $data['tempat_kematian'] = $detail->tempat_kematian;
                $data['penyebab_kematian'] = $detail->penyebab_kematian;
                $data['hubungan_pelapor'] = $detail->hubungan_pelapor;
                break;

            case 'Keterangan Kelahiran':
                $data['nama_anak'] = $detail->nama_anak;
                $data['jenis_kelamin_anak'] = $detail->jenis_kelamin_anak == 'L' ? 'Laki-laki' : 'Perempuan';
                $data['hari_lahir'] = $detail->hari_lahir;
                $data['tanggal_lahir_anak'] = \Carbon\Carbon::parse($detail->tanggal_lahir)->format('d F Y');
                $data['tempat_lahir_anak'] = $detail->tempat_lahir;
                $data['penolong_kelahiran'] = $detail->penolong_kelahiran;
                break;

            case 'Orang yang Sama':
                $data['nama1'] = $pemohon->nama_lengkap;
                $data['ttl1'] = $pemohon->tempat_lahir . ', ' . \Carbon\Carbon::parse($pemohon->tanggal_lahir)->format('d-m-Y');
                $data['nik1'] = $pemohon->nik;
                $data['alamat1'] = $pemohon->alamat;
                $data['nama2'] = $detail->nama_2;
                $data['ttl2'] = $detail->tempat_lahir_2 . ', ' . \Carbon\Carbon::parse($detail->tanggal_lahir_2)->format('d-m-Y');
                $data['ayah1'] = $detail->nama_ayah_2; // Assuming father name is same
                $data['ayah2'] = $detail->nama_ayah_2;
                $data['buku_nikah'] = $detail->dasar_dokumen_1;
                break;

            case 'Pindah Keluar':
                $data['alamat_tujuan'] = $detail->alamat_tujuan;
                $data['alasan_pindah'] = $detail->alasan_pindah;
                $data['tanggal_pindah'] = \Carbon\Carbon::parse($detail->tanggal_pindah)->format('d F Y');
                break;

            case 'Domisili Instansi':
                $data['nama_instansi'] = $detail->nama_instansi;
                $data['nama_pimpinan'] = $detail->nama_pimpinan;
                $data['nip_pimpinan'] = $detail->nip_pimpinan;
                $data['email_pimpinan'] = $detail->email_pimpinan;
                $data['alamat_instansi'] = $detail->alamat_instansi;
                $data['keterangan_lokasi'] = $detail->keterangan_lokasi;
                break;

            case 'Domisili Kelompok':
                $data['nama_kelompok'] = $detail->nama_kelompok;
                $data['alamat_kelompok'] = $detail->alamat_kelompok;
                $data['ketua'] = $detail->ketua;
                $data['email_ketua'] = $detail->email_ketua;
                $data['sekretaris'] = $detail->sekretaris;
                $data['bendahara'] = $detail->bendahara;
                $data['keterangan_lokasi'] = $detail->keterangan_lokasi;
                break;

            case 'Domisili Orang':
                // No additional data needed, uses base data only
                break;
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
            'Domisili Orang' => 'domisilo_orang_pdf',
            default => 'skck_pdf'
        };
    }

    /**
     * Extract number from surat number format (474/123/XII/2025)
     */
    private function extractNomorFromSurat($nomorSurat)
    {
        if (preg_match('/474\/(\d+)\//', $nomorSurat, $matches)) {
            return $matches[1];
        }
        return '1';
    }

    // Private helper methods
    private function getRequestClass($type)
    {
        return match ($type) {
            'skck' => SuratSkckRequest::class,
            'izin-keramaian' => SuratIzinKeramaianRequest::class,
            'keterangan-usaha' => SuratKeteranganUsahaRequest::class,
            'sktm' => SuratSktmRequest::class,
            'belum-menikah' => SuratBelumMenikahRequest::class,
            'keterangan-kematian' => SuratKeteranganKematianRequest::class,
            'keterangan-kelahiran' => SuratKeteranganKelahiranRequest::class,
            'orang-yang-sama' => SuratOrangYangSamaRequest::class,
            'pindah-keluar' => SuratPindahKeluarRequest::class,
            'domisili-instansi' => SuratDomisiliInstansiRequest::class,
            'domisili-kelompok' => SuratDomisiliKelompokRequest::class,
            'domisili-orang' => SuratDomisiliOrangRequest::class,
        };
    }

    private function createOrUpdatePemohon($data)
    {
        return Pemohon::updateOrCreate(
            ['nik' => $data['nik']],
            [
                'nomor_kk' => $data['nomor_kk'],
                'nama_lengkap' => $data['name'],
                'email' => $data['email'],
                'tempat_lahir' => $data['tempat_lahir'],
                'tanggal_lahir' => $data['tanggal_lahir'],
                'jenis_kelamin' => $data['jenis_kelamin'],
                'kewarganegaraan' => 'Indonesia',
                'agama' => $data['agama'],
                'status_perkawinan' => $data['status_perkawinan'],
                'pekerjaan' => $data['pekerjaan'],
                'alamat' => $data['address'],
            ]
        );
    }

    private function getJenisSurat($type)
    {
        $typeMapping = [
            'skck' => 'SKCK',
            'izin-keramaian' => 'Izin Keramaian',
            'keterangan-usaha' => 'Keterangan Usaha',
            'sktm' => 'SKTM',
            'belum-menikah' => 'Belum Menikah',
            'keterangan-kematian' => 'Keterangan Kematian',
            'keterangan-kelahiran' => 'Keterangan Kelahiran',
            'orang-yang-sama' => 'Orang yang Sama',
            'pindah-keluar' => 'Pindah Keluar',
            'domisili-instansi' => 'Domisili Instansi',
            'domisili-kelompok' => 'Domisili Kelompok',
            'domisili-orang' => 'Domisili Orang'
        ];

        return JenisSurat::where('nama_jenis', $typeMapping[$type])->firstOrFail();
    }

    private function createSurat($idPemohon, $idJenis, $data)
    {
        return Surat::create([
            'id_pemohon' => $idPemohon,
            'id_jenis' => $idJenis,
            'status' => 'belum_diverifikasi'
        ]);
    }

    private function createDetailSurat($type, $idSurat, $data)
    {
        switch ($type) {
            case 'skck':
                DetailSkck::create([
                    'id_surat' => $idSurat,
                    'keperluan' => $data['keperluan'],
                    'tanggal_mulai_berlaku' => $data['tanggal_mulai_berlaku'],
                    'tanggal_akhir_berlaku' => $data['tanggal_akhir_berlaku']
                ]);
                break;

            case 'izin-keramaian':
                DetailIzinKeramaian::create([
                    'id_surat' => $idSurat,
                    'keperluan' => $data['keperluan'],
                    'jenis_hiburan' => $data['jenis_hiburan'],
                    'tempat_acara' => $data['tempat_acara'],
                    'hari_acara' => $data['hari_acara'],
                    'tanggal_acara' => $data['tanggal_acara'],
                    'jumlah_undangan' => $data['jumlah_undangan']
                ]);
                break;

            case 'keterangan-usaha':
                DetailKeteranganUsaha::create([
                    'id_surat' => $idSurat,
                    'mulai_usaha' => $data['mulai_usaha'],
                    'jenis_usaha' => $data['jenis_usaha'],
                    'alamat_usaha' => $data['alamat_usaha']
                ]);
                break;

            case 'sktm':
                DetailSktm::create([
                    'id_surat' => $idSurat,
                    'pendidikan' => $data['pendidikan'],
                    'penghasilan' => $data['penghasilan'],
                    'jumlah_tanggungan' => $data['jumlah_tanggungan'],
                ]);
                break;

            case 'belum-menikah':
                DetailBelumMenikah::create([
                    'id_surat' => $idSurat,
                    'keperluan' => $data['keperluan']
                ]);
                break;

            case 'keterangan-kematian':
                DetailKematian::create([
                    'id_surat' => $idSurat,
                    'nama_almarhum' => $data['nama_almarhum'],
                    'nik_almarhum' => $data['nik_almarhum'],
                    'jenis_kelamin' => $data['jenis_kelamin_almarhum'],
                    'alamat' => $data['alamat_almarhum'],
                    'umur' => $data['umur'],
                    'hari_kematian' => $data['hari_kematian'],
                    'tanggal_kematian' => $data['tanggal_kematian'],
                    'tempat_kematian' => $data['tempat_kematian'],
                    'penyebab_kematian' => $data['penyebab_kematian'],
                    'hubungan_pelapor' => $data['hubungan_pelapor']
                ]);
                break;

            case 'keterangan-kelahiran':
                DetailKelahiran::create([
                    'id_surat' => $idSurat,
                    'nama_anak' => $data['nama_anak'],
                    'jenis_kelamin_anak' => $data['jenis_kelamin_anak'],
                    'hari_lahir' => $data['hari_lahir'],
                    'tanggal_lahir' => $data['tanggal_lahir_anak'],
                    'tempat_lahir' => $data['tempat_lahir_anak'],
                    'penolong_kelahiran' => $data['penolong_kelahiran']
                ]);
                break;

            case 'orang-yang-sama':
                DetailOrangYangSama::create([
                    'id_surat' => $idSurat,
                    'nama_2' => $data['nama_2'],
                    'tempat_lahir_2' => $data['tempat_lahir_2'],
                    'tanggal_lahir_2' => $data['tanggal_lahir_2'],
                    'nama_ayah_2' => $data['nama_ayah_2'],
                    'dasar_dokumen_1' => $data['dasar_dokumen_1'],
                    'dasar_dokumen_2' => $data['dasar_dokumen_2']
                ]);
                break;

            case 'pindah-keluar':
                DetailPindahKeluar::create([
                    'id_surat' => $idSurat,
                    'alamat_tujuan' => $data['alamat_tujuan'],
                    'alasan_pindah' => $data['alasan_pindah'],
                    'tanggal_pindah' => $data['tanggal_pindah']
                ]);
                break;

            case 'domisili-instansi':
                DetailDomisiliInstansi::create([
                    'id_surat' => $idSurat,
                    'nama_instansi' => $data['nama_instansi'],
                    'nama_pimpinan' => $data['nama_pimpinan'],
                    'nip_pimpinan' => $data['nip_pimpinan'],
                    'email_pimpinan' => $data['email_pimpinan'],
                    'alamat_instansi' => $data['alamat_instansi'],
                    'keterangan_lokasi' => $data['keterangan_lokasi']
                ]);
                break;

            case 'domisili-kelompok':
                DetailDomisiliKelompok::create([
                    'id_surat' => $idSurat,
                    'nama_kelompok' => $data['nama_kelompok'],
                    'email_ketua' => $data['email_ketua'],
                    'alamat_kelompok' => $data['alamat_kelompok'],
                    'ketua' => $data['ketua'],
                    'sekretaris' => $data['sekretaris'],
                    'bendahara' => $data['bendahara'],
                    'keterangan_lokasi' => $data['keterangan_lokasi'],
                ]);
                break;

            case 'domisili-orang':
                DetailDomisiliOrang::create([
                    'id_surat' => $idSurat
                ]);
                break;
        }
    }

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

    private function generateNomorSurat($jenisSurat, $idSurat = null)
    {
        $tahun = date('Y');
        $bulan = date('n'); // Get numeric month (1-12)

        // Convert month to Roman numerals
        $romanMonths = [
            1 => 'I',
            2 => 'II',
            3 => 'III',
            4 => 'IV',
            5 => 'V',
            6 => 'VI',
            7 => 'VII',
            8 => 'VIII',
            9 => 'IX',
            10 => 'X',
            11 => 'XI',
            12 => 'XII'
        ];
        $bulanRoman = $romanMonths[$bulan];

        // Count approved letters (disetujui) to generate sequential number
        $approvedCount = Surat::where('status', 'disetujui')->count();
        $nomorUrut = $approvedCount + 1; // Next sequential number

        return sprintf('474/%d/%s/%s', $nomorUrut, $bulanRoman, $tahun);
    }

    private function getTypeSpecificRules($type)
    {
        return match ($type) {
            'skck' => [
                'keperluan' => 'required|string|max:255',
                'tanggal_mulai_berlaku' => 'required|date',
                'tanggal_akhir_berlaku' => 'required|date|after:tanggal_mulai_berlaku',
            ],
            'izin-keramaian' => [
                'keperluan' => 'required|string|max:255',
                'jenis_hiburan' => 'required|string|max:100',
                'tempat_acara' => 'required|string|max:255',
                'hari_acara' => 'required|string|max:50',
                'tanggal_acara' => 'required|date',
                'jumlah_undangan' => 'required|integer|min:1',
            ],
            'keterangan-usaha' => [
                'mulai_usaha' => 'required|date',
                'jenis_usaha' => 'required|string|max:100',
                'alamat_usaha' => 'required|string|max:500',
            ],
            'sktm' => [
                'pendidikan' => 'required|string|max:100',
                'penghasilan' => 'required|numeric|min:0',
                'jumlah_tanggungan' => 'required|integer|min:0',
            ],
            'belum-menikah' => [
                'keperluan' => 'required|string|max:255',
            ],
            'keterangan-kematian' => [
                'nama_almarhum' => 'required|string|max:255',
                'nik_almarhum' => 'required|string|size:16',
                'jenis_kelamin_almarhum' => 'required|in:L,P',
                'alamat_almarhum' => 'required|string|max:500',
                'umur' => 'required|integer|min:0|max:150',
                'hari_kematian' => 'required|string|max:50',
                'tanggal_kematian' => 'required|date',
                'tempat_kematian' => 'required|string|max:255',
                'penyebab_kematian' => 'required|string|max:255',
                'hubungan_pelapor' => 'required|string|max:100',
            ],
            'keterangan-kelahiran' => [
                'nama_anak' => 'required|string|max:255',
                'jenis_kelamin_anak' => 'required|in:L,P',
                'hari_lahir' => 'required|string|max:50',
                'tanggal_lahir_anak' => 'required|date',
                'tempat_lahir_anak' => 'required|string|max:255',
                'penolong_kelahiran' => 'required|string|max:100',
            ],
            'orang-yang-sama' => [
                'nama_2' => 'required|string|max:255',
                'tempat_lahir_2' => 'required|string|max:100',
                'tanggal_lahir_2' => 'required|date',
                'nama_ayah_2' => 'required|string|max:255',
                'dasar_dokumen_1' => 'required|string|max:255',
                'dasar_dokumen_2' => 'required|string|max:255',
            ],
            'pindah-keluar' => [
                'alamat_tujuan' => 'required|string|max:500',
                'alasan_pindah' => 'required|string|max:255',
                'tanggal_pindah' => 'required|date',
                'jenis_kepindahan' => 'required|string|max:100',
                'status_kk' => 'required|string|max:100',
                'klasifikasi_pindah' => 'required|string|max:100',
            ],
            'domisili-instansi' => [
                'nama_instansi' => 'required|string|max:255',
                'nama_pimpinan' => 'required|string|max:255',
                'nip_pimpinan' => 'required|string|max:50',
                'email_pimpinan' => 'required|email|max:255',
                'alamat_instansi' => 'required|string|max:500',
                'keterangan_lokasi' => 'required|string|max:255',
            ],
            'domisili-kelompok' => [
                'nama_kelompok' => 'required|string|max:255',
                'alamat_kelompok' => 'required|string|max:500',
                'ketua' => 'required|string|max:255',
                'email_ketua' => 'required|email|max:255',
                'sekretaris' => 'required|string|max:255',
                'bendahara' => 'required|string|max:255',
                'keterangan_lokasi' => 'required|string|max:255',
            ],
            'domisili-orang' => [
                // No additional fields needed since only id_surat is required
            ],
            default => []
        };
    }
}
