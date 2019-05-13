<?php

declare(strict_types = 1);

namespace App\Repository\Common;


use App\Entity\Comment;
use app\entity\Task;
use App\Exceptions\DataManipulationErrorException;

interface ICommentRepository
{

	/**
	 * Vrátí všechny nalezené komentáře k určité události
	 *
	 * @param Task $task Nadřezená událost
	 *
	 * @return array Pole komentářů
	 */
	public function getComments(Task $task): array;

	/**
	 * Vrátí komentář s určitým ID
	 *
	 * @param int $id ID komentáře
	 *
	 * @return Comment Komentář
	 */
	public function getCommentById(int $id): Comment;

	/**
	 * Vytvoří komentář z předaných dat
	 *
	 * @param array $data Data v surové podobě (např. z DB)
	 *
	 * @return Comment Komentář
	 */
	public function createCommentFromRawData(array $data): Comment;

	/**
	 * Přidá komentář
	 *
	 * @param int $taskId ID úkolu, která byl okomentován
	 * @param int $authorId ID uživatele, který komentář napsal
	 * @param string $message Zpráva (obsah komentáře)
	 *
	 * @throws DataManipulationErrorException Chyba při zpracování dat
	 */
	public function addComment(int $taskId, int $authorId, string $message): void;
}