<?php

declare(strict_types=1);

namespace App\Exceptions;


use Exception;

/**
 * Výjimka pro chybně zadaný časový údaj
 * (časový údaj má nevalidní formát)
 *
 * @package App\Exceptions
 */
class InvalidDateTimeFormatException extends Exception
{
}