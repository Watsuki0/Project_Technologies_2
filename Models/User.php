<?php

class User
{
    public int $id;
    public string $username;
    public string $email;
    public bool $is_admin;

    public function __construct(array $data)
    {
        $this->id = (int)($data['id'] ?? 0);
        $this->username = $data['username'] ?? '';
        $this->email = $data['email'] ?? '';
        $this->is_admin = isset($data['is_admin']) && (bool)$data['is_admin'];
    }
}
