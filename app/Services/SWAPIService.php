<?php

namespace App\Services;

use Illuminate\Http\Client\Pool;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class SWAPIService
{
    /**
     * Receives a type and make the search in the SWApi.
     * 
     * @return Collection
     */
    public function search(string $type, string $search): Collection
    {
        $cacheData = Cache::get($type . $search);
        if ($cacheData) {
            return $cacheData;
        }

        $response = Http::get(config('swapi.baseurl') . "$type?search=$search");

        $response = json_decode($response->body());

        $resultData = collect($response->results);

        while ($response->next) {
            $response = Http::get($response->next);
            $response = json_decode($response->body());
            $resultData = $resultData->merge(collect($response->results));
        }

        Cache::set($type . $search, $resultData, 300);

        return $resultData;
    }

    /**
     * This method receives a type and an url to get a SW model (people or film).
     * I thought it would be better to use the url directly, since the API does not provide
     * the ID in the object response.
     * With that, if I were to use the ID, I would have to make an extra loop after the requests
     * finished (in the search method above), and parse the URL to get the ID.
     * 
     * @param string $type Type of the object, in this case either 'people' or 'movies'
     * @param string $url The url to get the object from
     * @return object
     */
    public function getSWModel(string $type, string $url): object
    {
        $cacheData = Cache::get($cacheKey = $type . $url);
        if ($cacheData) {
            return $cacheData;
        }

        $response = Http::get($url);

        $swModel = json_decode($response->body());

        //I used films internally so the code wouldn't have a lot of converts between films and movies.
        if ($type === 'films') {
            // Make all requests in paralel to improve performance
            $characters = collect(Http::pool(function (Pool $pool) use ($swModel) {
                foreach ($swModel->characters as $characterUrl) {
                    $pool->get($characterUrl);
                }
            }))->map(function ($swModel) {
                return json_decode($swModel->body());
            });

            $swModel->characters = $characters;
        } else {
            // Make all requests in paralel to improve performance
            $films = collect(Http::pool(function (Pool $pool) use ($swModel) {
                foreach ($swModel->films as $filmUrl) {
                    $pool->get($filmUrl);
                }
            }))->map(function ($swModel) {
                return json_decode($swModel->body());
            });

            $swModel->films = $films;
        }

        Cache::set($cacheKey, $swModel, 300);

        return $swModel;
    }
}
