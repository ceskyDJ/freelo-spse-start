<?php

declare(strict_types=1);

namespace App\Entity;

use DateTime;

class Comment
{
	/** @var int */
	private $commentId;
	/** @var Task */
	private $task;
	/** @var User */
	private $author;
	/** @var DateTime */
	private $createdAt;
	/** @var string */
	private $message;

	/**
	 * Comment konstruktor
	 *
	 * @param int $commentId DB ID komentáře
	 * @param Task $task Nadřazená událost
	 * @param User $author Autor komentáře
	 * @param string $message Obsah komentáře (zpráva)
	 * @param DateTime $createdAt Časový údaj o vytvoření
	 */
	public function __construct(int $commentId, Task $task, User $author, string $message, DateTime $createdAt)
	{
		$this->commentId = $commentId;
		$this->task = $task;
		$this->author = $author;
		$this->createdAt = $createdAt;
		$this->message = $message;
	}

	/**
	 * Getter
	 *
	 * @return int
	 */
	public function getCommentId(): int
	{
		return $this->commentId;
	}

	/**
	 * Getter
	 *
	 * @return Task
	 */
	public function getTask(): Task
	{
		return $this->task;
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
	public function getMessage(): string
	{
		return $this->message;
	}
}