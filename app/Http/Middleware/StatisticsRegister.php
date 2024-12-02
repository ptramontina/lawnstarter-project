<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Models\Search;

class StatisticsRegister
{
    /**
     * Handle an incoming request.
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
            try {
                $end = Carbon::now();
                $differenceInMilliseconds = $start->diffInMilliseconds($end);
                $search = $request->query('search');
                $type = $request->query('type') ?? 'people';

                Search::create([
                    'search_text' => $search,
                    'type' => $type == 'films' ? 'movies' : $type,
                    'request_start' => $start,
                    'request_end' => $end,
                    'duration' => $differenceInMilliseconds,
                ]);
            } catch (\Exception $error) {
                Log::error('Error while storing statistic: ' . $error->getMessage());
            }
        }

        return $response;
    }
}
