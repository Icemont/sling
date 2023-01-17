<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\UserSettingsRequest;
use App\Services\AuthenticatedUserService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class UserSettingsController extends Controller
{
    public function edit(): View
    {
        return view('user.settings', [
            'user' => auth()->user(),
        ]);
    }

    public function update(
        AuthenticatedUserService $authenticatedUserService,
        UserSettingsRequest      $request
    ): RedirectResponse
    {
        $authenticatedUserService->updateProfileWithAddress($request);

        return redirect()
            ->route('user.settings.edit')
            ->with([
                'status' => __('Profile settings successfully updated!'),
                'type' => 'success'
            ]);
    }
}
