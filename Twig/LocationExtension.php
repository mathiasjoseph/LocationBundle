<?php
/**
 * Created by PhpStorm.
 * User: miky
 * Date: 28/09/16
 * Time: 17:47
 */

namespace Miky\Bundle\LocationBundle\Twig;


use Miky\Bundle\LocationBundle\Manager\CountryManager;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Intl\Intl;

class LocationExtension extends \Twig_Extension
{
    private $countryManager;

    protected $requestStack;

    /**
     * LocationExtension constructor.
     * @param $countryManager
     */
    public function __construct(CountryManager $countryManager, RequestStack $requestStack)
    {
        $this->countryManager = $countryManager;
        $this->requestStack = $requestStack;
    }


    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('flagByIso', array($this, 'flagByIso')),
            new \Twig_SimpleFilter('countryName', array($this, 'countryName'))
        );
    }

    public function flagByIso($iso)
    {
        $country = $this->countryManager->findCountryByShortName($iso);
        if ($country != null){
         return $country->getFlag();
        }
        else{
            return null;
        }
    }

    public function countryName($iso)
    {
        return Intl::getRegionBundle()->getCountryNames($this->requestStack->getCurrentRequest()->getLocale())[strtoupper($iso)];
    }

    public function getName()
    {
        return 'location_extension';
    }

}