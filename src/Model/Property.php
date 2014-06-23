<?php

namespace Estaty\Model;

use Harp\Harp\AbstractModel;
use Estaty\Repo\PropertyRepo;

class Property extends AbstractModel
{
    const REPO = 'Estaty\Repo\PropertyRepo';

    /**
     * @var integer
     */
    public $id;

    /**
     * @var string
     */
    public $name;
}
