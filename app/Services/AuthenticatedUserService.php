<?php

declare(strict_types=1);

namespace App\Services;

use App\Http\Requests\UserSettingsRequest;
use App\Models\User;
use Illuminate\Http\Request;

class AuthenticatedUserService
{
    public function __construct(public readonly User $user)
    {
    }

    public function updateProfileWithAddress(UserSettingsRequest $request): User
    {
        $this->updateProfile($request);
        $this->user->upsertAddress($request->getUserAddressPayload());

        return $this->user;
    }

    public function updateProfile(UserSettingsRequest $request): bool
    {
        return $this->user->update($request->getUserProfilePayload());
    }

    public function setTheme(Request $request): void
    {
        $this->user->dark_theme = ($request->get('theme') == 'dark');
        $this->user->save();
    }
}
