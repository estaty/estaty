<?php

namespace Estaty\Repo;

use Harp\Harp\AbstractRepo;
use Estaty\Model\Property;

class PropertyRepo extends AbstractRepo
{
    public static function newInstance()
    {
        return new PropertyRepo(Property::class);
    }

    public function initialize()
    {

    }
}
