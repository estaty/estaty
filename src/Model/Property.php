<?php

namespace Estaty\Model;

use Harp\Harp\AbstractModel;
use Estaty\Repo\PropertyRepo;

class Property extends AbstractModel
{
    /**
     * @var integer
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * @return Estaty\Repo\PropetyRepo;
     */
    public function getRepo()
    {
        return PropertyRepo::get();
    }
}
