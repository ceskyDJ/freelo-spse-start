<?php

declare(strict_types = 1);

namespace App\Repository\Common;


use App\Entity\User;

interface IUserRepository
{

	/**
	 * Vrátí uživatele podle ID
	 *
	 * @param int $id ID uživatele
	 *
	 * @return User Odpovídající uživatel
	 */
	public function getUserById(int $id): User;

	/**
	 * Vytvoří uživatele z předaných dat
	 *
	 * @param array $data Data v surovém formátu (např. z DB)
	 *
	 * @return User Uživatel
	 */
	public function createUserFromRawData(array $data): User;
}