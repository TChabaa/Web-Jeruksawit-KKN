<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SuratKeteranganUsahaRequest extends FormRequest
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

            // Detail Keterangan Usaha
            'mulai_usaha' => 'required|date',
            'jenis_usaha' => 'required|string|max:255',
            'alamat_usaha' => 'required|string|max:500',

            // General
            'purpose' => 'required|string|max:255',
            'notes' => 'nullable|string|max:1000',
            'attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:4146176',
        ];
    }

    public function messages(): array
    {
        return [
            'mulai_usaha.required' => 'Tanggal mulai usaha wajib diisi',
            'jenis_usaha.required' => 'Jenis usaha wajib diisi',
            'alamat_usaha.required' => 'Alamat usaha wajib diisi',
        ];
    }
}
