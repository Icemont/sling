<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Data\PaymentMethodData;
use Illuminate\Foundation\Http\FormRequest;

class PaymentMethodRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

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

    public function getPaymentMethodData($forCreating = false): PaymentMethodData
    {
        $attributes = $this->input('method_attributes');

        return new PaymentMethodData(
            $this->input('name'),
            is_array($attributes) ? array_combine($attributes['keys'], $attributes['values']) : [],
            (bool) $this->input('is_active'),
            $forCreating ? $this->user()->id : null
        );
    }

    public function messages(): array
    {
        return [
            'method_attributes.keys.*.distinct' => __('Attribute key (:attribute) must be unique.'),
        ];
    }
}
