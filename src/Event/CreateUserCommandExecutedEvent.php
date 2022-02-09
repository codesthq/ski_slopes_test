<?php

namespace App\Event;

use Symfony\Contracts\EventDispatcher\Event;

class CreateUserCommandExecutedEvent extends Event
{
    public const NAME = 'create_user_command.executed';

    protected $username;
    protected $password;

    public function __construct(string $username, string $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}