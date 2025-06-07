<?php

class Order
{
    public int $id;
    public string $username;
    public string $created_at;
    public ?float $total = null;

    public function __construct(array $data)
    {
        $this->id = (int) $data['id'];
        $this->username = $data['username'] ?? '';
        $this->created_at = $data['created_at'] ?? '';
        $this->total = isset($data['total']) ? (float) $data['total'] : null;
    }
}
