<?php
/**
 * Created by PhpStorm.
 * User: miky
 * Date: 02/10/16
 * Time: 02:41
 */

namespace Miky\Bundle\LocationBundle\Manager;

use Miky\Bundle\CoreBundle\Manager\ObjectManagerInterface;
use Miky\Bundle\LocationBundle\Model\Location;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;

class LocationManager implements ObjectManagerInterface
{
    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * @var string
     */
    protected $class;

    /**
     * @var \Doctrine\Common\Persistence\ObjectRepository
     */
    protected $repository;

    /**
     * Constructor.
     * @param ObjectManager $om
     * @param string $class
     */
    public function __construct(ObjectManager $om, $class)
    {
        $this->objectManager = $om;
        $this->repository = $om->getRepository($class);
        $metadata = $om->getClassMetadata($class);
        $this->class = $metadata->getName();
    }

    /**
     * {@inheritDoc}
     */
    public function deleteLocation(Location $location)
    {
        $this->objectManager->remove($location);
        $this->objectManager->flush();
    }

    public function getClass()
    {
        return $this->class;
    }

    public function findLocationBy(array $criteria)
    {
        return $this->repository->findOneBy($criteria);
    }

    public function findLocationsBy(array $criteria)
    {
        return $this->repository->findBy($criteria);
    }

    public function findLocations()
    {
        return $this->repository->findAll();
    }

    public function reloadLocation(Location $location)
    {
        $this->objectManager->refresh($location);
    }

    /**
     * Updates a Location.
     *
     * @param Location $location
     * @param Boolean $andFlush Whether to flush the changes (default true)
     */
    public function updateLocation(Location $location, $andFlush = true)
    {
        $this->objectManager->persist($location);
        if ($andFlush) {
            $this->objectManager->flush();
        }
    }

    /**
     * Returns an empty LOcationInterface instance
     *
     * @return LocationInterface
     */
    public function createLocation()
    {
        $class = $this->getClass();
        $location = new $class;
        return $location;
    }



    /**
     * Refreshed a Location by Location Instance
     * @param LocationInterface $location
     * @return Ad
     */
    public function refreshLocation(Location $location)
    {

        $refreshedLocation = $this->findLocationBy(array('id' => $location->getId()));
        if (null === $refreshedLocation) {
            throw new UsernameNotFoundException(sprintf('User with ID "%d" could not be reloaded.', $location->getId()));
        }
        return $refreshedLocation;
    }


    public function supportsClass($class)
    {
        return $class === $this->getClass();
    }
}