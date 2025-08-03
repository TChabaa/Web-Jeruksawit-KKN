<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class UmkmUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'name_destination' => 'required|string|min:5|max:50',
            'description' => 'required|string',
            'location' => 'required|string',
            'gmaps_url' => 'required|string|url:http,https',
        ];

        if (Auth::user()->role !== 'owner') {
            $rules['owner'] = 'required';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'name_destination.required' => 'Nama UMKM harus diisi.',
            'name_destination.min' => 'Nama UMKM minimal 5 karakter.',
            'name_destination.max' => 'Nama UMKM maksimal 50 karakter.',
            'description.required' => 'Deskripsi harus diisi.',
            'location.required' => 'Lokasi harus diisi.',
            'gmaps_url.required' => 'URL Google Maps harus diisi.',
            'gmaps_url.url' => 'URL Google Maps harus berupa URL yang valid.',
        ];
    }
}
