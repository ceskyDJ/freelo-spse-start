<?php

declare(strict_types=1);

namespace App\Entity;

use App\Exceptions\InvalidDateTimeFormatException;
use DateTime;
use Exception;

class Task
{
	/** @var int */
	private $taskId;
	/** @var User */
	private $author;
	/** @var DateTime */
	private $createdAt;
	/** @var string */
	private $title;
	/** @var bool */
	private $done;
	/** @var DateTime */
	private $deadline;

	/**
	 * Task konstruktor
	 *
	 * @param int $taskId DB ID úkolu
	 * @param User $author Autor úkolu
	 * @param DateTime $createdAt Časový údaj o vytvoření
	 * @param string $title Titulek (název)
	 * @param bool $done Je úkol dokončen?
	 * @param DateTime $deadline Koncový termín
	 *
	 */
	public function __construct(int $taskId, User $author, DateTime $createdAt, string $title, bool $done, DateTime $deadline)
	{
		$this->taskId = $taskId;
		$this->author = $author;
		$this->createdAt = $createdAt;
		$this->title = $title;
		$this->done = $done;
		$this->deadline = $deadline;
	}

	/**
	 * Getter
	 *
	 * @return int
	 */
	public function getTaskId(): int
	{
		return $this->taskId;
	}

	/**
	 * Getter
	 *
	 * @return User
	 */
	public function getAuthor(): User
	{
		return $this->author;
	}

	/**
	 * Getter
	 *
	 * @return DateTime
	 */
	public function getCreatedAt(): DateTime
	{
		return $this->createdAt;
	}

	/**
	 * Getter
	 *
	 * @return string
	 */
	public function getTitle(): string
	{
		return $this->title;
	}

	/**
	 * Getter
	 *
	 * @return bool
	 */
	public function isDone(): bool
	{
		return $this->done;
	}

	/**
	 * Getter
	 *
	 * @return DateTime
	 */
	public function getDeadline(): DateTime
	{
		return $this->deadline;
	}
}