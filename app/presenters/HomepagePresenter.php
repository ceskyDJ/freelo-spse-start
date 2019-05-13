<?php

declare(strict_types=1);

namespace App\Presenters;

use App;
use App\Exceptions\DataManipulationErrorException;
use app\forms\AddCommentFormFactory;
use App\Repository\Common\ICommentRepository;
use App\Repository\Common\ITaskRepository;
use App\Repository\Common\IUserRepository;
use Nette\Application\UI\Form;
use stdClass;

final class HomepagePresenter extends BasePresenter
{

	/**
	 * @var AddCommentFormFactory
	 */
	private $addCommentFormFactory;
	/**
	 * @var ITaskRepository
	 */
	private $taskRepository;
	/**
	 * @var ICommentRepository
	 */
	private $commentRepository;
	/**
	 * @var IUserRepository
	 */
	private $userRepository;

	/**
	 * HomepagePresenter konstruktor
	 *
	 * @param AddCommentFormFactory $addCommentFormFactory Továrna pro formulář komentářů
	 * @param ITaskRepository $taskRepository Repozitář úkolů
	 * @param ICommentRepository $commentRepository Repozitář komentářů
	 * @param IUserRepository $userRepository Repozitář uživatelů
	 */
	public function __construct(AddCommentFormFactory $addCommentFormFactory, ITaskRepository $taskRepository, ICommentRepository $commentRepository, IUserRepository $userRepository)
	{
		$this->addCommentFormFactory = $addCommentFormFactory;
		$this->taskRepository = $taskRepository;
		$this->commentRepository = $commentRepository;
		$this->userRepository = $userRepository;
	}

	public function renderDefault(): void
	{
		// TODO: Dynamické ID
		$this->template->task = $task = $this->taskRepository->getTaskById(1);

		$this->template->comments = $this->commentRepository->getComments($task);
	}

	public function actionDefault(): void
	{
		$this['commentForm']->onSuccess[] = function(Form $form, stdClass $values) {
			$this->commentFormSucceeded($form, $values);
		};
	}

	public function commentFormSucceeded(Form $form, stdClass $values)
	{
		// TODO: Dynamické ID (viz HomepagePresenter.php:30)
		$taskId = 1;
		// TODO: Podle přihlášeného uživatele
		$authorId = 2;

		try {
			$this->commentRepository->addComment($taskId, $authorId, $values->message);

			$this->flashMessage('Komentář byl úspěšně přidán', 'success');
		}
		catch(DataManipulationErrorException $e) {
			$this->flashMessage('Při přidávání komentáře nastala chyba', 'error');
		}

		$this->redirect('this');
	}

	protected function createComponentCommentForm()
	{
		return $this->addCommentFormFactory->create();
	}
}
