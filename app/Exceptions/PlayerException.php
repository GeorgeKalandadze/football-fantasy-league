<?php

namespace App\Exceptions;

use Exception;

class PlayerException extends Exception
{
    protected $message;
    protected $code;

    public function __construct($message = null, $code = null)
    {
        parent::__construct($message ?? 'A team-related error occurred.', $code ?? 400);
    }

    public static function teamFullyOccupied(): self
    {
        return new self(
            'Team is fully occupied. Please consider adding this player to another team or create the player without a team.',
            400
        );
    }

    public static function playerNotFound(): self
    {
        return new self('Player not found.', 404);
    }

    public static function failedToDeletePlayer(): self
    {
        return new self('Failed to delete player.', 400);
    }
}

