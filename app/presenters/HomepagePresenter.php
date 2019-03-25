<?php

namespace App\Presenters;

use Nette;
use App;
use Nette\Application\UI\Form;

final class HomepagePresenter extends BasePresenter
{

	/**
	 * @var Nette\Database\Context
	 */
	private $database;
	/**
	 * @var App\Forms\FormFactory
	 */
	private $formFactory;

	public function __construct(Nette\Database\Context $database, App\Forms\FormFactory $formFactory)
	{
		$this->database = $database;
		$this->formFactory = $formFactory;
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
		$form = $this->formFactory->create();

		$form->addTextArea('message')
			->setRequired();

		$form->addSubmit('send');

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
