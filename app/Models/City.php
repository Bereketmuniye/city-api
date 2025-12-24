<?php

namespace App\Models;

class City
{
    public int $id;
    public string $name;
    public string $country;
    public ?int $population;
    public ?string $description;

    public function __construct(int $id, string $name, string $country, ?int $population = null, ?string $description = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->country = $country;
        $this->population = $population;
        $this->description = $description;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'country' => $this->country,
            'population' => $this->population,
            'description' => $this->description,
        ];
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['id'],
            $data['name'],
            $data['country'],
            $data['population'] ?? null,
            $data['description'] ?? null
        );
    }
}

