<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SuratIzinKeramaianRequest extends FormRequest
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

            // Detail Izin Keramaian
            'keperluan' => 'required|string|max:255',
            'jenis_hiburan' => 'required|string|max:255',
            'tempat_acara' => 'required|string|max:255',
            'hari_acara' => 'required|string|max:50',
            'tanggal_acara' => 'required|date',
            'jumlah_undangan' => 'required|integer|min:1',

            // General
            'purpose' => 'required|string|max:255',
            'notes' => 'nullable|string|max:1000',
            'attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:4146176',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama lengkap wajib diisi',
            'nik.required' => 'NIK wajib diisi',
            'nik.size' => 'NIK harus 16 digit',
            'keperluan.required' => 'Keperluan wajib diisi',
            'jenis_hiburan.required' => 'Jenis hiburan wajib diisi',
            'tempat_acara.required' => 'Tempat acara wajib diisi',
            'hari_acara.required' => 'Hari acara wajib diisi',
            'tanggal_acara.required' => 'Tanggal acara wajib diisi',
            'jumlah_undangan.required' => 'Jumlah undangan wajib diisi',
            'jumlah_undangan.integer' => 'Jumlah undangan harus berupa angka',
            'jumlah_undangan.min' => 'Jumlah undangan minimal 1',
        ];
    }
}
