<?php

/**
 * AddressType class file
 *
 * PHP Version 7.1
 *
 * @category AddressType
 * @package  AddressType
 * @author   HumanAid <contact.humanaid@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://example.com/
 */

namespace App\Form;

use App\Entity\Address;
use App\Entity\Country;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * AddressType class
 *
 * The class holding the root AddressType class definition
 *
 * @category AddressType
 * @package  AddressType
 * @author   HumanAid <contact.humanaid@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://example.com/
 */
class AddressType extends AbstractType
{
    /**
     * Build a form for rating/comment
     *
     * @param FormBuilderInterface $builder build the form
     * @param array                $options got options
     *
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'street',
                TextType::class,
                [
                    'label'       => 'Rue :',
                    'required'    => true,
                    'attr'        => [
                        'class'   => 'form-control'
                    ],
                    'constraints' => [
                        new NotBlank()
                    ]
                ]
            )->add(
                'zipcode',
                TextType::class,
                [
                    'label'       => 'Code postal :',
                    'required'    => true,
                    'attr'        => [
                        'class'   => 'form-control'
                    ],
                    'constraints' => [
                        new NotBlank()
                    ]
                ]
            )->add(
                'city',
                TextType::class,
                [
                    'label'       => 'Ville :',
                    'required'    => true,
                    'attr'        => [
                        'class'   => 'form-control'
                    ],
                    'constraints' => [
                        new NotBlank()
                    ]
                ]
            )->add(
                'region',
                TextType::class,
                [
                    'label'       => 'Région :',
                    'required'    => false,
                    'attr'        => [
                        'class'   => 'form-control'
                    ]
                ]
            )->add(
                'department',
                TextType::class,
                [
                    'label'       => 'Département :',
                    'required'    => false,
                    'attr'        => [
                        'class'   => 'form-control'
                    ]
                ]
            )->add(
                'country',
                EntityType::class,
                [
                    'label'        => 'Pays :',
                    'required'     => true,
                    'class'        => Country::class,
                    'choice_label' => 'label',
                    'attr'         => [
                        'class'    => 'form-control'
                    ]
                ]
            );
    }

    /**
     * Configure form
     *
     * @param OptionsResolver $resolver set default parameters
     *
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
            'data_class' => Address::class,
            ]
        );
    }
}
