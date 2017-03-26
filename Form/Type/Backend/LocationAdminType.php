<?php

namespace Miky\Bundle\LocationBundle\Form\Type\Backend;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class LocationType
 * @package Miky\Bundle\LocationBundle\Form
 */
class LocationAdminType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array('label'=> 'adevis.ui.name'))
            ->add('streetNumber', TextType::class, array('label'=> 'adevis.location.streetNumber'))
            ->add('street', TextType::class, array('label'=> 'adevis.location.street'))
            ->add('postalCode', TextType::class, array('label'=> 'adevis.location.postalCode'))
            ->add('city', TextType::class, array('label'=> 'adevis.location.city'))
            ->add('country', TextType::class, array('label'=> 'adevis.location.country'))
            ->add('countryShortName', TextType::class, array('label'=> 'adevis.location.countryShortName'))
            ->add('continent', TextType::class, array('label'=> 'adevis.location.continent'))
            ->add('continentShortName', TextType::class, array('label'=> 'adevis.location.continentShortName'))
            ->add('formattedAddress', TextType::class, array('label'=> 'adevis.location.formattedAddress'))
            ->add('administrativeAreaLevel2', TextType::class, array('label'=> 'adevis.location.administrativeAreaLevel2'))
            ->add('administrativeAreaLevel1', TextType::class, array('label'=> 'adevis.location.administrativeAreaLevel1'))
            ->add('latitude', TextType::class, array('label'=> 'adevis.location.latitude'))
            ->add('longitude', TextType::class, array('label'=> 'adevis.location.longitude'));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Miky\Bundle\LocationBundle\Entity\Location'
        ));
    }

}
