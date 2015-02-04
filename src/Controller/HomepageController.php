<?php

namespace Estaty\Controller;

use Estaty\Application;
use Estaty\Model\Property\Property;

class HomepageController
{
    public function show(Application $app)
    {
        $property = new Property();
        $property->setName('Lovely apartment');

        return $app->render('homepage.twig', [
            'property' => $property
        ]);
    }
}
