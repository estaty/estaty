<?php

namespace Estaty\Controller;

use Estaty\Application;
use Estaty\Model\Property\Property;
use Estaty\Model\Property\PropertyType;

class PropertiesController
{
	public function initialForm(Application $app)
	{
		$property = new Property();
		return $app->render('properties/initialForm.twig');
	}

	public function submitInitial(Application $app)
	{
		
	}
}
