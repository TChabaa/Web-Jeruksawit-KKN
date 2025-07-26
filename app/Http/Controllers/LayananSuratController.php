<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LayananSuratController extends Controller
{
    /**
     * Display the layanan surat menyurat page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('layanan-surat.index');
    }

    /**
     * Display the form for a specific surat type.
     *
     * @param  string  $type
     * @return \Illuminate\View\View
     */
    public function showForm($type)
    {
        // Validate the surat type
        $validTypes = [
            'skck', 'izin-keramaian', 'keterangan-usaha', 'sktm', 'belum-menikah',
            'keterangan-kematian', 'keterangan-kelahiran', 'orang-yang-sama',
            'pindah-keluar', 'domisili-instansi', 'domisili-kelompok'
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

        return view('layanan-surat.form', [
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
    public function submitForm(Request $request, $type)
    {
        // Validate the form data based on the surat type
        // This is a placeholder for actual validation logic
        $request->validate([
            'name' => 'required|string|max:255',
            'nik' => 'required|string|size:16',
            'address' => 'required|string',
            // Add more validation rules as needed for each type
        ]);

        // Process the form submission
        // This is a placeholder for actual processing logic

        // Redirect back with success message
        return redirect()->route(auth()->user()->role . '.layanan-surat')
            ->with('success', 'Permohonan surat berhasil diajukan. Kami akan memproses dan mengirimkan surat ke email Anda.');
    }
}
