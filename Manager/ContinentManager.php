<?php
/**
 * Created by PhpStorm.
 * User: miky
 * Date: 02/10/16
 * Time: 02:41
 */

namespace Miky\Bundle\LocationBundle\Manager;


use Doctrine\Common\Persistence\entityManager;
use Miky\Bundle\CoreBundle\Doctrine\BaseEntityManager;
use Miky\Bundle\LocationBundle\Model\Continent;
use Miky\Bundle\LocationBundle\Webservices\GeoList\GeoListProvider;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;

class ContinentManager extends BaseEntityManager
{

    protected $geoListProvider;

    /**
     * Constructor.
     * @param $em
     * @param string $class
     */
    public function __construct($em, $class, GeoListProvider $geoListProvider)
    {
        parent::__construct($em, $class);
        $this->geoListProvider = $geoListProvider;
    }

    /**
     * {@inheritDoc}
     */
    public function deleteContinent(Continent $continent)
    {
        $this->entityManager->remove($continent);
        $this->entityManager->flush();
    }

    public function getClass()
    {
        return $this->class;
    }

    public function findContinentBy(array $criteria)
    {
        return $this->repository->findOneBy($criteria);
    }

    public function findContinentsBy(array $criteria)
    {
        return $this->repository->findBy($criteria);
    }

    public function findContinents()
    {
        return $this->repository->findAll();
    }

    public function getArrayByName(){
        $continents = $this->findContinents();
        $array = array();
        if ($continents != null){
            foreach ($continents as $continent){
                $array[$continent->getShortName()] = $continent->getName();
            }
        }
        return $array;
    }
    public function reloadContinent(Continent $continent)
    {
        $this->entityManager->refresh($continent);
    }


    public function loadContinentFromApi(){
        $currents = $this->findContinents();
        foreach ($currents as $b){
            $this->entityManager->remove($b);
        }
        $this->entityManager->flush();
        $list = $this->geoListProvider->getContinentList();
        foreach ($list as $c){
            $continent = $this->createContinent();
            $continent->setName($c['name']);
            $continent->setShortName($c['code']);
            $this->entityManager->persist($continent);
        }
        $this->entityManager->flush();
    }
    /**
     * Updates a Continent.
     *
     * @param Continent $continent
     * @param Boolean $andFlush Whether to flush the changes (default true)
     */
    public function updateContinent(Continent $continent, $andFlush = true)
    {
        $this->entityManager->persist($continent);
        if ($andFlush) {
            $this->entityManager->flush();
        }
    }

    /**
     * Returns an empty Continent instance
     *
     * @return Continent
     */
    public function createContinent()
    {
        $class = $this->getClass();
        $continent = new $class;
        return $continent;
    }



    /**
     * Refreshed a Continent by Continent Instance
     * @param Continent $continent
     * @return Ad
     */
    public function refreshContinent(Continent $continent)
    {

        $refreshedContinent = $this->findContinentBy(array('id' => $continent->getId()));
        if (null === $refreshedContinent) {
            throw new UsernameNotFoundException(sprintf('User with ID "%d" could not be reloaded.', $continent->getId()));
        }
        return $refreshedContinent;
    }


    public function supportsClass($class)
    {
        return $class === $this->getClass();
    }
}