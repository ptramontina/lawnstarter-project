<?php

namespace App\Http\Controllers;

use App\Services\StatisticsService;
use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    public function apiIndex(Request $request)
    {
        $statisticsService = new StatisticsService();
        return $statisticsService->getStatistics();
    }
}
