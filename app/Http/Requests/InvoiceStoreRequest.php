<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class InvoiceStoreRequest extends FormRequest
{
    private const DATE_FORMAT = 'Y-m-d';

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $isCreating = $this->routeIs('invoices.store');

        return [
            'client_id' => [
                Rule::requiredIf($isCreating),
                'integer',
                Rule::exists('clients', 'id')->where(function ($query) {
                    return $query->where('user_id', $this->user()->id);
                }),
            ],
            'product_name' => 'required|string|max:150',
            'product_price' => 'required|numeric|max:9999999999.99',
            'currency_id' => 'required|integer|exists:currencies,id',
            'invoice_number' => [
                'required',
                'string',
                'max:25',
                $isCreating ?
                    Rule::unique('invoices')->where(function ($query) {
                        return $query->where('client_id', $this->client_id);
                    }) :
                    Rule::unique('invoices')->where(function ($query) {
                        return $query->where('client_id', $this->route('invoice')->client_id);
                    })
                        ->ignore($this->route('invoice')->id),
            ],
            'invoice_date' => 'required|date_format:"' . self::DATE_FORMAT . '"',
            'payment_method_id' => [
                'required',
                'integer',
                Rule::exists('payment_methods', 'id')->where(function ($query) {
                    return $query->where('user_id', $this->user()->id)
                        ->where('is_active', true);
                }),
            ],
            'is_paid' => 'boolean',
            'payment_date' => 'exclude_unless:is_paid,true|required|date_format:"' . self::DATE_FORMAT . '"',
            'exchange_rate' => $this->user()->currency_id == $this->currency_id ?
                '' : 'exclude_unless:is_paid,true|required|numeric|max:99999.9999999',
            'note' => 'nullable|string',
        ];
    }

    public function getInvoicePayload($forCreating = false): array
    {
        $isPaid = (bool)$this->is_paid;
        $isLocalCurrency = ($this->user()->currency_id == $this->currency_id);

        return collect($this->validated())
            ->only([
                'product_name',
                'currency_id',
                'invoice_number',
                'payment_method_id',
                'note',
            ])
            ->when($forCreating, function ($payload) {
                return $payload->merge(['client_id' => $this->client_id]);
            })
            ->merge([
                'product_price' => round(floatval($this->product_price), 2),
                'invoice_date' => Carbon::createFromFormat(self::DATE_FORMAT, $this->invoice_date),
                'is_paid' => $isPaid,
            ])
            ->when($isPaid, function ($payload) use ($isLocalCurrency) {
                return $payload
                    ->merge([
                        'payment_date' => Carbon::createFromFormat(self::DATE_FORMAT, $this->payment_date),
                    ])
                    ->when($isLocalCurrency, function ($payload) {
                        return $payload->merge([
                            'amount' => (float)$this->product_price,
                        ]);
                    })
                    ->unless($isLocalCurrency, function ($payload) {
                        return $payload->merge([
                            'exchange_rate' => (float)$this->exchange_rate,
                            'amount' => (float)$this->product_price * (float)$this->exchange_rate,
                        ]);
                    });
            })
            ->toArray();
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'product_price' => Str::replace(',', '.', $this->product_price),
            'exchange_rate' => Str::replace(',', '.', $this->exchange_rate),
        ]);
    }
}
