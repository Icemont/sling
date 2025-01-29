<?php

declare(strict_types=1);

namespace App\Services;

use App\Data\UserProfileData;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

readonly class AuthenticatedUserService
{
    public function __construct(public User $user)
    {
    }

    public function updateProfileWithAddress(UserProfileData $profileData): User
    {
        $this->updateProfile($profileData);
        $this->updateAddress($profileData);

        return $this->user;
    }

    public function updateProfile(UserProfileData $profileData): bool
    {
        return $this->user->update([
            'name' => $profileData->name,
            'business' => $profileData->business,
            'phone' => $profileData->phone,
        ]);
    }

    public function updateAddress(UserProfileData $profileData): Model
    {
        return $this->user->upsertAddress([
            'street1' => $profileData->street1,
            'street2' => $profileData->street2,
            'city' => $profileData->city,
            'state' => $profileData->state,
            'country' => $profileData->country,
            'zip' => $profileData->zip,
        ]);
    }

    public function setTheme(Request $request): void
    {
        $this->user->dark_theme = ($request->get('theme') == 'dark');
        $this->user->save();
    }
}
