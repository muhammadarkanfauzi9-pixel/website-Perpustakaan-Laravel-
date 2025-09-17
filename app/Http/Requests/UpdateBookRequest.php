<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBookRequest extends FormRequest
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
        'title' => 'required|string|max:255',
        'author_id' => 'required_without:author_name|nullable|exists:authors,id',
        'author_name' => 'required_without:author_id|nullable|string|max:255',
        'publisher_id' => 'required|exists:publishers,id',
        'shelf_id' => 'required|exists:shelves,id',
        'category_id' => 'required|exists:categories,id',
        'year' => 'required|integer|min:1900|max:' . date('Y'),
        'book_img' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Tambahkan 'nullable'
    ];
}



}
