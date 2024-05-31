<?php

namespace App\Exceptions;

use Exception;

class TeamException extends Exception
{
    public static function teamNotFound(): self
    {
        return new self('Team not found.', 404);
    }

    public static function divisionMaxTeamsReached(): self
    {
        return new self('Division has reached the maximum limit of teams.', 400);
    }

    public static function failedToDeleteTeam(): self
    {
        return new self('Failed to delete team.', 400);
    }
}
