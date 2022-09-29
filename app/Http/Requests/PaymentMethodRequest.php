<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentMethodRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {

        return [
            'name' => 'required|string|max:150',
            'method_attributes' => 'required|array:keys,values',
            'method_attributes.keys' => 'array',
            'method_attributes.values' => 'array|size:' . count($this->method_attributes['keys'] ?? []),
            'method_attributes.keys.*' => 'string|distinct',
            'method_attributes.values.*' => 'string',
            'is_active' => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'method_attributes.keys.*.distinct' => __('Attribute key (:attribute) must be unique.'),
        ];
    }
}
