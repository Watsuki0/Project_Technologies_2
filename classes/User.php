<?php

class User
{
    public ?int $id;
    public string $username;
    public string $email;
    public string $password;
    public bool $is_admin;

    public function __construct(?int $id, string $username, string $email, string $password, bool $is_admin)
    {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->is_admin = $is_admin;
    }

    public function isAdmin(): bool
    {
        return $this->is_admin;
    }
    public function getId(): int
    {
        return $this->id;
    }
    public function getUsername(): string
    {
        return $this->username;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}
