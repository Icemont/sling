<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UpdatePasswordRequest;
use Illuminate\Support\Facades\Hash;

class UpdatePasswordController extends Controller
{
    public function edit()
    {
        return view('user.password');
    }

    public function update(UpdatePasswordRequest $request)
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
