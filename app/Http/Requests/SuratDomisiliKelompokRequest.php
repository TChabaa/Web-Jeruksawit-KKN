<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SuratDomisiliKelompokRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Data Pemohon
            'name' => 'required|string|max:255',
            'nik' => 'required|string|size:16',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'address' => 'required|string|max:500',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'agama' => 'required|string|max:50',
            'pekerjaan' => 'required|string|max:100',
            'status_perkawinan' => 'required|string|max:50',

            // Detail Domisili Kelompok
            'nama_kelompok' => 'required|string|max:255',
            'email_ketua' => 'required|email|max:255',
            'alamat_kelompok' => 'required|string|max:500',
            'ketua' => 'required|string|max:255',
            'sekretaris' => 'required|string|max:255',
            'bendahara' => 'required|string|max:255',
            'keterangan_lokasi' => 'required|string|max:500',

            // General
            'purpose' => 'required|string|max:255',
            'notes' => 'nullable|string|max:1000',
            'attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:4146176',
        ];
    }

    public function messages(): array
    {
        return [
            'nama_kelompok.required' => 'Nama kelompok wajib diisi',
            'email_ketua.required' => 'Email ketua wajib diisi',
            'alamat_kelompok.required' => 'Alamat kelompok wajib diisi',
            'ketua.required' => 'Nama ketua wajib diisi',
            'sekretaris.required' => 'Nama sekretaris wajib diisi',
            'bendahara.required' => 'Nama bendahara wajib diisi',
            'keterangan_lokasi.required' => 'Keterangan lokasi wajib diisi',
        ];
    }
}
