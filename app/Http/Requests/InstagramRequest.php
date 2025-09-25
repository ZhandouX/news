<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Instagram;

class InstagramRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    // RULE UNTUK TABEL INSTAGRAM
    public function rules(): array
    {
        $rules = [
            'title' => [
                'required',
                'string',
                'max:500',
                function ($attribute, $value, $fail) {
                    $query = Instagram::where('title', $value)
                        ->where('content_date', $this->content_date);

                    // Exclude saat Update
                    if ($this->instagram) {
                        $query->where('id', '!=', $this->instagram->id);
                    }

                    if ($query->exists()) {
                        $fail('Konten Instagram dengan judul dan tanggal ini sudah ada!');
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

    // ATTRIBUT-ATRIBUT DI DALAM TABEL INSTAGRAM
    public function attributes(): array
    {
        return [
            'title' => 'Judul konten',
            'link' => 'Link konten',
            'content_date' => 'Tanggal konten'
        ];
    }
}