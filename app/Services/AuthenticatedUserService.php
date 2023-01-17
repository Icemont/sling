<?php

declare(strict_types=1);

namespace App\Services;

use App\Http\Requests\UserSettingsRequest;
use App\Models\User;

class AuthenticatedUserService
{
    public function __construct(public readonly User $user)
    {
    }

    public function updateProfileWithAddress(UserSettingsRequest $request): User
    {
        $this->updateProfile($request->getUserProfilePayload());
        $this->user->upsertAddress($request->getUserAddressPayload());

        return $this->user;
    }

    public function updateProfile(array $attributes): bool
    {
        return $this->user->update([
            'name' => $attributes['name'],
            'business' => $attributes['business'],
            'phone' => $attributes['phone'],
        ]);
    }
}
