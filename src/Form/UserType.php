<?php

/**
 * UserType class file
 *
 * PHP Version 7.1
 *
 * @category UserType
 * @package  UserType
 * @author   HumanAid <contact.humanaid@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://example.com/
 */

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\{
    NotBlank, Length
};
use Symfony\Component\Form\Extension\Core\Type\{ChoiceType,
    CollectionType,
    IntegerType,
    TextareaType,
    TextType,
    RepeatedType,
    EmailType,
    PasswordType};

/**
 * UserType class
 *
 * The class holding the root UserType class definition
 *
 * @category UserType
 * @package  UserType
 * @author   HumanAid <contact.humanaid@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://example.com/
 */
class UserType extends AbstractType
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
        $builder->add(
            'name', TextType::class, [
                'label'     =>  'Nom :',
                'required'  =>  true,
                'attr'      =>  [
                    'class' =>  'form-control'
                ],
                'constraints' =>  [
                    new NotBlank()
                ]
            ]
        )->add(
            'username', TextType::class, [
                'label'     =>  'Pseudo :',
                'required'  =>  true,
                'attr'      =>  [
                    'class' =>  'form-control'
                ],
                'constraints' =>  [
                    new NotBlank()
                ]
            ]
        )->add(
            'landline', TextType::class, [
                'label'     =>  'Telephone :',
                'required'  =>  false,
                'attr'      =>  [
                    'class' =>  'form-control'
                ],
            ]
        )->add(
            'email', EmailType::class, [
                'label'     =>  'Email :',
                'required'  =>  true,
                'attr'      =>  [
                    'class' =>  'form-control'
                ],
                'constraints' =>  [
                    new NotBlank()
                ]
            ]
        )->add(
            'roles', ChoiceType::class, [
                'label'      => "Roles :",
                'required'   => true,
                'multiple'   => false,
                'attr'       => [
                    'class'  => 'form-control'
                ],
                'choices'    => $this->getChoices(),
                'data'       => User::ROLE_USER
            ]
        )->add(
            'password', RepeatedType::class, [
                'type'        => PasswordType:: class,
                'constraints' => [
                    new NotBlank(
                        [
                            'message' => 'You have to write an password',
                        ]
                    ),
                    new Length(
                        [
                            'min' => 6,
                            'minMessage' => 'Votre mot de passe'.
                                'doit contenir {{ limit }} caractères',
                            'max' => 4096,
                        ]
                    ),
                ],
                'first_options' => [
                    'label' => 'Mot de passe* : ',
                    'attr'  => [
                        'class' => 'form-control'
                    ]
                ],
                'second_options' => [
                    'label' => 'Confirmation Mot de passe* : ',
                    'attr'  => [
                        'class' => 'form-control'
                    ]
                ],
            ]
        )->add(
            'addresses', CollectionType::class, [
                'label'          => "Addresses :",
                'allow_add'      => true,
                'prototype'      => true,
                'entry_type'     => AddressType::class
            ]
        );

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) {
                $this->checkRole(
                    $event->getForm(),
                    $event->getData()->getRole()
                );
            }
        );

        $builder->get('roles')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) {
                $this->checkRole(
                    $event->getForm()->getParent(),
                    $event->getForm()->getData()
                );
            }
        );
    }

    /**
     * Form roles changer
     *
     * @param FormInterface $form Form
     * @param string        $role Roles
     *
     * @return mixed
     */
    public function checkRole(FormInterface $form, $role)
    {
        if ($role === User::ROLE_COMP || $role === User::ROLE_ASSOC) {
            $form->add(
                'manager_first_name', TextType::class, [
                    'label'     => "Prénom du manager :",
                    'required'  =>  false,
                    'attr'      =>  [
                        'class' =>  'form-control'
                    ]
                ]
            )->add(
                'manager_last_name', TextType::class, [
                    'label'     => "Nom du manager :",
                    'required'  =>  false,
                    'attr'      =>  [
                        'class' =>  'form-control'
                    ]
                ]
            )->add(
                'website', TextType::class, [
                    'label'     =>  'Site web :',
                    'required'  =>  false,
                    'attr'      =>  [
                        'class' =>  'form-control'
                    ],
                ]
            )->add(
                'siret', TextType::class, [
                    'label'       => 'Numéro de SIRET :',
                    'required'    => false,
                    'constraints' => [
                        new Length(
                            [
                                'min'        =>  14,
                                'minMessage' => 'Votre numéro de SIRET doit'.
                                    'contenir {{ 14 }} chiffres',
                                'max'        =>  14
                            ]
                        ),
                    ],
                    'attr'  =>  [
                        'class' =>  'form-control'
                    ],
                ]
            )->add(
                'description', TextareaType::class, [
                    'label'     =>  'Description :',
                    'required'  =>  false,
                    'attr'      =>  [
                        'class' =>  'form-control'
                    ],
                ]
            )->add(
                'status', TextType::class, [
                    'label'     =>  'Statut :',
                    'required'  =>  false,
                    'attr'      =>  [
                        'class' =>  'form-control'
                    ],
                ]
            )->add(
                'facebook', TextType::class, [
                    'label'     =>  'Lien facebook :',
                    'required'  =>  false,
                    'attr'      =>  [
                        'class' =>  'form-control'
                    ],
                ]
            )->add(
                'twitter', TextType::class, [
                    'label'     =>  'Lien twitter :',
                    'required'  =>  false,
                    'attr'      =>  [
                        'class' =>  'form-control'
                    ],
                ]
            );
        }
    }

    /**
     * Create an array of roles
     *
     * @return array
     */
    public function getChoices()
    {
        $array = [];

        foreach (User::$roleStringTypes as $typeString => $type) {
            $array[$type] = $typeString;
        }

        return $array;
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
                'data_class'      => User::class,
                'csrf_protection' => true,
                'csrf_field_name' => '_token',
                'csrf_token_id'   => 'user_item',
            ]
        );
    }
}
