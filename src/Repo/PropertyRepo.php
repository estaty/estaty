<?php

namespace Estaty\Repo;

use Harp\Harp\AbstractRepo;
use Estaty\Model\Property;

class PropertyRepo extends AbstractRepo
{
    public function initialize()
    {
        $this->setModelClass(Property::class);
    }
}
