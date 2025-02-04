<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Data\AddressData;
use App\Data\ClientData;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Unique;

class ClientStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $uniqueClientRule = Rule::unique('clients')
            ->where(function (Builder $query) {
                return $query->where('user_id', $this->user()->id);
            })
            ->when($this->routeIs('clients.update'), function (Unique $rule) {
                return $rule->ignore($this->route('client')->id);
            });

        return [
            'name' => 'required|string|max:150',
            'email' => [
                'required',
                'email',
                $uniqueClientRule,
            ],
            'company' => 'nullable|string|max:150',
            'invoice_prefix' => [
                'required',
                'alpha_dash',
                'max:10',
                $uniqueClientRule,
            ],
            'invoice_index' => 'required|integer',
            'phone' => 'nullable|digits_between:9,15',
            'country' => 'required|string|max:100',
            'state' => 'nullable|string|max:100',
            'city' => 'required|string|max:100',
            'zip' => 'nullable|string|max:50',
            'street1' => 'required|string|max:150',
            'street2' => 'nullable|string|max:150',
            'note' => 'nullable|string',
        ];
    }

    public function getClientData(): ClientData
    {
        $validated = $this->validated();

        $address = new AddressData(
            $validated['country'],
            $validated['state'] ?? null,
            $validated['city'],
            $validated['zip'] ?? null,
            $validated['street1'],
            $validated['street2'] ?? null
        );

        return new ClientData(
            $validated['name'],
            $validated['email'],
            $validated['company'] ?? null,
            $validated['invoice_prefix'],
            (int) $validated['invoice_index'],
            $validated['phone'] ?? null,
            $address,
            $validated['note'] ?? null
        );
    }

    public function attributes(): array
    {
        return [
            'street1' => 'address line 1',
            'street2' => 'address line 2',
        ];
    }
}
