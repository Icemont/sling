<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\AuthenticatedUserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ThemeController extends Controller
{
    public function __invoke(Request $request, AuthenticatedUserService $authenticatedUserService): RedirectResponse
    {
        $authenticatedUserService->setTheme($request);

        return back();
    }
}
