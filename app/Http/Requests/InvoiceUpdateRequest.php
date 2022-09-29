<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class InvoiceUpdateRequest extends FormRequest
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
            'product_name' => 'required|string|max:150',
            'product_price' => 'required|numeric|max:9999999999.99',
            'currency_id' => 'required|integer|exists:currencies,id',
            'invoice_number' => [
                'required',
                'string',
                'max:25',
                Rule::unique('invoices')
                    ->where(function ($query) {
                        return $query->where('client_id', $this->invoice->client_id);
                    })
                    ->ignore($this->invoice->id),
            ],
            'invoice_date' => 'required|date_format:"Y-m-d"',
            'payment_method_id' => [
                'required',
                'integer',
                Rule::exists('payment_methods', 'id')
                    ->where(function ($query) {
                        return $query->where('user_id', auth()->id())
                            ->where('is_active', true);
                    }),
            ],
            'is_paid' => 'boolean',
            'payment_date' => 'exclude_unless:is_paid,true|required|date_format:"Y-m-d"',
            'exchange_rate' => auth()->user()->currency_id == $this->currency_id ?
                '' : 'exclude_unless:is_paid,true|required|numeric|max:99999.9999999',
            'note' => 'nullable|string',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'product_price' => Str::replace(',', '.', $this->product_price),
            'exchange_rate' => Str::replace(',', '.', $this->exchange_rate),
        ]);
    }
}
