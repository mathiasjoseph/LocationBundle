<?php

namespace Miky\Bundle\LocationBundle\Entity;

use Miky\Bundle\CoreBundle\Entity\Traits\MikyCommonInterface;
use Miky\Bundle\CoreBundle\Entity\Traits\MikyCommonTrait;
use Miky\Component\Location\Model\Location as BaseLocation;
use Miky\Component\Resource\Model\ResourceInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * Location
 */
class Location extends BaseLocation implements ResourceInterface, MikyCommonInterface
{
    Use MikyCommonTrait;


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
