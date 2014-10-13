<?php

namespace Estaty\Controller;

use Estaty\Model\Property\Apartment\Apartment;

class HomepageController
{
    public function show(\Silex\Application $app)
    {
        $property = new Apartment();
        $property->setName('Lovely apartment');

        return $app->render('homepage.html.twig', array(
            'property' => $property
        ));
    }
}
