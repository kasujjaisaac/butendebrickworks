<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuotationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // auth middleware handles authentication
    }

    public function rules(): array
    {
        return [
            'brick_product_id' => ['required', 'integer', 'exists:brick_products,id'],
            'square_metres'    => ['required', 'numeric', 'gt:0', 'max:100000'],
        ];
    }

    public function messages(): array
    {
        return [
            'brick_product_id.required' => 'Please select a brick product.',
            'brick_product_id.exists'   => 'The selected product is not available.',
            'square_metres.required'    => 'Please enter the area in square metres.',
            'square_metres.numeric'     => 'Square metres must be a valid number.',
            'square_metres.gt'          => 'Square metres must be greater than zero.',
            'square_metres.max'         => 'Square metres cannot exceed 100,000.',
        ];
    }
}
