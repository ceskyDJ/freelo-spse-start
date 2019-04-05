<?php

namespace App\Presenters;

use Nette;
use App;
use app\forms\AddCommentFormFactory;
use Nette\Application\UI\Form;

final class HomepagePresenter extends BasePresenter
{

	/** @var Nette\Database\Context */
	private $database;
	/** @var AddCommentFormFactory */
	private $addCommentFormFactory;

	public function __construct(Nette\Database\Context $database, AddCommentFormFactory $addCommentFormFactory)
	{
		$this->database = $database;
		$this->addCommentFormFactory = $addCommentFormFactory;
	}

	public function renderDefault()
	{
		// TODO: Dynamické ID
		$task = $this->database->table('tasks')->get(1);

		$this->template->task = $task;
		$this->template->comments = $task->related('comment')->order('created_at');
	}

	protected function createComponentCommentForm()
	{
		$form = $this->addCommentFormFactory->create();

		$form->onSuccess[] = [$this, 'commentFormSucceeded'];

		return $form;
	}

	public function commentFormSucceeded(Form $form, \stdClass $values)
	{
		// TODO: Dynamické ID (viz HomepagePresenter.php:30)
		$taskId = 1;
		// TODO: Podle přihlášeného uživatele
		$authorId = 2;

		$this->database->table('comments')->insert([
			'task_id' => $taskId,
			'author_id' => $authorId,
			'message' => $values->message
		]);

		$this->flashMessage('Komentář byl úspěšně přidán', 'success');
		$this->redirect('this');
	}
}
