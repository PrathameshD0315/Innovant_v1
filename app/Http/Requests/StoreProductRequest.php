<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name'=>'required|string|max:255',
            'price'=>'required|numeric|min:0',
            'description'=>'nullable|string',
            'images'=>'nullable|array',
            'images.*'=>'file|mimes:jpeg,png,jpg,gif,webp|max:5120'
        ];
    }
}
