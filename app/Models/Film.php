<?php

namespace App\Models;

class Film extends SWModel
{
    protected $title;
    protected $opening_crawl;
    protected $characters;

    function __construct(string $url, string $title, string $opening_crawl, array $characters)
    {
        parent::__construct($url);

        $this->title = $title;
        $this->opening_crawl = $opening_crawl;

        $this->characters = $this->getRelationshipFromAPI($characters);
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'url' => $this->url,
            'title' => $this->title,
            'opening_crawl' => $this->opening_crawl,
            'characters' => $this->characters
        ];
    }
}
