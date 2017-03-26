<?php
/**
 * Created by PhpStorm.
 * User: miky
 * Date: 22/08/16
 * Time: 00:06
 */

namespace Miky\Bundle\LocationBundle\DataFixtures\ORM;



use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadLocationData extends AbstractFixture  implements OrderedFixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $locationManager = $this->container->get('adevis_location_manager');
        $location = $locationManager->createLocation();

        $location->setCity('test');

        $location1 = $locationManager->createLocation();
        $location1->setCity('admin');



        $locationManager->updateLocation($location);
        $locationManager->updateLocation($location1);

        $this->addReference('location', $location);
        $this->addReference('location1', $location1);
    }

    public function getOrder()
    {
        return 1;
    }
}