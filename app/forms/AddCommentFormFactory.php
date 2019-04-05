<?php


namespace App\Forms;

use Nette;
use Nette\Application\UI\Form;

final class AddCommentFormFactory {

	use Nette\SmartObject;

	/** @var FormFactory */
	private $formFactory;

	public function __construct(FormFactory $formFactory) {
		$this->formFactory = $formFactory;
	}

	/**
	 * Vytvoří a nakonfiguruje formulář pro přidání komentáře
	 *
	 * @return Form Připravený formulář pro přidání komentáře
	 */
	public function create(): Form
	{
		$form = $this->formFactory->create();

		$form->addTextArea('message')
			->setRequired();

		$form->addSubmit('send');

		return $form;
	}
}