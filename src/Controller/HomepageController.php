<?php

namespace Estaty\Controller;

use Estaty\Property;

class HomepageController
{
    public function show(\Silex\Application $app)
    {
        $property = new Property();
        $property->name = 'Lovely apartment';

        return $app->render('homepage.html.twig', array(
            'property' => $property
        ));
    }
}
