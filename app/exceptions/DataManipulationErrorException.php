<?php

declare(strict_types=1);

namespace App\Exceptions;


use Exception;

/**
 * Výjimka pro nezdařenou práci s daty (např. při operacích s DB)
 *
 * @package App\Exceptions
 */
class DataManipulationErrorException extends Exception
{
}