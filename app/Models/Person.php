<?php

namespace App\Models;

class Person extends SWModel
{
    protected $name;
    protected $height;
    protected $mass;
    protected $hair_color;
    protected $skin_color;
    protected $eye_color;
    protected $birth_year;
    protected $gender;
    protected $films;

    function __construct(
        string $url,
        string $name,
        string $height,
        string $mass,
        string $hair_color,
        string $skin_color,
        string $eye_color,
        string $birth_year,
        string $gender,
        array $films
    ) {
        parent::__construct($url);

        $this->name = $name;
        $this->height = $height;
        $this->mass = $mass;
        $this->hair_color = $hair_color;
        $this->skin_color = $skin_color;
        $this->eye_color = $eye_color;
        $this->birth_year = $birth_year;
        $this->gender = $gender;

        $this->films = $this->getRelationshipFromAPI($films);
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'url' => $this->url,
            'name' => $this->name,
            'height' => $this->height,
            'mass' => $this->mass,
            'hair_color' => $this->hair_color,
            'skin_color' => $this->skin_color,
            'eye_color' => $this->eye_color,
            'birth_year' => $this->birth_year,
            'gender' => $this->gender,
            'films' => $this->films
        ];
    }
}
