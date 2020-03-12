<?php

/**
 * UserEditType class file
 *
 * PHP Version 7.1
 *
 * @category UserEditType
 * @package  UserEditType
 * @author   HumanAid <contact.humanaid@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://example.com/
 */

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\{
    NotBlank, Length
};
use Symfony\Component\Form\Extension\Core\Type\{
    ChoiceType, CollectionType, TextareaType,
    TextType, EmailType
};

/**
 * UserEditType class
 *
 * The class holding the root UserEditType class definition
 *
 * @category UserEditType
 * @package  UserEditType
 * @author   HumanAid <contact.humanaid@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://example.com/
 */
class UserEditType extends AbstractType
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
                'label' =>  'Nom :',
                'required'  =>  true,
                'attr'  =>  [
                    'class' =>  'form-control'
                ],
                'constraints'   =>  [
                    new NotBlank()
                ]
            ]
        )->add(
            'username', TextType::class, [
                'label' =>  'Pseudo :',
                'required'  =>  true,
                'attr'  =>  [
                    'class' =>  'form-control'
                ],
                'constraints'   =>  [
                    new NotBlank()
                ]
            ]
        )->add(
            'description', TextareaType::class, [
                'label' =>  'Description :',
                'required'  =>  false,
                'attr'  =>  [
                    'class' =>  'form-control'
                ],
            ]
        )->add(
            'status', TextType::class, [
                'label' =>  'Statut :',
                'required'  =>  false,
                'attr'  =>  [
                    'class' =>  'form-control'
                ],
            ]
        )->add(
            'siret', TextType::class, [
                'label' =>  'Numéro de SIRET :',
                'required'  =>  false,
                'constraints'   =>  [
                    new Length(
                        [
                            'min'   =>  14,
                            'minMessage' => 'Votre numéro de SIRET'.
                                'doit contenir {{ 14 }} chiffres',
                            'max'   =>  14
                        ]
                    ),
                ],
                'attr'  =>  [
                    'class' =>  'form-control'
                ],
            ]
        )->add(
            'location', TextType::class, [
                'label' =>  'Adresse :',
                'required'  =>  false,
                'attr'  =>  [
                    'class' =>  'form-control'
                ],
            ]
        )->add(
            'website', TextType::class, [
                'label' =>  'Site web :',
                'required'  =>  false,
                'attr'  =>  [
                    'class' =>  'form-control'
                ],
            ]
        )->add(
            'email', EmailType::class, [
                'label' =>  'Email :',
                'required'  =>  true,
                'attr'  =>  [
                    'class' =>  'form-control'
                ],
                'constraints'   =>  [
                    new NotBlank()
                ]
            ]
        )->add(
            'roles', CollectionType::class, [
                'label'          => "Roles :",
                'entry_type'     => ChoiceType::class,
                'entry_options'  => [
                    'label'      => false,
                    'required'   => true,
                    'multiple'   => false,
                    'attr'       => [
                        'class'  => 'form-control'
                    ],
                    'choices'    => $this->getChoices(),
                    'data'       => $options["data"]->getRoles()[0]
                ]
            ]
        );
    }

    /**
     * Create an array of roles
     *
     * @return array
     */
    public function getChoices()
    {
        $array = [];

        foreach (User::$roleTypes as $type) {
            $array[$type] = $type;
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
                'csrf_token_id'   => 'user_edit_item',
            ]
        );
    }
}
