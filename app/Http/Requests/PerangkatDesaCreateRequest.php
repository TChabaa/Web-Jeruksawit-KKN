<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PerangkatDesaCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nama' => ['required', 'string', 'max:255'],
            'jabatan' => ['required', 'string', 'max:255'],
            'gambar' => ['nullable', 'image', 'mimes:jpeg,jpg,png', 'max:1024'], // 1MB max
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'nama.required' => 'Nama perangkat desa harus diisi',
            'nama.max' => 'Nama perangkat desa maksimal 255 karakter',
            'jabatan.required' => 'Jabatan harus diisi',
            'jabatan.max' => 'Jabatan maksimal 255 karakter',
            'gambar.image' => 'File harus berupa gambar',
            'gambar.mimes' => 'Gambar harus berformat jpeg, jpg, atau png',
            'gambar.max' => 'Ukuran gambar maksimal 1MB',
        ];
    }
}
