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
    ChoiceType, TextType,
    EmailType
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
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', TextType::class, [
                'label' =>  'Nom :',
                'required'  =>  true,
                'attr'  =>  [
                    'class' =>  'form-control'
                ],
                'constraints'   =>  [
                    new NotBlank()
                ]
            ])->add('username', TextType::class, [
                'label' =>  'Pseudo :',
                'required'  =>  true,
                'attr'  =>  [
                    'class' =>  'form-control'
                ],
                'constraints'   =>  [
                    new NotBlank()
                ]
            ])->add('description', TextType::class, [
                'label' =>  'Description :',
                'required'  =>  false,
                'attr'  =>  [
                    'class' =>  'form-control'
                ],
            ])->add('status', TextType::class, [
                'label' =>  'Statut :',
                'required'  =>  false,
                'attr'  =>  [
                    'class' =>  'form-control'
                ],
            ])->add('siret', TextType::class, [
                'label' =>  'Numéro de SIRET :',
                'required'  =>  false,
                'constraints'   =>  [
                    new Length([
                        'min'   =>  14,
                        'minMessage' => 'Votre numéro de SIRET doit contenir {{ 14 }} chiffres',
                        'max'   =>  14

                    ]),
                    ],
                'attr'  =>  [
                    'class' =>  'form-control'
                ],
            ])->add('location', TextType::class, [
                'label' =>  'Adresse :',
                'required'  =>  false,
                'attr'  =>  [
                    'class' =>  'form-control'
                ],
            ])->add('website', TextType::class, [
                'label' =>  'Site web :',
                'required'  =>  false,
                'attr'  =>  [
                    'class' =>  'form-control'
                ],
            ])->add('email', EmailType::class, [
                'label' =>  'Email :',
                'required'  =>  true,
                'attr'  =>  [
                    'class' =>  'form-control'
                ],
                'constraints'   =>  [
                    new NotBlank()
                ]
            ])->add('roles', ChoiceType::class, [
                'label'      => 'Role :',
                'required'   => true,
                'attr'       => [
                    'class'  => 'form-control'
                ],
                'choices'    => $this->getChoices(),
                'data'       => $options["data"]->getRoles()[0]
            ]);
    }

    /**
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
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
