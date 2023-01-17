<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserSettingsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:150',
            'business' => 'required|array:name,code',
            'business.name' => 'required|string|max:150',
            'business.code' => 'nullable|string|max:50',
            'phone' => 'required|digits_between:9,15',
            'country' => 'required|string|max:100',
            'state' => 'nullable|string|max:100',
            'city' => 'required|string|max:100',
            'zip' => 'nullable|string|max:50',
            'street1' => 'required|string|max:150',
            'street2' => 'nullable|string|max:150',
        ];
    }

    public function getUserProfilePayload(): array
    {
        return collect($this->validated())
            ->only([
                'name',
                'business',
                'phone',
            ])
            ->toArray();
    }

    public function getUserAddressPayload(): array
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
}
