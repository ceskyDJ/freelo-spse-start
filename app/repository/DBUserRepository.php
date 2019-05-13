<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\User;
use App\Repository\Common\IUserRepository;
use Nette;

class DBUserRepository implements IUserRepository
{

	/**
	 * Databázová tabulka pro uživatele
	 */
	private const USERS_TABLE = 'users';

	/**
	 * @var Nette\Database\Context
	 */
	private $database;

	/**
	 * DBCommentRepository konstruktor
	 *
	 * @param Nette\Database\Context $database DB spojení
	 */
	public function __construct(Nette\Database\Context $database)
	{
		$this->database = $database;
	}

	/**
	 * Vrátí uživatele podle ID
	 *
	 * @param int $id ID uživatele
	 *
	 * @return User Odpovídající uživatel
	 */
	public function getUserById(int $id): User
	{
		$userActiveRow = $this->database->table(self::USERS_TABLE)->get($id);

		return $this->createUserFromRawData($userActiveRow->toArray());
	}

	/**
	 * Vytvoří uživatele z předaných dat
	 *
	 * @param array $data Data v surovém formátu (např. z DB)
	 *
	 * @return User Uživatel
	 */
	public function createUserFromRawData(array $data): User
	{
		return new User($data['user_id'], $data['nick']);
	}
}