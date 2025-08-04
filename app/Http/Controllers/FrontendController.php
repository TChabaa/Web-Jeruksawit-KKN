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

        return view('components.pages.frontend.layanan-surat.form', [
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
        // Validate the form data based on the surat type
        $request->validate([
            'name' => 'required|string|max:255',
            'nik' => 'required|string|size:16',
            'address' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|email',
            'purpose' => 'required|string',
            'notes' => 'nullable|string',
            'attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        try {
            // Get or create pemohon
            $pemohon = \App\Models\Pemohon::firstOrCreate(
                ['nik' => $request->nik],
                [
                    'nama' => $request->name,
                    'alamat' => $request->address,
                    'no_hp' => $request->phone,
                    'email' => $request->email,
                ]
            );

            // Handle file upload
            $attachmentPath = null;
            if ($request->hasFile('attachment')) {
                $file = $request->file('attachment');
                $filename = time() . '_' . $file->getClientOriginalName();
                $attachmentPath = $file->storeAs('attachments', $filename, 'public');
            }

            // Get jenis surat ID based on type
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

            $jenisSurat = \App\Models\JenisSurat::where('nama', $jenissuratMap[$type])->first();
            if (!$jenisSurat) {
                // Create jenis surat if it doesn't exist
                $jenisSurat = \App\Models\JenisSurat::create([
                    'nama' => $jenissuratMap[$type],
                    'kode' => strtoupper(str_replace('-', '_', $type))
                ]);
            }

            // Create surat record
            $surat = \App\Models\Surat::create([
                'pemohon_id' => $pemohon->id,
                'jenis_surat_id' => $jenisSurat->id,
                'tujuan' => $request->purpose,
                'catatan' => $request->notes,
                'lampiran' => $attachmentPath,
                'status' => 'menunggu',
                'tanggal_pengajuan' => now(),
            ]);

            // Create specific detail record based on type
            $this->createDetailRecord($type, $surat->id, $request);

            Alert::success('Berhasil', 'Permohonan surat berhasil diajukan. Kami akan memproses dan mengirimkan surat ke email Anda.');
            
        } catch (\Exception $e) {
            Alert::error('Gagal', 'Terjadi kesalahan saat mengajukan permohonan. Silakan coba lagi.');
        }

        return redirect()->route('layanan-surat');
    }

    /**
     * Create specific detail record based on surat type
     */
    private function createDetailRecord($type, $suratId, $request)
    {
        switch ($type) {
            case 'sktm':
                \App\Models\DetailSktm::create([
                    'surat_id' => $suratId,
                    'keperluan' => $request->purpose,
                ]);
                break;
            
            case 'belum-menikah':
                \App\Models\DetailBelumMenikah::create([
                    'surat_id' => $suratId,
                    'keperluan' => $request->purpose,
                ]);
                break;
            
            case 'keterangan-kematian':
                \App\Models\DetailKematian::create([
                    'surat_id' => $suratId,
                    'keperluan' => $request->purpose,
                ]);
                break;
            
            case 'keterangan-kelahiran':
                \App\Models\DetailKelahiran::create([
                    'surat_id' => $suratId,
                    'keperluan' => $request->purpose,
                ]);
                break;
            
            case 'orang-yang-sama':
                \App\Models\DetailOrangYangSama::create([
                    'surat_id' => $suratId,
                    'keperluan' => $request->purpose,
                ]);
                break;
            
            case 'pindah-keluar':
                \App\Models\DetailPindahKeluar::create([
                    'surat_id' => $suratId,
                    'keperluan' => $request->purpose,
                ]);
                break;
            
            case 'domisili-instansi':
                \App\Models\DetailDomisiliInstansi::create([
                    'surat_id' => $suratId,
                    'keperluan' => $request->purpose,
                ]);
                break;
            
            case 'domisili-kelompok':
                \App\Models\DetailDomisiliKelompok::create([
                    'surat_id' => $suratId,
                    'keperluan' => $request->purpose,
                ]);
                break;
            
            case 'skck':
                \App\Models\DetailSkck::create([
                    'surat_id' => $suratId,
                    'keperluan' => $request->purpose,
                ]);
                break;
            
            case 'izin-keramaian':
                \App\Models\DetailIzinKeramaian::create([
                    'surat_id' => $suratId,
                    'keperluan' => $request->purpose,
                ]);
                break;
            
            case 'keterangan-usaha':
                \App\Models\DetailKeteranganUsaha::create([
                    'surat_id' => $suratId,
                    'keperluan' => $request->purpose,
                ]);
                break;
        }
    }
}
