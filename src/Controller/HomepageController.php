<?php

namespace Estaty\Controller;

class HomepageController
{
    public function show(\Silex\Application $app)
    {
        return $app->render('homepage.html');
    }
}
