<?php

namespace App\Http\Requests\Api;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateReviewReactionRequest extends FormRequest
{
    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'reviewID' => ['required', 'integer', 'exists:reviews,id'],
            'UserID' => ['required', 'integer', 'exists:users,id'],
        ];
    }
}
