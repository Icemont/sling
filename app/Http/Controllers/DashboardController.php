<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\StatisticService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request, StatisticService $statisticService): View|Factory
    {
        return view('dashboard', [
            'statistic' => $statisticService->getStatisticForDashboard(),
        ]);
    }
}
