<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SuratOrangYangSamaRequest extends FormRequest
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
            
            // Detail Orang yang Sama
            'nama_2' => 'required|string|max:255',
            'tempat_lahir_2' => 'required|string|max:100',
            'tanggal_lahir_2' => 'required|date',
            'nama_ayah_2' => 'required|string|max:255',
            'dasar_dokumen_1' => 'required|string|max:255',
            'dasar_dokumen_2' => 'required|string|max:255',
            
            // General
            'purpose' => 'required|string|max:255',
            'notes' => 'nullable|string|max:1000',
            'attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'nama_2.required' => 'Nama kedua wajib diisi',
            'tempat_lahir_2.required' => 'Tempat lahir kedua wajib diisi',
            'tanggal_lahir_2.required' => 'Tanggal lahir kedua wajib diisi',
            'nama_ayah_2.required' => 'Nama ayah kedua wajib diisi',
            'dasar_dokumen_1.required' => 'Dasar dokumen pertama wajib diisi',
            'dasar_dokumen_2.required' => 'Dasar dokumen kedua wajib diisi',
        ];
    }
}