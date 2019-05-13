<?php

declare(strict_types = 1);

namespace App\Repository\Common;


use App\Entity\Task;

interface ITaskRepository
{

	/**
	 * Vrátí událost podle ID
	 *
	 * @param int $id ID události
	 *
	 * @return Task Odpovídající událost
	 */
	public function getTaskById(int $id): Task;

	/**
	 * Vytvoří úkol z předaných dat
	 *
	 * @param array $data Data v surovém formátu (např. z DB)
	 *
	 * @return Task Úkol
	 */
	public function createTaskFromRawData(array $data): Task;
}