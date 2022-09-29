<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UpdatePasswordRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;

class UpdatePasswordController extends Controller
{
    public function edit()
    {
        return view('user.password');
    }

    public function update(UpdatePasswordRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        auth()->user()->update(['password' => Hash::make($validated['new_password'])]);

        return redirect()
            ->route('user.password.edit')
            ->with([
                'status' => __('Password successfully updated!'),
                'type' => 'success'
            ]);
    }
}
