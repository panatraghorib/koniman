<?php

namespace App\Http\Requests\Blog;

use Illuminate\Foundation\Http\FormRequest;

class ArticleAddRequest extends FormRequest
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
            'name' => ['required', 'min:10', 'unique:App\Models\Blog\Post,name'],
            'featured_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', //2 MB
            'intro' => ['min:25', 'max:100'],
            'content' => ['min:25'],
            'category_id' => ['required'],
            'status' => ['required', 'numeric', 'in:0,1,2']
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Judul Artikel tidak dapat kosong.',
            'featured_image.size' => 'Gambar maksimal ukuran 2 MB.',
        ];
    }
}
