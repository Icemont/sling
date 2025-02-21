<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\UserSettingsRequest;
use App\Services\AuthenticatedUserService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class UserSettingsController extends Controller
{
    public function show(): View|Factory
    {
        return view('user.settings-show', [
            'user' => auth()->user(),
        ]);
    }

    public function edit(): View|Factory
    {
        return view('user.settings-edit', [
            'user' => auth()->user(),
        ]);
    }

    public function update(UserSettingsRequest $request, AuthenticatedUserService $userService): RedirectResponse
    {
        $userService->updateProfileWithAddress($request->getProfileData());

        return redirect()
            ->route('user.settings.show')
            ->with([
                'status' => __('Profile settings successfully updated!'),
                'type' => 'success',
            ]);
    }
}
