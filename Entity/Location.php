<?php

namespace Miky\Bundle\LocationBundle\Entity;


use Miky\Component\Core\Model\CommonModelInterface;
use Miky\Component\Core\Model\CommonModelTrait;
use Miky\Component\Location\Model\Location as BaseLocation;
use Miky\Component\Resource\Model\ResourceInterface;

/**
 * Location
 */
class Location extends BaseLocation implements ResourceInterface, CommonModelInterface
{
    Use CommonModelTrait;


    /**
     * @var int
     */
    protected $id;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

}
