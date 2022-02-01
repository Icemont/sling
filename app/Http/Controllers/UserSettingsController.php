<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserSettingsRequest;
use App\Values\Address;

class UserSettingsController extends Controller
{
    public function edit()
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();
        $address = new Address($user->address);

        return view('user.settings', compact('user', 'address'));
    }

    public function update(UserSettingsRequest $request)
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
