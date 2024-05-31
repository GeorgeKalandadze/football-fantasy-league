<?php

namespace App\Exceptions;

use Exception;

class FantasyTeamException extends Exception
{
    public static function userAlreadyHasTeam(): self
    {
        return new self('User already has a fantasy team.', 400);
    }

    public static function totalCostExceedsBalance(): self
    {
        return new self('Total cost of players exceeds the initial team balance.', 400);
    }

    public static function fantasyTeamNotFound(): self
    {
        return new self('Fantasy team not found.', 404);
    }

    public static function unauthorizedToUpdateTeam(): self
    {
        return new self('You are not authorized to update this fantasy team.', 403);
    }

    public static function invalidPlayerSelected(int $playerId): self
    {
        return new self("The selected player $playerId is invalid.", 400);
    }

    public static function negativeBalance(): self
    {
        return new self('Updating the team would result in negative balance.', 400);
    }

    public static function failedToUpdateTeam(): self
    {
        return new self('Failed to update fantasy team.', 500);
    }

    public static function failedToDeleteTeam(): self
    {
        return new self('Failed to delete fantasy team.', 400);
    }
}
