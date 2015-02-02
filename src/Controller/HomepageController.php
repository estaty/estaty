<?php

namespace Estaty\Controller;

use Estaty\Application;
use Estaty\Model\Property\Apartment\Apartment;

class HomepageController
{
    public function show(Application $app)
    {
        $property = new Apartment();
        $property->setName('Lovely apartment');

        return $app->render('homepage.twig', [
            'property' => $property
        ]);
    }
}
