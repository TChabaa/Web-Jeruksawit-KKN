<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
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
use Yajra\DataTables\Facades\DataTables;

class LayananSuratController extends Controller
{
    /**
     * Display the admin dashboard for letter services
     */
    public function index()
    {
        if (request()->ajax()) {
            $surat = Surat::with(['pemohon', 'jenisSurat'])->latest();

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
                    $statusClass = match($item->status) {
                        'belum_diverifikasi' => 'bg-yellow-100 text-yellow-800',
                        'disetujui' => 'bg-green-100 text-green-800',
                        'ditolak' => 'bg-red-100 text-red-800',
                        default => 'bg-gray-100 text-gray-800'
                    };
                    
                    $statusText = match($item->status) {
                        'belum_diverifikasi' => 'Belum Diverifikasi',
                        'disetujui' => 'Disetujui',
                        'ditolak' => 'Ditolak',
                        default => 'Unknown'
                    };
                    
                    return '<span class="px-2 py-1 text-xs font-medium rounded-full ' . $statusClass . '">' . $statusText . '</span>';
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

        return view('components.pages.dashboard.admin.layanan-surat.index');
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
            'skck', 'izin-keramaian', 'keterangan-usaha', 'sktm', 'belum-menikah',
            'keterangan-kematian', 'keterangan-kelahiran', 'orang-yang-sama',
            'pindah-keluar', 'domisili-instansi', 'domisili-kelompok'
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
            'domisili-kelompok' => 'Domisili Kelompok'
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
            'purpose' => 'required|string|max:255',
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
            
            // Create surat
            $surat = $this->createSurat($pemohon->id_pemohon, $jenisSurat->id_jenis, $validatedData);
            
            // Create detail surat based on type
            $this->createDetailSurat($type, $surat->id_surat, $validatedData);
            
            DB::commit();
            
            $roleName = Auth::user()->role ?? 'admin';
            
            return redirect()->route($roleName . '.layanan-surat')
                ->with('success', 'Permohonan surat berhasil diajukan.');
                
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

        $surat = Surat::findOrFail($id);
        $surat->status = $request->status;
        
        if ($request->status === 'disetujui' && !$surat->nomor_surat) {
            $surat->nomor_surat = $this->generateNomorSurat($surat->jenisSurat->nama_jenis, $surat->id_surat);
            $surat->tanggal_surat = now();
        }
        
        $surat->save();

        $statusText = $request->status === 'disetujui' ? 'disetujui' : 'ditolak';
        
        return redirect()->back()->with('success', "Surat berhasil {$statusText}.");
    }

    // Private helper methods
    private function getRequestClass($type)
    {
        return match($type) {
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
            default => throw new \Exception('Invalid surat type')
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
            'domisili-kelompok' => 'Domisili Kelompok'
        ];

        return JenisSurat::where('nama_jenis', $typeMapping[$type])->firstOrFail();
    }

    private function createSurat($idPemohon, $idJenis, $data)
    {
        return Surat::create([
            'id_pemohon' => $idPemohon,
            'id_jenis' => $idJenis,
            'created_by' => Auth::id(),
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
                    'pendidikan' => $data['pendidikan']
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
                    'bidang_usaha' => $data['bidang_usaha'],
                    'jabatan' => $data['jabatan'],
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
                    'jenis_kelompok' => $data['jenis_kelompok'],
                    'jumlah_anggota' => $data['jumlah_anggota'],
                    'keterangan_lokasi' => $data['keterangan_lokasi'],
                    'tujuan_pembentukan' => $data['tujuan_pembentukan']
                ]);
                break;
        }
    }

    private function getDetailSurat($surat)
    {
        $jenis = $surat->jenisSurat->nama_jenis;
        
        return match($jenis) {
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
            default => null
        };
    }

    private function generateNomorSurat($jenisSurat, $idSurat = null)
    {
        $tahun = date('Y');
        $bulan = date('n'); // Get numeric month (1-12)
        
        // Convert month to Roman numerals
        $romanMonths = [
            1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V', 6 => 'VI',
            7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII'
        ];
        $bulanRoman = $romanMonths[$bulan];
        
        // Use the provided id_surat or get the latest one
        if (!$idSurat) {
            $lastSurat = Surat::latest('id_surat')->first();
            $idSurat = $lastSurat ? $lastSurat->id_surat : 1;
        }
        
        return sprintf('474/%d/%s/%s', $idSurat, $bulanRoman, $tahun);
    }

    private function getTypeSpecificRules($type)
    {
        return match($type) {
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
                'bidang_usaha' => 'required|string|max:100',
                'jabatan' => 'required|string|max:100',
                'keterangan_lokasi' => 'required|string|max:255',
            ],
            'domisili-kelompok' => [
                'nama_kelompok' => 'required|string|max:255',
                'alamat_kelompok' => 'required|string|max:500',
                'ketua' => 'required|string|max:255',
                'email_ketua' => 'required|email|max:255',
                'sekretaris' => 'required|string|max:255',
                'bendahara' => 'required|string|max:255',
                'jenis_kelompok' => 'required|string|max:100',
                'jumlah_anggota' => 'required|integer|min:3',
                'keterangan_lokasi' => 'required|string|max:255',
                'tujuan_pembentukan' => 'required|string|max:1000',
            ],
            default => []
        };
    }
}
