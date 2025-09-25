<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Tiktok;

class TiktokRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    // RULE UNTUK TABEL TIKTOK
    public function rules(): array
    {
        $rules = [
            'title' => [
                'required',
                'string',
                'max:500',
                function ($attribute, $value, $fail) {
                    $query = Tiktok::where('title', $value)
                        ->where('content_date', $this->content_date);

                    // Exclude saat Update
                    if ($this->tiktok) {
                        $query->where('id', '!=', $this->tiktok->id);
                    }

                    if ($query->exists()) {
                        $fail('Konten Tiktok dengan judul dan tanggal ini sudah ada!');
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

    // ATTRIBUT-ATRIBUT DI DALAM TABEL TIKTOK
    public function attributes(): array
    {
        return [
            'title' => 'Judul konten',
            'link' => 'Link konten',
            'content_date' => 'Tanggal konten'
        ];
    }
}