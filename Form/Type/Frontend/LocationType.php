<?php

namespace Miky\Bundle\LocationBundle\Form\Type\Frontend;

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
class LocationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array('label'=> 'adevis.ui.name'))
            ->add('streetNumber', HiddenType::class)
            ->add('street', HiddenType::class)
            ->add('formattedAddress', TextType::class, array(
                'label'=> 'adevis.ui.address',
                'required' => true
            ))
            ->add('postalCode', HiddenType::class)
            ->add('city', HiddenType::class)
            ->add('country', HiddenType::class)
            ->add('countryShortName', HiddenType::class)
            ->add('continentShortName', HiddenType::class)
            ->add('administrativeAreaLevel2', HiddenType::class)
            ->add('administrativeAreaLevel1', HiddenType::class)
            ->add('latitude', HiddenType::class)
            ->add('longitude', HiddenType::class)
            ->add('submit', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Miky\Bundle\LocationBundle\Entity\Location'
        ));
    }

}
