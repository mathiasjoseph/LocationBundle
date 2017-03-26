<?php
/**
 * Created by PhpStorm.
 * User: miky
 * Date: 02/10/16
 * Time: 02:41
 */

namespace Miky\Bundle\LocationBundle\Manager;

use Miky\Bundle\CoreBundle\Manager\ObjectManagerInterface;
use Miky\Bundle\LocationBundle\Entity\Country;
use Miky\Bundle\LocationBundle\Webservices\GeoList\GeoListProvider;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;

class CountryManager implements ObjectManagerInterface
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

    protected $geoListProvider;

    protected $locales;

    protected $requestStack;
    /**
     * Constructor.
     * @param ObjectManager $om
     * @param string $class
     */
    public function __construct(ObjectManager $om, $class, GeoListProvider $geoListProvider, RequestStack $requestStack, $locales)
    {
        $this->objectManager = $om;
        $this->repository = $om->getRepository($class);
        $metadata = $om->getClassMetadata($class);
        $this->class = $metadata->getName();
        $this->geoListProvider = $geoListProvider;
        $this->requestStack = $requestStack;
        $this->locales = $locales;
    }

    /**
     * {@inheritDoc}
     */
    public function deleteCountry(Country $country)
    {
        $this->objectManager->remove($country);
        $this->objectManager->flush();
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
        $this->objectManager->refresh($country);
    }

    public function loadCountriesFromApi(){
        $currents = $this->findCountries();
        foreach ($currents as $b){
            $this->objectManager->remove($b);
        }
        $this->objectManager->flush();
        $list = $this->geoListProvider->getCountryList();
        foreach ($list as $c){
            $country = $this->createCountry();
            $country->setName($c['name']);
            $country->setShortName($c['code']);
            $country->setContinent($c['region']);
            $country->setCapital($c['capital']);

            $this->objectManager->persist($country);
        }
        $this->objectManager->flush();
    }

    /**
     * Updates a Country.
     *
     * @param Country $country
     * @param Boolean $andFlush Whether to flush the changes (default true)
     */
    public function updateCountry(Country $country, $andFlush = true)
    {
        $this->objectManager->persist($country);
        if ($andFlush) {
            $this->objectManager->flush();
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