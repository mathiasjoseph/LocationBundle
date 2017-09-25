<?php
/**
 * Created by PhpStorm.
 * User: miky
 * Date: 02/10/16
 * Time: 02:41
 */

namespace Miky\Bundle\LocationBundle\Manager;

use Doctrine\ORM\EntityManager;
use Miky\Bundle\CoreBundle\Doctrine\BaseEntityManager;
use Miky\Bundle\LocationBundle\Model\Country;
use Miky\Bundle\LocationBundle\Webservices\GeoList\GeoListProvider;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;

class CountryManager extends BaseEntityManager
{
    protected $geoListProvider;



    protected $requestStack;
    
    
    public function __construct(EntityManager $em, $class,  GeoListProvider $geoListProvider, RequestStack $requestStack)
    {
        parent::__construct($em, $class);
        $this->geoListProvider = $geoListProvider;
        $this->requestStack = $requestStack;

    }

    /**
     * {@inheritDoc}
     */
    public function deleteCountry(Country $country)
    {
        $this->entityManager->remove($country);
        $this->entityManager->flush();
    }
    public function getArrayByName(){
        $countries = $this->findCountries();
        $array = array();
        if ($countries != null){
            foreach ($countries as $country){
                $array[$country->getShortName()] = $country->getName();
            }
        }
        return $array;
    }

    public function getClass()
    {
        return $this->class;
    }

    public function findCountryBy(array $criteria)
    {
        return $this->repository->findOneBy($criteria);
    }

    public function findCountryByShortName($shortName)
    {
        return $this->repository->createQueryBuilder('c')
            ->where('UPPER(c.shortName) = UPPER(:shortName)')
            ->setParameter('shortName', $shortName)
            ->getQuery()
            ->setMaxResults(1)->getOneOrNullResult();
    }

    public function findCountriesBy(array $criteria)
    {
        return $this->repository->findBy($criteria);
    }

    public function findCountries()
    {
        return $this->repository->findAll();
    }

    public function reloadCountry(Country $country)
    {
        $this->entityManager->refresh($country);
    }

    public function loadCountriesFromApi(){
        $currents = $this->findCountries();
        foreach ($currents as $b){
            $this->entityManager->remove($b);
        }
        $this->entityManager->flush();
        $list = $this->geoListProvider->getCountryList();
        foreach ($list as $c){
            $country = $this->createCountry();
            $country->setName($c['name']);
            $country->setShortName($c['code']);
            $country->setContinent($c['region']);
            $country->setCapital($c['capital']);

            $this->entityManager->persist($country);
        }
        $this->entityManager->flush();
    }

    /**
     * Updates a Country.
     *
     * @param Country $country
     * @param Boolean $andFlush Whether to flush the changes (default true)
     */
    public function updateCountry(Country $country, $andFlush = true)
    {
        $this->entityManager->persist($country);
        if ($andFlush) {
            $this->entityManager->flush();
        }
    }

    /**
     * Returns an empty Country instance
     *
     * @return Country
     */
    public function createCountry()
    {
        $class = $this->getClass();
        $country = new $class;
        return $country;
    }



    /**
     * Refreshed a Country by Country Instance
     * @param Country $country
     * @return Ad
     */
    public function refreshCountry(Country $country)
    {

        $refreshedCountry = $this->findCountryBy(array('id' => $country->getId()));
        if (null === $refreshedCountry) {
            throw new UsernameNotFoundException(sprintf('User with ID "%d" could not be reloaded.', $country->getId()));
        }
        return $refreshedCountry;
    }


    public function supportsClass($class)
    {
        return $class === $this->getClass();
    }
}