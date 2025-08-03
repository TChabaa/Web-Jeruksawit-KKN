<?php

namespace App\Http\Controllers;

use App\Models\Event;
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
        $events = Event::limit(3)->latest()->get();

        $articles = Article::with('user')->limit(3)->latest()->get();
        $umkms = Umkm::with('gambarUmkm')->limit(3)->latest()->get();

        return view('components.pages.frontend.index', compact('destinations', 'events', 'articles', 'umkms'));
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

    public function events(Request $request)
    {
        $newEvents = Event::limit(5)->latest()->get();

        $events = Event::query();
        if ($request->has('keyword')) {
            $events = $events->where('name', 'like', '%' . $request->keyword . '%');
        }

        $events = $events->paginate(8);
        return view('components.pages.frontend.event', compact('newEvents', 'events'));
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

        // Process the form submission
        // This is a placeholder for actual processing logic

        // Redirect back with success message
        return redirect()->route('layanan-surat')
            ->with('success', 'Permohonan surat berhasil diajukan. Kami akan memproses dan mengirimkan surat ke email Anda.');
    }
}
