<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class UmkmCreateRequest extends FormRequest
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
        return [
            'name_destination' => 'required|string|min:5|max:50',
            'description' => 'required|string',
            'location' => 'required|string',
            'gmaps_url' => 'required|string|url:http,https',
            'opening_hours' => 'array',
            'opening_hours.first_day' => 'required|string|in:senin,selasa,rabu,kamis,jumat,sabtu,minggu',
            'opening_hours.last_day' => 'required|string|in:senin,selasa,rabu,kamis,jumat,sabtu,minggu',
            'opening_hours.open' => 'required|string|date_format:H:i',
            'opening_hours.close' => 'required|string|date_format:H:i',
            'galleries.*' => 'required|image|mimes:jpeg,png,jpg|max:4146|',
            'contact_details' => 'array',
            'contact_details.phone' => 'nullable|string|max:20',
            'contact_details.email' => 'nullable|string|max:50',
            'contact_details.social_media' => 'nullable|string|max:100',
        ];
    }

    public function messages()
    {
        return [
            'opening_hours.first_day.in' => 'Jangan masukkan hari lain!',
            'opening_hours.last_day.in' => 'Jangan masukkan hari lain!',
            'opening_hours.open.required_with' => 'Jam buka harus diisi!',
            'opening_hours.close.required_with' => 'Jam tutup harus diisi!',
            'opening_hours.open.date_format' => 'Jam tidak valid!',
            'opening_hours.close.date_format' => 'Jam tidak valid!',
        ];
    }
}
