<?php

namespace App\Http\Requests\Api;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class GetReviewsRequest extends FormRequest
{
    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id' => ['nullable', 'integer', 'required_without_all:productId,product_id'],
            'productId' => ['nullable', 'integer', 'required_without_all:id,product_id'],
            'product_id' => ['nullable', 'integer', 'required_without_all:id,productId'],
        ];
    }
}
