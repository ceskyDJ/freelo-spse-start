<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Task;
use App\Repository\Common\ITaskRepository;
use App\Repository\Common\IUserRepository;
use Nette;

class DBTaskRepository implements ITaskRepository
{

	/**
	 * Databázová tabulka pro úkoly
	 */
	private const TASKS_TABLE = 'tasks';
	/**
	 * Databázová tabulka pro uživatele
	 */
	private const USERS_TABLE = 'users';

	/**
	 * @var Nette\Database\Context
	 */
	private $database;
	/**
	 * @var IUserRepository
	 */
	private $userRepository;

	/**
	 * DBCommentRepository konstruktor
	 *
	 * @param Nette\Database\Context $database DB spojení
	 * @param IUserRepository $userRepository Repozitář pro uživatele
	 */
	public function __construct(Nette\Database\Context $database, IUserRepository $userRepository)
	{
		$this->database = $database;
		$this->userRepository = $userRepository;
	}

	/**
	 * Vrátí událost podle ID
	 *
	 * @param int $id ID události
	 *
	 * @return Task Odpovídající událost
	 */
	public function getTaskById(int $id): Task
	{
		$taskActiveRow = $this->database->table(self::TASKS_TABLE)->get($id);

		$data = $taskActiveRow->toArray();
		$data['author'] = $taskActiveRow
			->ref(self::USERS_TABLE, 'author_id')
			->toArray();

		return $this->createTaskFromRawData($data);
	}

	/**
	 * Vytvoří úkol z předaných dat
	 *
	 * @param array $data Data v surovém formátu (např. z DB)
	 *
	 * @return Task Úkol
	 */
	public function createTaskFromRawData(array $data): Task
	{
		$author = $this->userRepository->createUserFromRawData($data['author']);

		return new Task(
			$data['task_id'],
			$author,
			$data['created_at'],
			$data['title'],
			(bool)$data['done'],
			$data['deadline']
		);
	}
}