<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SuratKeteranganKelahiranRequest extends FormRequest
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
            
            // Detail Keterangan Kelahiran
            'nama_anak' => 'required|string|max:255',
            'jenis_kelamin_anak' => 'required|in:L,P',
            'hari_lahir' => 'required|string|max:50',
            'tanggal_lahir_anak' => 'required|date',
            'tempat_lahir_anak' => 'required|string|max:255',
            'penolong_kelahiran' => 'required|string|max:255',
            
            // General
            'purpose' => 'required|string|max:255',
            'notes' => 'nullable|string|max:1000',
            'attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'nama_anak.required' => 'Nama anak wajib diisi',
            'jenis_kelamin_anak.required' => 'Jenis kelamin anak wajib dipilih',
            'hari_lahir.required' => 'Hari lahir wajib diisi',
            'tanggal_lahir_anak.required' => 'Tanggal lahir anak wajib diisi',
            'tempat_lahir_anak.required' => 'Tempat lahir anak wajib diisi',
            'penolong_kelahiran.required' => 'Penolong kelahiran wajib diisi',
        ];
    }
}