<?php

namespace Estaty\Controller;

use Estaty\Application;
use Estaty\Model\Property\Property;
use Estaty\Model\Property\PropertyType;

class HomepageController
{
    public function show(Application $app)
    {
        $apartmentType = new PropertyType('Apartment', 'apartment');
        $property = new Property($apartmentType);
        $property->setName('Lovely');
        $property->setPriceUsd(50);

        return $app->render('homepage.twig', [
            'property' => $property
        ]);
    }
}
