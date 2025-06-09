<?php

class Game
{
    public int $id;
    public string $title;
    public string $description;
    public float $price;
    public string $image;

    public function __construct(array $data)
    {
        $this->id = (int) ($data['id'] ?? 0);
        $this->title = $data['title'] ?? '';
        $this->description = $data['description'] ?? '';
        $this->price = (float) ($data['price'] ?? 0);
        $this->image = $data['image'] ?? '';
    }
}
