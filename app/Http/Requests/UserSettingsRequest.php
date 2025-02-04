<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Data\AddressData;
use App\Data\UserProfileData;
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

    public function getProfileData(): UserProfileData
    {
        $profile = $this->validated();

        $address = new AddressData(
            $profile['country'],
            $profile['state'] ?? null,
            $profile['city'],
            $profile['zip'] ?? null,
            $profile['street1'],
            $profile['street2'] ?? null
        );

        return new UserProfileData(
            $profile['name'],
            $profile['business'],
            $profile['phone'],
            $address
        );
    }
}
