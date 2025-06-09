<?php

class OrderItem
{
    public string $title;
    public float $price;
    public int $quantity;

    public function __construct(array $data)
    {
        $this->title = $data['title'] ?? '';
        $this->price = (float) $data['price'];
        $this->quantity = (int) $data['quantity'];
    }
}
