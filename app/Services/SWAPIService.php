<?php

namespace App\Services;

use Illuminate\Http\Client\Pool;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

/**
 * This service manages all requests made to SWApi.
 */
class SWAPIService
{
    /**
     * Receives a type and make the search in the SWApi.
     * 
     * IMPORTANT: swapi.dev does not provide the id of the model. Only swapi.tech.
     * But due to the issue I mentioned on the Readme, I used this one, so, I had 
     * to parse the ID from the URL.
     * 
     * @param string $type the type to search
     * @param string $search the text to search
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

        $resultData = $resultData->map(function ($result) {
            $result->id = $this->parseIdFromUrl($result->url);
            return $result;
        });

        Cache::set($type . $search, $resultData, 300);

        return $resultData;
    }

    /**
     * This method receives a type and an id to get a SW model (people or film).
     * IMPORTANT: swapi.dev does not provide the id of the model. Only swapi.tech.
     * But due to the issue I mentioned on the Readme, I used this one, so, I had 
     * to parse the ID from the URL.
     * 
     * @param string $type Type of the object, in this case either 'people' or 'movies'
     * @param string $id The id of the object
     * @return object
     */
    public function getSWModel(string $type, string $id): object
    {
        $cacheData = Cache::get($cacheKey = $type . $id);
        if ($cacheData) {
            return $cacheData;
        }

        $response = Http::get(config('swapi.baseurl') . "$type/$id");

        $swModel = json_decode($response->body());

        //I used films internally so the code wouldn't have a lot of converts between films and movies.
        if ($type === 'films') {
            // Make all requests in paralel to improve performance
            $characters = collect(Http::pool(function (Pool $pool) use ($swModel) {
                foreach ($swModel->characters as $characterUrl) {
                    $pool->get($characterUrl);
                }
            }))->map(function ($swModel) {
                $character = json_decode($swModel->body());
                $character->id = $this->parseIdFromUrl($character->url);
                return $character;
            });

            $swModel->characters = $characters;
        } else {
            // Make all requests in paralel to improve performance
            $films = collect(Http::pool(function (Pool $pool) use ($swModel) {
                foreach ($swModel->films as $filmUrl) {
                    $pool->get($filmUrl);
                }
            }))->map(function ($swModel) {
                $film = json_decode($swModel->body());
                $film->id = $this->parseIdFromUrl($film->url);
                return $film;
            });

            $swModel->films = $films;
        }

        Cache::set($cacheKey, $swModel, 300);

        return $swModel;
    }

    /**
     * Gets URL and parse the id.
     * Note that, swapi.dev does not provide the ID for the model.
     * 
     * In that case, I parsed it from the URL.
     * 
     * As mentioned in the Readme, the other version swapi.tech was not populating 
     * the films in people resource.
     * 
     * @param $url string
     * @return string
     */
    private function parseIdFromUrl(string $url): string
    {
        $parsedUrl = explode('/', $url);
        return $parsedUrl[count($parsedUrl) - 2];
    }
}
