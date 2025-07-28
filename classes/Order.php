<?php

class Order
{
    private int $id;
    private int $userId;
    private string $username;
    private string $createdAt;
    private float $total;

    public function __construct(int $id, int $userId, string $username, string $createdAt, float $total = 0.0)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->username = $username;
        $this->createdAt = $createdAt;
        $this->total = $total;
    }

    public function getId(): int { return $this->id; }

    public function getUserId(): int { return $this->userId; }

    public function getUsername(): string {return $this->username; }

    public function getCreatedAt(): string { return $this->createdAt; }

    public function getTotal(): float { return $this->total; }
}
