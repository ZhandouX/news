<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\News;

class NewsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Atau sesuaikan dengan sistem authorization Anda
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $rules = [
            'title' => 'required|string|max:255',
            'news_date' => 'required|date',
            'content' => 'required|string',
            'category' => 'required|in:' . implode(',', News::getCategories()),
        ];

        // Untuk create, image wajib. Untuk update, optional
        if ($this->isMethod('post')) {
            $rules['cover_image'] = 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048';
        } else {
            $rules['cover_image'] = 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048';
        }

        return $rules;
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Judul berita wajib diisi.',
            'title.max' => 'Judul berita maksimal 255 karakter.',
            'cover_image.image' => 'File harus berupa gambar.',
            'cover_image.mimes' => 'Format gambar yang diperbolehkan: JPEG, PNG, JPG, GIF.',
            'cover_image.max' => 'Ukuran gambar maksimal 2MB.',
            'news_date.required' => 'Tanggal berita wajib diisi.',
            'news_date.date' => 'Format tanggal tidak valid.',
            'content.required' => 'Isi berita wajib diisi.',
            'category.required' => 'Kategori berita wajib dipilih.',
            'category.in' => 'Kategori yang dipilih tidak valid.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'title' => 'judul berita',
            'cover_image' => 'foto sampul',
            'news_date' => 'tanggal berita',
            'content' => 'isi berita',
            'category' => 'kategori berita',
        ];
    }
}