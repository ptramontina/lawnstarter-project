<?php

namespace App\Services;

use App\Models\Film;
use App\Models\Person;
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
     * 
     * @param string $type the type to search
     * @param string $search the text to search
     * @return Collection
     */
    public function search(string $type, string $search): Collection
    {
        $cacheData = Cache::get($cacheKey = $type . $search);
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

        $resultData = $resultData->map(function ($result) use ($type) {
            return $this->getModelFromObject($result, $type)->toArray();
        });

        Cache::set($cacheKey, $resultData, 300);

        return $resultData;
    }

    /**
     * This method receives a type and an id to get a SW model (people or film).
     * 
     * @param string $type Type of the object, in this case either 'people' or 'movies'
     * @param string $id The id of the object
     * @return object
     */
    public function getSWModel(string $type, string $id): Film|Person
    {
        $cacheData = Cache::get($cacheKey = $type . $id);
        if ($cacheData) {
            return $cacheData;
        }

        $response = Http::get(config('swapi.baseurl') . "$type/$id");
        $swModel = json_decode($response->body());
        $swModel = $this->getModelFromObject($swModel, $type);

        Cache::set($cacheKey, $swModel, 300);

        return $swModel;
    }

    /**
     * Receives a model from the API and transforms in a local model 
     * 
     * @param object $swModel object from the API
     * @param string $type film or people
     * @return Film|Person
     */
    private function getModelFromObject(object $swModel, string $type): Film|Person
    {
        //I used films internally so the code wouldn't have a lot of converts between films and movies.
        if ($type === 'films') {
            // Make all requests in paralel to improve performance
            return new Film($swModel->url, $swModel->title, $swModel->opening_crawl, $swModel->characters);
        } else {
            return new Person(
                $swModel->url,
                $swModel->name,
                $swModel->height,
                $swModel->mass,
                $swModel->hair_color,
                $swModel->skin_color,
                $swModel->eye_color,
                $swModel->birth_year,
                $swModel->gender,
                $swModel->films
            );
        }
    }
}
