<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Traits\HasAddress;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class EnsureProfileIsFilled
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->user() ||
            (in_array(HasAddress::class, class_uses($request->user()), true) &&
                !$request->user()->address()->exists())) {
            return Redirect::route('user.settings.edit')->with([
                'status' => __('You must update your user profile first.'),
                'type' => 'warning'
            ]);
        }

        return $next($request);
    }
}
