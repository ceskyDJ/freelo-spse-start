<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Comment;
use App\Entity\Task;
use App\Exceptions\DatabaseErrorException;
use App\Exceptions\DataManipulationErrorException;
use App\Repository\Common\ICommentRepository;
use App\Repository\Common\ITaskRepository;
use App\Repository\Common\IUserRepository;
use DateTime;
use Exception;
use Nette;
use Nette\Database\Table\IRow;

class DBCommentRepository implements ICommentRepository
{

	/**
	 * Databázová tabulka pro komentáře
	 */
	private const COMMENTS_TABLE = 'comments';
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
	 * @var ITaskRepository
	 */
	private $taskRepository;
	/**
	 * @var IUserRepository
	 */
	private $userRepository;

	/**
	 * DBCommentRepository konstruktor
	 *
	 * @param Nette\Database\Context $database DB spojení
	 * @param ITaskRepository $taskRepository Repozitář úkolu
	 * @param IUserRepository $userRepository Repozitář uživatele
	 */
	public function __construct(Nette\Database\Context $database, ITaskRepository $taskRepository, IUserRepository $userRepository)
	{
		$this->database = $database;
		$this->taskRepository = $taskRepository;
		$this->userRepository = $userRepository;
	}

	/**
	 * Vrátí všechny nalezené komentáře k určité události
	 *
	 * @param Task $task Nadřezená událost
	 *
	 * @return Comment[] Pole komentářů
	 */
	public function getComments(Task $task): array
	{
		$commentActiveRows = $this->database->table(self::COMMENTS_TABLE)
			//->select(self::COMMENTS_TABLE . '.*, ' . self::USERS_TABLE . '.*, ' . self::TASKS_TABLE . '.*')
			->where('task_id', $task->getTaskId())
			->order('created_at')
			->fetchAll();

		$comments = [];
		foreach($commentActiveRows as $commentActiveRow) {
			$data = $commentActiveRow->toArray();
			/**
			 * @var IRow $taskActiveRow
			 */
			$taskActiveRow = $commentActiveRow->ref(self::TASKS_TABLE, 'task_id');
			$data['author'] = $commentActiveRow
				->ref(self::USERS_TABLE, 'author_id')
				->toArray();
			$data['task'] = $taskActiveRow->toArray();
			$data['task']['author'] = $taskActiveRow
				->ref(self::USERS_TABLE, 'author_id')
				->toArray();

			// Databázová data by měla být v pořádku => databáze vrací validní formát
			$comments[] = $this->createCommentFromRawData($data);
		}

		return $comments;
	}

	/**
	 * Vrátí komentář s určitým ID
	 *
	 * @param int $id ID komentáře
	 *
	 * @return Comment Komentář
	 */
	public function getCommentById(int $id): Comment
	{
		$commentActiveRow = $this->database->table(self::COMMENTS_TABLE)->get(1);

		$data = $commentActiveRow->toArray();
		$data['task'] = $commentActiveRow
			->ref(self::TASKS_TABLE, 'task_id')
			->toArray();
		$data['author'] = $commentActiveRow
			->ref(self::USERS_TABLE, 'author_id')
			->toArray();

		return $this->createCommentFromRawData($data);
	}

	/**
	 * Vytvoří komentář z předaných dat
	 *
	 * @param array $data Data v surové podobě (např. z DB)
	 *
	 * @return Comment Komentář
	 */
	public function createCommentFromRawData(array $data): Comment
	{
		$task = $this->taskRepository->createTaskFromRawData($data['task']);
		$author = $this->userRepository->createUserFromRawData($data['author']);

		return new Comment($data['comment_id'], $task, $author, $data['message'], $data['created_at']);
	}

	/**
	 * Přidá komentář
	 *
	 * @param int $taskId ID úkolu, která byl okomentován
	 * @param int $authorId ID uživatele, který komentář napsal
	 * @param string $message Zpráva (obsah komentáře)
	 *
	 * @throws DataManipulationErrorException Chyba při vkládání do databáze
	 */
	public function addComment(int $taskId, int $authorId, string $message): void
	{
		$createdAt = new DateTime();

		try {
			$this->database->table(self::COMMENTS_TABLE)
				->insert([
					'task_id'    => $taskId,
					'author_id'  => $authorId,
					'created_at' => $createdAt->format('Y-m-d H:i:s'),
					'message'    => $message,
				]);
		}
		catch(Exception $e) {
			throw new DatabaseErrorException('Při vkládání záznamu komentáře nastala chyba', 0, $e);
		}
	}
}