<?php
/**
 * Created by PhpStorm.
 * User: miky
 * Date: 25/09/16
 * Time: 12:18
 */

namespace Miky\Bundle\LocationBundle\Settings;


use Miky\Bundle\SettingsBundle\Schema\SchemaInterface;
use Miky\Bundle\SettingsBundle\Schema\SettingsBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class LocationSettingsSchema implements SchemaInterface
{
    public function buildSettings(SettingsBuilderInterface $builder)
    {
        $builder
            ->setDefaults(array(
                'gm_api_key' => "AIzaSyC4qRdwcWnBSD-9E9X4mO92QxzWG5MvWwk"
            ))
            ->setAllowedTypes('gm_api_key', array('string'));
    }

    public function buildForm(FormBuilderInterface $builder)
    {
        $builder
            ->add('gm_api_key', TextType::class, array(
                'label' => "miky_location.gm_api_key"
            ));
    }

    public function getLabel(){
        return "miky_location.location";
    }
}