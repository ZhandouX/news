<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Youtube;

class YoutubeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    // RULE UNTUK TABEL YOUTUBE
    public function rules(): array
    {
        $rules = [
            'title' => [
                'required',
                'string',
                'max:500',
                function ($attribute, $value, $fail) {
                    $query = Youtube::where('title', $value)
                        ->where('content_date', $this->content_date);

                    // Exclude saat Update
                    if ($this->youtube) {
                        $query->where('id', '!=', $this->youtube->id);
                    }

                    if ($query->exists()) {
                        $fail('Konten Youtube dengan judul dan tanggal ini sudah ada!');
                    }
                },
            ],
            'link' => ['nullable', 'url'],
            'content_date' => 'required|date',
        ];

        return $rules;
    }

    // PESAN WAJIB MENGISI FORM
    public function messages(): array
    {
        return [
            'title.required' => 'Judul konten wajib diisi.',
            'title.max' => 'Judul konten maksimal 500 karakter.',
            'content_date.required' => 'Tanggal konten wajib diisi',
            'content_date.date' => 'Format tanggal tidak valid.',
        ];
    }

    // ATTRIBUT-ATRIBUT DI DALAM TABEL YOUTUBE
    public function attributes(): array
    {
        return [
            'title' => 'Judul konten',
            'link' => 'Link konten',
            'content_date' => 'Tanggal konten'
        ];
    }
}