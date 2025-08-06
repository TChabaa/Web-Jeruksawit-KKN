<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SuratKeteranganKematianRequest extends FormRequest
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

            // Detail Keterangan Kematian
            'nama_almarhum' => 'required|string|max:255',
            'nik_almarhum' => 'required|string|size:16',
            'jenis_kelamin_almarhum' => 'required|in:L,P',
            'alamat_almarhum' => 'required|string|max:500',
            'umur' => 'required|integer|min:0|max:150',
            'hari_kematian' => 'required|string|max:50',
            'tanggal_kematian' => 'required|date',
            'tempat_kematian' => 'required|string|max:255',
            'penyebab_kematian' => 'required|string|max:255',
            'hubungan_pelapor' => 'required|string|max:100',

            // General
            'keperluan' => 'required|string|max:255',
            'notes' => 'nullable|string|max:1000',
            'attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'nama_almarhum.required' => 'Nama almarhum wajib diisi',
            'nik_almarhum.required' => 'NIK almarhum wajib diisi',
            'jenis_kelamin_almarhum.required' => 'Jenis kelamin almarhum wajib dipilih',
            'alamat_almarhum.required' => 'Alamat almarhum wajib diisi',
            'umur.required' => 'Umur almarhum wajib diisi',
            'hari_kematian.required' => 'Hari kematian wajib diisi',
            'tanggal_kematian.required' => 'Tanggal kematian wajib diisi',
            'tempat_kematian.required' => 'Tempat kematian wajib diisi',
            'penyebab_kematian.required' => 'Penyebab kematian wajib diisi',
            'hubungan_pelapor.required' => 'Hubungan pelapor wajib diisi',
        ];
    }
}
