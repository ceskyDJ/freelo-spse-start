<?php

declare(strict_types=1);

namespace App\Exceptions;

/**
 * Výjimka pro chybu vzniklou při práci s databází
 *
 * @package App\Exceptions
 */
class DatabaseErrorException extends DataManipulationErrorException
{
}