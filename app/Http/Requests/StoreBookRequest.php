<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
{
    return [
        'title'        => 'required|string|max:255',
        'author_id'       => 'required|exists:authors,id',
        'year'         => 'required|integer|min:1900|max:' . date('Y'),
        'publisher_id' => 'required|exists:publishers,id',
        'shelf_id'     => 'required|exists:shelves,id',
        'category_id'  => 'required|exists:categories,id',
        'book_img' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // optional file
    ];
}


}
