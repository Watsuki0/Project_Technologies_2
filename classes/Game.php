<?php

class Game {
    public $id;
    public $title;
    public $description;
    public $price;
    public $image;

    public function __construct($id, $title, $description, $price, $image) {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->price = $price;
        $this->image = $image;
    }

    public function getTitle() : string
    {
        return $this->title;
    }
}
