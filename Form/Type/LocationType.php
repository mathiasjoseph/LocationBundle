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
class LocationType extends AbstractResourceType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array('label'=> 'miky_core.name'))
            ->add('streetNumber', TextType::class, array('label'=> 'miky_location.streetNumber'))
            ->add('street', TextType::class, array('label'=> 'miky_location.street'))
            ->add('postalCode', TextType::class, array('label'=> 'miky_location.postalCode'))
            ->add('city', TextType::class, array('label'=> 'miky_location.city'))
            ->add('country', TextType::class, array('label'=> 'miky_location.country'))
            ->add('countryShortName', TextType::class, array('label'=> 'miky_location.countryShortName'))
            ->add('continent', TextType::class, array('label'=> 'miky_location.continent'))
            ->add('continentShortName', TextType::class, array('label'=> 'miky_location.continentShortName'))
            ->add('formattedAddress', TextType::class, array('label'=> 'miky_location.formattedAddress'))
            ->add('administrativeAreaLevel2', TextType::class, array('label'=> 'miky_location.administrativeAreaLevel2'))
            ->add('administrativeAreaLevel1', TextType::class, array('label'=> 'miky_location.administrativeAreaLevel1'))
            ->add('latitude', TextType::class, array('label'=> 'miky_location.latitude'))
            ->add('longitude', TextType::class, array('label'=> 'miky_location.longitude'));
    }



}
