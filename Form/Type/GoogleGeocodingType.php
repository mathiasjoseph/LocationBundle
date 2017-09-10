<?php

namespace Miky\Bundle\LocationBundle\Form\Type;

use Miky\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class LocationType
 * @package Miky\Bundle\LocationBundle\Form
 */
class GoogleGeocodingType extends AbstractResourceType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('streetNumber', HiddenType::class, array("attr" => array("class" => "street_number")))
            ->add('street', HiddenType::class, array("attr" => array("class" => "route")))
            ->add('formattedAddress', TextType::class, array(
                'label'=> 'miky_location.address',
                'required' => true,
                "attr" => array("class" => "gm_autocomplete_address")
            ))
            ->add('postalCode', HiddenType::class,array("attr" => array("class" => "postalCode")))
            ->add('city', HiddenType::class,array("attr" => array("class" => "locality")))
            ->add('country', HiddenType::class,array("attr" => array("class" => "country")))
            ->add('countryShortName', HiddenType::class,array("attr" => array("class" => "country_short")))
            ->add('continentShortName', HiddenType::class,array("attr" => array("class" => "continent_short")))
            ->add('administrativeAreaLevel2', HiddenType::class,array("attr" => array("class" => "administrative_area_level_2")))
            ->add('administrativeAreaLevel1', HiddenType::class,array("attr" => array("class" => "administrative_area_level_1")))
            ->add('latitude', HiddenType::class,array("attr" => array("class" => "lat")))
            ->add('longitude', HiddenType::class,array("attr" => array("class" => "lng")));
    }


}
