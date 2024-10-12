<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|max:255',
            'description' => 'nullable|max:5000',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:png,jpg,jpeg,gif,webp|max:2048',
            'barcode' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'SKU' => 'nullable|string|max:255|unique:products,SKU,' . $this->product,
            'published_at' => 'nullable|date',
            'user_id' => 'required|exists:users,id',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * @return array
     * Custom validation messages
     */
    public function messages()
    {
        return [
            'title.required' => 'Please give product title',
            'title.max' => 'Please give product title maximum of 255 characters',
            'description.max' => 'Please give product description maximum of 5000 characters',
            'price.required' => 'Please give product price',
            'price.numeric' => 'Please give a numeric product price',
            'image.image' => 'Please give a valid product image',
            'image.max' => 'Product image max 2MB is allowed',
            'barcode.max' => 'Barcode must not exceed 255 characters',
            'is_active.boolean' => 'The active status must be true or false',
            'SKU.unique' => 'The SKU must be unique',
            'published_at.date' => 'Please provide a valid date for published at',
            'user_id.required' => 'User ID is required',
            'user_id.exists' => 'The selected user does not exist',
        ];
    }
}
