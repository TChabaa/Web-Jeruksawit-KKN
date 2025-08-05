<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SuratSkckRequest extends FormRequest
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
            
            // Detail SKCK
            'keperluan' => 'required|string|max:255',
            'tanggal_mulai_berlaku' => 'required|date',
            'tanggal_akhir_berlaku' => 'required|date|after:tanggal_mulai_berlaku',
            
            // General
            'purpose' => 'required|string|max:255',
            'notes' => 'nullable|string|max:1000',
            'attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama lengkap wajib diisi',
            'nik.required' => 'NIK wajib diisi',
            'nik.size' => 'NIK harus 16 digit',
            'phone.required' => 'Nomor telepon wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'address.required' => 'Alamat wajib diisi',
            'tempat_lahir.required' => 'Tempat lahir wajib diisi',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih',
            'agama.required' => 'Agama wajib diisi',
            'pekerjaan.required' => 'Pekerjaan wajib diisi',
            'status_perkawinan.required' => 'Status perkawinan wajib diisi',
            'keperluan.required' => 'Keperluan wajib diisi',
            'tanggal_mulai_berlaku.required' => 'Tanggal mulai berlaku wajib diisi',
            'tanggal_akhir_berlaku.required' => 'Tanggal akhir berlaku wajib diisi',
            'tanggal_akhir_berlaku.after' => 'Tanggal akhir berlaku harus setelah tanggal mulai berlaku',
            'purpose.required' => 'Tujuan pengajuan wajib diisi',
            'attachment.mimes' => 'File harus berformat PDF, JPG, JPEG, atau PNG',
            'attachment.max' => 'Ukuran file maksimal 2MB',
        ];
    }
}