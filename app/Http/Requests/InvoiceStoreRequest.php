<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\DTO\InvoiceDTO;
use App\Enums\Currency;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

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
            'currency' => [
                'required',
                'integer',
                new Enum(Currency::class),
            ],
            'invoice_number' => [
                'required',
                'string',
                'max:25',
                $isCreating ?
                    Rule::unique('invoices')->where(function ($query) {
                        return $query->where('client_id', $this->input('client_id'));
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
            'exchange_rate' => $this->user()->currency == Currency::tryFrom((int) $this->input('currency')) ?
                'nullable' : 'exclude_unless:is_paid,true|required|numeric|gt:0|max:99999.9999999',
            'note' => 'nullable|string',
        ];
    }

    public function getInvoicePayload(): InvoiceDTO
    {
        $validated = $this->validated();

        $clientId = $this->input('client_id') ? (int) $this->input('client_id') : null;
        $isPaid = (bool) $this->input('is_paid');
        $currency = Currency::from((int) $validated['currency']);
        $isLocalCurrency = ($this->user()->currency == $currency);
        $productPrice = round(floatval($validated['product_price']), 2);
        $amount = $isPaid ? (
            $isLocalCurrency ? $productPrice : round($productPrice * floatval($validated['exchange_rate']), 2)
        ) : null;
        $exchangeRate = $isPaid ? ($isLocalCurrency ? null : round(floatval($validated['exchange_rate']), 7)) : null;

        return new InvoiceDTO(
            $clientId,
            $validated['product_name'],
            $productPrice,
            $currency,
            $exchangeRate,
            $amount,
            $validated['invoice_number'],
            CarbonImmutable::createFromFormat(self::DATE_FORMAT, $validated['invoice_date']),
            (int) $validated['payment_method_id'],
            $isPaid,
            $isPaid ? CarbonImmutable::createFromFormat(self::DATE_FORMAT, $validated['payment_date']) : null,
            $validated['note'],
        );
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'product_price' => Str::replace(',', '.', $this->input('product_price')),
            'exchange_rate' => Str::replace(',', '.', $this->input('exchange_rate')),
        ]);
    }
}
