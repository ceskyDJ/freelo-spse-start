<?php

namespace App\Forms;

use Nette;
use Nette\Application\UI\Form;
use Nette\Security\User;


final class SignInFormFactory
{
	use Nette\SmartObject;

	/** @var FormFactory */
	private $factory;

	/** @var User */
	private $user;


	public function __construct(FormFactory $factory, User $user)
	{
		$this->factory = $factory;
		$this->user = $user;
	}


	/**
	 * @return Form
	 */
	public function create(callable $onSuccess)
	{
		$form = $this->factory->create();
		$form->addText('nick', 'Přezdívka:')
			->setRequired('Zadejte prosím svou pžezdívku.');

		$form->addPassword('password', 'Heslo:')
			->setRequired('Zadejte prosím své heslo.');

		$form->addCheckbox('remember', 'Chci být přihlášen trvale');

		$form->addSubmit('send', 'Přihlásit');

		$form->onSuccess[] = function (Form $form, $values) use ($onSuccess) {
			try {
				$this->user->setExpiration($values->remember ? '14 days' : '20 minutes');
				$this->user->login($values->username, $values->password);
			} catch (Nette\Security\AuthenticationException $e) {
				$form->addError('Zadaná přezdívka nebo heslo nejsou správné.');
				return;
			}
			$onSuccess();
		};

		return $form;
	}
}
