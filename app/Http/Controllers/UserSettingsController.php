<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\UserSettingsRequest;
use App\Models\User;
use App\Values\Address;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class UserSettingsController extends Controller
{
    public function edit(): View
    {
        /** @var User $user */
        $user = auth()->user();

        $address = new Address($user->address);

        return view('user.settings', compact('user', 'address'));
    }

    public function update(UserSettingsRequest $request): RedirectResponse
    {
        auth()->user()->updateProfileWithAddress($request->validated());

        return redirect()
            ->route('user.settings.edit')
            ->with([
                'status' => __('Profile settings successfully updated!'),
                'type' => 'success'
            ]);
    }
}
