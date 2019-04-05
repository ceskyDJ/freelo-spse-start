<?php

namespace App\Forms;

use Nette;
use Nette\Application\UI\Form;


final class FormFactory
{
	use Nette\SmartObject;

	/**
	 * Vytvoří obecný formulář
	 *
	 * @return Form Obecný formulář
	 */
	public function create()
	{
		$form = new Form;

		return $form;
	}
}
