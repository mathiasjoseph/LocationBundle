<?php
/**
 * Created by PhpStorm.
 * User: miky
 * Date: 02/10/16
 * Time: 15:32
 */

namespace Miky\Bundle\LocationBundle\Installer;


use Miky\Bundle\InstallerBundle\Model\InstallerInterface;
use Miky\Bundle\LocationBundle\Manager\ContinentManager;
use Miky\Bundle\LocationBundle\Manager\CountryManager;

class LocationInstaller implements InstallerInterface
{
    protected $countryManager;

    protected $continentManager;

    /**
     * LocationInstaller constructor.
     */
    public function __construct(CountryManager $countryManager, ContinentManager $continentManager)
    {
        $this->countryManager = $countryManager;
        $this->continentManager = $continentManager;
    }

    public function run(){
        $this->countryManager->loadCountriesFromApi();
       // $this->continentManager->loadContinentFromApi();
    }
}