<?php

namespace App\Http\Requests\Api;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'productId' => ['required', 'integer', 'exists:products,id'],
            'updateProduct' => ['required', 'array'],
            'updateProduct.name' => ['sometimes', 'string', 'max:255'],
            'updateProduct.description' => ['sometimes', 'nullable', 'string'],
            'updateProduct.price' => ['sometimes', 'nullable', 'numeric', 'min:0'],
            'updateProduct.tags' => ['sometimes', 'nullable', 'array'],
            'updateProduct.tags.*' => ['string'],
        ];
    }
}
