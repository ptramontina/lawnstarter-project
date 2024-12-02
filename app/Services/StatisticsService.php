<?php

namespace App\Services;

use App\Models\Search;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Collection;

/**
 * This service manages the processing of the statistics.
 * It looks for the searches stored in DB, and stores in the chache.
 * 
 * The idea is that this will be used by a job that will run every 5 minutes.
 * So, when any other class needs to look for this, just gets really fast from
 * the cache.
 */
class StatisticsService
{
    /**
     * Processes all statistics
     * @return void
     */
    public function processStatistics(): void
    {
        $max = Search::orderBy('id', 'desc')->first()?->id;

        /**
         * If there is no max search, I know that nothing is populated in DB
         */
        if ($max) {
            $mostCommonSearches = Search::query()
                ->groupBy('search_text')->select(
                    'search_text',
                    DB::raw('max(type) as type'),
                    DB::raw('count(search_text) as total'),
                    DB::raw("round(count(search_text)/$max*100, 1) as avg")
                )
                ->orderBy('total', 'desc')
                ->limit(5)
                ->get();

            $durationAverage = Search::query()
                ->groupBy('search_text')->select(
                    'search_text',
                    DB::raw('max(type) as type'),
                    DB::raw('round(avg(duration), 2) as avg_duration_in_ms')
                )
                ->orderBy('avg_duration_in_ms', 'desc')->get();

            $requestsPerHour = Search::select(
                DB::raw('hour(request_start) as hour_of_the_day'),
                DB::raw('COUNT(id) as total_in_period')
            )
                ->groupBy(DB::raw('hour_of_the_day'))
                ->get();

            Cache::set('statistics', collect([
                'most_common_searches' => $mostCommonSearches,
                'duration_average' => $durationAverage,
                'requests_per_hour' => $requestsPerHour
            ]));
        }
    }

    /**
     * Return a collection with statistics
     * 
     * @return Collection
     */
    public function getStatistics(): Collection
    {
        return Cache::get('statistics') ?? collect([]);
    }
}
