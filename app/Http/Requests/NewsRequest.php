<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\News;

class NewsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    // RULE UNTUK TABEL NEWS
    public function rules(): array
    {
        return [
            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'news_date' => 'required|date',

            'link_berita' => [
                'nullable',
                'url',
                function ($attribute, $value, $fail) {
                    // Cek hanya jika link_berita tidak kosong
                    if (!empty($value)) {
                        $query = News::where('link_berita', $value)
                            ->where('news_date', $this->news_date);

                        // Jika update, exclude data yang sedang diupdate
                        if ($this->news) {
                            $query->where('id', '!=', $this->news->id);
                        }

                        if ($query->exists()) {
                            $fail('Berita dengan link dan tanggal yang sama sudah ada.');
                        }
                    }
                },
            ],

            'content' => 'nullable|string',

            'category' => 'required|in:' . implode(',', News::getCategories()),

            'office' => [
                'required',
                Rule::in(News::getOfficeCategories()),
            ],

            'office_other' => function ($attribute, $value, $fail) {
                if ($this->office === 'Other' && empty($value)) {
                    $fail('Nama kantor lainnya wajib diisi jika memilih Other.');
                }
            },

            'sumber' => [
                'required',
                Rule::in(News::getSumberCategories()),
            ],

            'sumber_other' => function ($attribute, $value, $fail) {
                if ($this->sumber === 'Other' && empty($value)) {
                    $fail('Nama Sumber lainnya wajib diisi jika memilih Other.');
                }
            },

            'link_sumber_other' => function ($attribute, $value, $fail) {
                if ($this->sumber === 'Other' && empty($value)) {
                    $fail('Link sumber wajib diisi jika memilih sumber lainnya.');
                }
            },

            'cover_image' => $this->isMethod('post')
                ? 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240'
                : 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
        ];
    }

    // PESAN UNTUK WAJIB MENGISI DATA YANG HARUS WAJIB DIISI
    public function messages(): array
    {
        return [
            'title.required' => 'Judul berita wajib diisi.',
            'title.max' => 'Judul berita maksimal 255 karakter.',
            'cover_image.image' => 'File harus berupa gambar.',
            'cover_image.mimes' => 'Format gambar yang diperbolehkan: JPEG, PNG, JPG, GIF.',
            'cover_image.max' => 'Ukuran gambar maksimal 10MB.',
            'news_date.required' => 'Tanggal berita wajib diisi.',
            'news_date.date' => 'Format tanggal tidak valid.',
            'category.required' => 'Kategori berita wajib dipilih.',
            'category.in' => 'Kategori yang dipilih tidak valid.',
            'office.required' => 'Kantor berita wajib dipilih.',
            'office.in' => 'Kantor yang dipilih tidak valid.',
            'sumber.required' => 'Sumber berita wajib dipilih.',
            'sumber.in' => 'Sumber yang dipilih tidak valid.',
        ];
    }

    // ATRIBUT-ATRIBUT DI DALAM TABEL NEWS
    public function attributes(): array
    {
        return [
            'title' => 'judul berita',
            'cover_image' => 'foto sampul',
            'news_date' => 'tanggal berita',
            'content' => 'isi berita',
            'category' => 'kategori berita',
            'office' => 'kantor berita',
            'sumber' => 'sumber berita'
        ];
    }
}
