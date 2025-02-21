<?php

declare(strict_types=1);

namespace App\Services;

use App\DTO\AddressDTO;
use App\DTO\UserProfileDTO;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

readonly class AuthenticatedUserService
{
    public function __construct(public User $user)
    {
    }

    public function updateProfileWithAddress(UserProfileDTO $profileData): User
    {
        $this->updateProfile($profileData);
        $this->updateAddress($profileData->address);

        return $this->user;
    }

    public function updateProfile(UserProfileDTO $profileData): bool
    {
        return $this->user->update([
            'name' => $profileData->name,
            'business' => $profileData->business,
            'phone' => $profileData->phone,
        ]);
    }

    public function updateAddress(AddressDTO $addressData): Model
    {
        return $this->user->upsertAddress([
            'street1' => $addressData->street1,
            'street2' => $addressData->street2,
            'city' => $addressData->city,
            'state' => $addressData->state,
            'country' => $addressData->country,
            'zip' => $addressData->zip,
        ]);
    }

    public function setTheme(Request $request): void
    {
        $this->user->dark_theme = ($request->get('theme') == 'dark');
        $this->user->save();
    }
}
