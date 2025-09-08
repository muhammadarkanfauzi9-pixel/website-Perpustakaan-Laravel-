<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePublisherRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Ubah ini menjadi true
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:publishers,name',
            'description' => 'nullable|string',
        ];
    }
}