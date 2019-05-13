<?php

declare(strict_types=1);

namespace App\Entity;

class User
{
	/** @var int */
	private $userId;
	/** @var string */
	private $nick;

	/**
	 * User konstruktor
	 *
	 * @param int $userId DB ID uživatele
	 * @param string $nick Přezdívka uživatele
	 */
	public function __construct(int $userId, string $nick)
	{
		$this->userId = $userId;
		$this->nick = $nick;
	}

	/**
	 * Getter
	 *
	 * @return int
	 */
	public function getUserId(): int
	{
		return $this->userId;
	}

	/**
	 * Getter
	 *
	 * @return string
	 */
	public function getNick(): string
	{
		return $this->nick;
	}
}