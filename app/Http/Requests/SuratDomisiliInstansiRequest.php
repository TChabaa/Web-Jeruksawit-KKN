<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SuratDomisiliInstansiRequest extends FormRequest
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
            
            // Detail Domisili Instansi
            'nama_instansi' => 'required|string|max:255',
            'alamat_instansi' => 'required|string|max:500',
            'jabatan' => 'required|string|max:255',
            'bidang_usaha' => 'required|string|max:255',
            'keterangan_lokasi' => 'required|string|max:500',
            
            // General
            'purpose' => 'required|string|max:255',
            'notes' => 'nullable|string|max:1000',
            'attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'nama_instansi.required' => 'Nama instansi wajib diisi',
            'alamat_instansi.required' => 'Alamat instansi wajib diisi',
            'jabatan.required' => 'Jabatan wajib diisi',
            'bidang_usaha.required' => 'Bidang usaha wajib diisi',
            'keterangan_lokasi.required' => 'Keterangan lokasi wajib diisi',
        ];
    }
}