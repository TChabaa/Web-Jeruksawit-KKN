<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
use App\Jobs\ProcessSuratApproval;
use App\Jobs\ProcessSuratRejection;
use App\Jobs\ProcessSuratSubmission;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

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
            'nik' => 'required|string|size:16|regex:/^[0-9]{16}$/',
            'nomor_kk' => 'required|string|size:16|regex:/^[0-9]{16}$/',
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

        // Custom validation messages
        $messages = [
            'nik.size' => 'NIK (Nomor Induk Kependudukan) harus terdiri dari 16 digit angka.',
            'nik.regex' => 'NIK (Nomor Induk Kependudukan) hanya boleh berisi angka dan harus 16 digit.',
            'nomor_kk.size' => 'Nomor Kartu Keluarga harus terdiri dari 16 digit angka.',
            'nomor_kk.regex' => 'Nomor Kartu Keluarga hanya boleh berisi angka dan harus 16 digit.',
        ];

        // Add type-specific validation rules
        $typeSpecificRules = $this->getTypeSpecificRules($type);
        $rules = array_merge($basicRules, $typeSpecificRules);

        $validatedData = $request->validate($rules, $messages);

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

            // Queue email sending for better performance
            ProcessSuratSubmission::dispatch($surat->id_surat, $pemohon->id_pemohon)
                ->delay(now()->addSeconds(5)); // Small delay to ensure DB commit

            Log::info('Surat submission queued for email processing', [
                'surat_id' => $surat->id_surat,
                'email' => $pemohon->email
            ]);

            // Handle redirect based on authentication status
            if (Auth::check()) {
                $roleName = Auth::user()->role ?? 'admin';
                Alert::toast('Permohonan surat berhasil diajukan', 'success');
                return redirect()->route($roleName . '.layanan-surat.create');
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

        // Get detail based on type using PDFController
        $pdfController = new \App\Http\Controllers\PDFController();
        $detail = $pdfController->getDetailSurat($surat);

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

        // Queue PDF generation and email sending for better performance
        if ($request->status === 'disetujui') {
            // Queue approval processing (PDF generation + email)
            ProcessSuratApproval::dispatch($surat->id_surat)
                ->delay(now()->addSeconds(10)); // Small delay to ensure DB commit

            $statusText = 'disetujui dan sedang diproses untuk pengiriman PDF via email';

            Log::info('Surat approval queued for processing', [
                'surat_id' => $surat->id_surat,
                'email' => $surat->pemohon->email
            ]);
        } else {
            // Queue rejection email
            ProcessSuratRejection::dispatch($surat->id_surat, $request->catatan)
                ->delay(now()->addSeconds(5)); // Faster processing for rejections

            $statusText = 'ditolak dan sedang diproses untuk pengiriman email pemberitahuan';

            Log::info('Surat rejection queued for processing', [
                'surat_id' => $surat->id_surat,
                'email' => $surat->pemohon->email
            ]);
        }

        return redirect()->back()->with('success', "Surat berhasil {$statusText}.");
    }

    /**
     * Download PDF for approved surat
     */
    public function downloadPdf($id)
    {
        // Delegate to PDFController for consistent PDF generation
        $pdfController = new \App\Http\Controllers\PDFController();
        return $pdfController->generatePDF(new \Illuminate\Http\Request(), $id);
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
                    'penolong_kelahiran' => $data['penolong_kelahiran'],
                    'ibu' => $data['ibu'], // Default value if not provided
                    'ayah' => $data['ayah'] // Default value
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
                    'id_surat' => $idSurat,
                    'keperluan' => $data['keperluan'],
                ]);
                break;
        }
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
                'ibu' => 'required|string|max:255',
                'ayah' => 'required|string|max:255',
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
                'keperluan' => 'required|string|max:255',
            ],
            default => []
        };
    }
}
