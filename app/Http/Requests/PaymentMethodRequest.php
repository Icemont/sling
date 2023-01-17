<?php

declare(strict_types=1);

namespace App\Http\Requests;

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

    public function getPaymentMethodPayload($forCreating = false): array
    {
        return collect($this->validated())
            ->only([
                'name',
                'is_active',
            ])
            ->merge([
                'attributes' => isset($this->method_attributes) ?
                    array_combine($this->method_attributes['keys'], $this->method_attributes['values']) : [],
            ])
            ->when($forCreating, function ($payload) {
                return $payload->merge(['user_id' => $this->user()->id]);
            })
            ->toArray();
    }

    public function messages(): array
    {
        return [
            'method_attributes.keys.*.distinct' => __('Attribute key (:attribute) must be unique.'),
        ];
    }
}
