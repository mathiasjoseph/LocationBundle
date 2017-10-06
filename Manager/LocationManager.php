<?php
/**
 * Created by PhpStorm.
 * User: miky
 * Date: 02/10/16
 * Time: 02:41
 */

namespace Miky\Bundle\LocationBundle\Manager;


use Miky\Bundle\CoreBundle\Doctrine\BaseEntityManager;
use Miky\Bundle\LocationBundle\Model\Location;
use Miky\Component\Location\Model\LocationInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;

class LocationManager extends BaseEntityManager
{

    /**
     * Constructor.
     * @param $em
     * @param string $class
     */
    public function __construct($em, $class)
    {
        parent::__construct($em, $class);
    }

    /**
     * {@inheritDoc}
     */
    public function deleteLocation(Location $location)
    {
        $this->entityManager->remove($location);
        $this->entityManager->flush();
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
        $this->entityManager->refresh($location);
    }

    /**
     * Updates a Location.
     *
     * @param Location $location
     * @param Boolean $andFlush Whether to flush the changes (default true)
     */
    public function updateLocation(Location $location, $andFlush = true)
    {
        $this->entityManager->persist($location);
        if ($andFlush) {
            $this->entityManager->flush();
        }
    }

    /**
     * Returns an empty LocationInterface instance
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
     * @return LocationInterface
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