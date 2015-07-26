<?php

namespace Estaty\Controller;

use Estaty\Application;
use Estaty\Model\Property\Property;
use Estaty\Model\Property\PropertyType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class HomepageController
{
    public function show(Application $app)
    {
        $subRequest = Request::create($app->path('initialPropertyForm'));
        $propertyForm = $app->handle($subRequest, HttpKernelInterface::SUB_REQUEST, false)->getContent();

        return $app->render('homepage.twig', [
            'propertyForm' => $propertyForm,
        ]);
    }
}
