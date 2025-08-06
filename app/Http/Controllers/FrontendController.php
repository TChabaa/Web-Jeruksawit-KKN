<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\Destination;
use App\Models\Article;
use App\Models\Umkm;
use App\Models\User;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class FrontendController extends Controller
{
    public function index()
    {
        $destinations = Destination::with('galleries')->limit(3)->latest()->get();
        $articles = Article::with('user')->limit(3)->latest()->get();
        $umkms = Umkm::with('gambarUmkm')->limit(3)->latest()->get();
        $perangkatDesas = \App\Models\PerangkatDesa::limit(8)->latest()->get(); // For carousel

        return view('components.pages.frontend.index', compact('destinations', 'articles', 'umkms', 'perangkatDesas'));
    }

    public function destinations(Request $request)
    {
        $destinations = Destination::with(['galleries'])->latest();
        if ($request->has('keyword')) {
            $destinations = $destinations->where('name', 'like', '%' . $request->keyword . '%');
        }

        $destinations = $destinations->paginate(8);
        return view('components.pages.frontend.destination', compact('destinations'));
    }

    public function articles(Request $request)
    {
        $articles = Article::with('user')->latest();
        if ($request->has('keyword')) {
            $articles = $articles->where('title', 'like', '%' . $request->keyword . '%');
        }

        $articles = $articles->paginate(8);
        return view('components.pages.frontend.article', compact('articles'));
    }

    public function umkm(Request $request)
    {
        $umkms = Umkm::with(['gambarUmkm'])->latest();
        if ($request->has('keyword')) {
            $umkms = $umkms->where('nama', 'like', '%' . $request->keyword . '%');
        }

        $umkms = $umkms->paginate(8);
        return view('components.pages.frontend.umkm', compact('umkms'));
    }

    public function galleries()
    {
        $galleries = Gallery::with('destination')->latest()->paginate(8);

        return view('components.pages.frontend.gallery', compact('galleries'));
    }

    public function aboutUs()
    {
        $perangkatDesas = \App\Models\PerangkatDesa::latest()->get(); // For list display

        return view('components.pages.frontend.about-us-page', compact('perangkatDesas'));
    }

    /**
     * Display the layanan surat menyurat page.
     *
     * @return \Illuminate\View\View
     */
    public function layananSurat()
    {
        return view('components.pages.frontend.layanan-surat.index');
    }

    /**
     * Display the form for a specific surat type.
     *
     * @param  string  $type
     * @return \Illuminate\View\View
     */
    public function layananSuratForm($type)
    {
        // Validate the surat type
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
            'domisili-kelompok'
        ];

        if (!in_array($type, $validTypes)) {
            abort(404, 'Jenis surat tidak ditemukan');
        }

        // Map the type to a readable title
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

        // Load the specific form view for the surat type
        return view('components.pages.frontend.layanan-surat.form.' . str_replace('-', '_', $type), [
            'type' => $type,
            'title' => $titles[$type]
        ]);
    }

    /**
     * Process the surat request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $type
     * @return \Illuminate\Http\RedirectResponse
     */
    public function layananSuratSubmit(Request $request, $type)
    {
        // Use the same validation as LayananSuratController
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

        try {
            // Create or update pemohon with correct field names
            $pemohon = \App\Models\Pemohon::updateOrCreate(
                ['nik' => $validatedData['nik']],
                [
                    'nomor_kk' => $validatedData['nomor_kk'],
                    'nama_lengkap' => $validatedData['name'],
                    'email' => $validatedData['email'],
                    'tempat_lahir' => $validatedData['tempat_lahir'],
                    'tanggal_lahir' => $validatedData['tanggal_lahir'],
                    'jenis_kelamin' => $validatedData['jenis_kelamin'],
                    'kewarganegaraan' => 'Indonesia',
                    'agama' => $validatedData['agama'],
                    'status_perkawinan' => $validatedData['status_perkawinan'],
                    'pekerjaan' => $validatedData['pekerjaan'],
                    'alamat' => $validatedData['address'],
                ]
            );

            // Get jenis surat using correct field name
            $jenissuratMap = [
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

            $jenisSurat = \App\Models\JenisSurat::where('nama_jenis', $jenissuratMap[$type])->first();
            if (!$jenisSurat) {
                // Create jenis surat if it doesn't exist
                $jenisSurat = \App\Models\JenisSurat::create([
                    'nama_jenis' => $jenissuratMap[$type],
                    'kode_jenis' => strtoupper(str_replace('-', '_', $type))
                ]);
            }

            // Create surat record with correct field names
            $surat = \App\Models\Surat::create([
                'id_pemohon' => $pemohon->id_pemohon,
                'id_jenis' => $jenisSurat->id_jenis,
                'status' => 'belum_diverifikasi'
            ]);

            // Create specific detail record based on type
            $this->createDetailRecord($type, $surat->id_surat, $validatedData);

            Alert::success('Berhasil', 'Permohonan surat berhasil diajukan. Kami akan memproses dan mengirimkan surat ke email Anda.');
        } catch (\Exception $e) {
            Alert::error('Gagal', 'Terjadi kesalahan saat mengajukan permohonan: ' . $e->getMessage());
        }

        return redirect()->route('layanan-surat');
    }

    /**
     * Create specific detail record based on surat type
     */
    private function createDetailRecord($type, $suratId, $validatedData)
    {
        switch ($type) {
            case 'skck':
                \App\Models\DetailSkck::create([
                    'id_surat' => $suratId,
                    'keperluan' => $validatedData['keperluan'],
                    'tanggal_mulai_berlaku' => $validatedData['tanggal_mulai_berlaku'] ?? null,
                    'tanggal_akhir_berlaku' => $validatedData['tanggal_akhir_berlaku'] ?? null
                ]);
                break;

            case 'izin-keramaian':
                \App\Models\DetailIzinKeramaian::create([
                    'id_surat' => $suratId,
                    'keperluan' => $validatedData['keperluan'],
                    'jenis_hiburan' => $validatedData['jenis_hiburan'] ?? null,
                    'tempat_acara' => $validatedData['tempat_acara'] ?? null,
                    'hari_acara' => $validatedData['hari_acara'] ?? null,
                    'tanggal_acara' => $validatedData['tanggal_acara'] ?? null,
                    'jumlah_undangan' => $validatedData['jumlah_undangan'] ?? null
                ]);
                break;

            case 'keterangan-usaha':
                \App\Models\DetailKeteranganUsaha::create([
                    'id_surat' => $suratId,
                    'mulai_usaha' => $validatedData['mulai_usaha'] ?? null,
                    'jenis_usaha' => $validatedData['jenis_usaha'] ?? null,
                    'alamat_usaha' => $validatedData['alamat_usaha'] ?? null
                ]);
                break;

            case 'sktm':
                \App\Models\DetailSktm::create([
                    'id_surat' => $suratId,
                    'pendidikan' => $validatedData['pendidikan'] ?? null,
                    'penghasilan' => $validatedData['penghasilan'] ?? null,
                    'jumlah_tanggungan' => $validatedData['jumlah_tanggungan'] ?? null,
                ]);
                break;

            case 'belum-menikah':
                \App\Models\DetailBelumMenikah::create([
                    'id_surat' => $suratId,
                    'keperluan' => $validatedData['keperluan']
                ]);
                break;

            case 'keterangan-kematian':
                \App\Models\DetailKematian::create([
                    'id_surat' => $suratId,
                    'nama_almarhum' => $validatedData['nama_almarhum'] ?? null,
                    'nik_almarhum' => $validatedData['nik_almarhum'] ?? null,
                    'jenis_kelamin' => $validatedData['jenis_kelamin_almarhum'] ?? null,
                    'alamat' => $validatedData['alamat_almarhum'] ?? null,
                    'umur' => $validatedData['umur'] ?? null,
                    'hari_kematian' => $validatedData['hari_kematian'] ?? null,
                    'tanggal_kematian' => $validatedData['tanggal_kematian'] ?? null,
                    'tempat_kematian' => $validatedData['tempat_kematian'] ?? null,
                    'penyebab_kematian' => $validatedData['penyebab_kematian'] ?? null,
                    'hubungan_pelapor' => $validatedData['hubungan_pelapor'] ?? null
                ]);
                break;

            case 'keterangan-kelahiran':
                \App\Models\DetailKelahiran::create([
                    'id_surat' => $suratId,
                    'nama_anak' => $validatedData['nama_anak'] ?? null,
                    'jenis_kelamin_anak' => $validatedData['jenis_kelamin_anak'] ?? null,
                    'hari_lahir' => $validatedData['hari_lahir'] ?? null,
                    'tanggal_lahir' => $validatedData['tanggal_lahir_anak'] ?? null,
                    'tempat_lahir' => $validatedData['tempat_lahir_anak'] ?? null,
                    'penolong_kelahiran' => $validatedData['penolong_kelahiran'] ?? null
                ]);
                break;

            case 'orang-yang-sama':
                \App\Models\DetailOrangYangSama::create([
                    'id_surat' => $suratId,
                    'nama_2' => $validatedData['nama_2'] ?? null,
                    'tempat_lahir_2' => $validatedData['tempat_lahir_2'] ?? null,
                    'tanggal_lahir_2' => $validatedData['tanggal_lahir_2'] ?? null,
                    'nama_ayah_2' => $validatedData['nama_ayah_2'] ?? null,
                    'dasar_dokumen_1' => $validatedData['dasar_dokumen_1'] ?? null,
                    'dasar_dokumen_2' => $validatedData['dasar_dokumen_2'] ?? null
                ]);
                break;

            case 'pindah-keluar':
                \App\Models\DetailPindahKeluar::create([
                    'id_surat' => $suratId,
                    'alamat_tujuan' => $validatedData['alamat_tujuan'] ?? null,
                    'alasan_pindah' => $validatedData['alasan_pindah'] ?? null,
                    'tanggal_pindah' => $validatedData['tanggal_pindah'] ?? null
                ]);
                break;

            case 'domisili-instansi':
                \App\Models\DetailDomisiliInstansi::create([
                    'id_surat' => $suratId,
                    'nama_instansi' => $validatedData['nama_instansi'] ?? null,
                    'nama_pimpinan' => $validatedData['nama_pimpinan'] ?? null,
                    'nip_pimpinan' => $validatedData['nip_pimpinan'] ?? null,
                    'email_pimpinan' => $validatedData['email_pimpinan'] ?? null,
                    'alamat_instansi' => $validatedData['alamat_instansi'] ?? null,
                    'bidang_usaha' => $validatedData['bidang_usaha'] ?? null,
                    'jabatan' => $validatedData['jabatan'] ?? null,
                    'keterangan_lokasi' => $validatedData['keterangan_lokasi'] ?? null
                ]);
                break;

            case 'domisili-kelompok':
                \App\Models\DetailDomisiliKelompok::create([
                    'id_surat' => $suratId,
                    'nama_kelompok' => $validatedData['nama_kelompok'] ?? null,
                    'email_ketua' => $validatedData['email_ketua'] ?? null,
                    'alamat_kelompok' => $validatedData['alamat_kelompok'] ?? null,
                    'ketua' => $validatedData['ketua'] ?? null,
                    'sekretaris' => $validatedData['sekretaris'] ?? null,
                    'bendahara' => $validatedData['bendahara'] ?? null,
                    'jenis_kelompok' => $validatedData['jenis_kelompok'] ?? null,
                    'jumlah_anggota' => $validatedData['jumlah_anggota'] ?? null,
                    'keterangan_lokasi' => $validatedData['keterangan_lokasi'] ?? null,
                    'tujuan_pembentukan' => $validatedData['tujuan_pembentukan'] ?? null
                ]);
                break;
        }
    }

    /**
     * Get type-specific validation rules for surat request
     */
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
