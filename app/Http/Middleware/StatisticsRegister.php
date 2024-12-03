<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;
use App\Services\StatisticsService;

class StatisticsRegister
{
    /**
     * This middleware registers all searches that happens 
     * If it fails, it just logs the error so it does not affect system usage.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $shouldSaveStatistic = $request->query('search') && strlen($request->query('search'));
        if ($shouldSaveStatistic) {
            $start = Carbon::now();
        }

        $response = $next($request);

        if ($shouldSaveStatistic) {
            $end = Carbon::now();
            $statisticService = new StatisticsService();
            $statisticService->setStatistic($start, $end, $request->query('search'), $request->query('type'));
        }

        return $response;
    }
}
