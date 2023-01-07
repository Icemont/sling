<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ClientStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $uniqueClientRule = Rule::unique('clients')
            ->where(function ($query) {
                return $query->where('user_id', $this->user()->id);
            });

        if ($this->routeIs('clients.update')) {
            $uniqueClientRule->ignore($this->route('client')->id);
        }

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

    public function getClientAddressPayload(): array
    {
        return collect($this->validated())
            ->only([
                'street1',
                'street2',
                'city',
                'state',
                'country',
                'zip',
            ])
            ->toArray();
    }

    public function getClientPayload($forCreating = false): array
    {
        return collect($this->validated())
            ->only([
                'name',
                'email',
                'company',
                'phone',
                'invoice_prefix',
                'invoice_index',
                'note',
            ])
            ->when($forCreating, function ($payload) {
                return $payload->merge(['user_id' => $this->user()->id]);
            })
            ->toArray();
    }

    public function attributes(): array
    {
        return [
            'street1' => 'address line 1',
            'street2' => 'address line 2',
        ];
    }
}
