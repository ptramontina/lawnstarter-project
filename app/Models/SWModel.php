<?php

namespace App\Models;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Pool;
use Illuminate\Support\Collection;

abstract class SWModel
{
    abstract function toArray(): array;

    protected $url;
    protected $id;

    function __construct(string $url)
    {
        $this->url = $url;
        $this->id = $this->parseIdFromUrl($url);
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
    /**
     * This function gets a relationship array and loads all data related to that.
     * The relationship is an array of URLs.
     * 
     * (Make all requests in paralel to improve performance)
     */
    protected function getRelationshipFromAPI(array $relationship): Collection
    {
        return collect(Http::pool(function (Pool $pool) use ($relationship) {
            foreach ($relationship as $relationshipUrl) {
                $pool->get($relationshipUrl);
            }
        }))->map(function ($swModel) {
            $model = json_decode($swModel->body());
            $model->id = $this->parseIdFromUrl($model->url);
            return $model;
        });
    }
}
