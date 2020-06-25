<?php

/**
 * RatingType class file
 *
 * PHP Version 7.1
 *
 * @category RatingType
 * @package  RatingType
 * @author   HumanAid <contact.humanaid@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://example.com/
 */

namespace App\Form;

use App\Entity\Event;
use App\Entity\Rating;
use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * RatingType class
 *
 * The class holding the root RatingType class definition
 *
 * @category RatingType
 * @package  RatingType
 * @author   HumanAid <contact.humanaid@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://example.com/
 */
class RatingType extends AbstractType
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
            'rating', IntegerType::class, [
                'label'       => 'Note :',
                'required'    => true,
                'attr'        => [
                    'class'   => 'form-control',
                    'min'     => '0',
                    'max'     => '5',
                ],
            ]
        )->add(
            'comment', TextareaType::class, [
                'label'       => 'Commentaire :',
                'required'    => true,
                'attr'        => [
                    'class'   => 'form-control'
                ],
                'constraints' => [
                    new NotBlank()
                ]
            ]
        )->add(
            'user', EntityType ::class, [
                'label'        => 'Utilisateur :',
                'required'     => false,
                'class'        => User::class,
                'choice_label' => 'username',
                'attr'         => [
                    'class'    => 'form-control'
                ],
            ]
        )->add(
            'event', EntityType ::class, [
                'label'        => 'Evenement :',
                'required'     => false,
                'class'        => Event::class,
                'choice_label' => 'title',
                'attr'         => [
                    'class'    => 'form-control'
                ],
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
                'data_class'      => Rating::class,
                'csrf_protection' => true,
                'csrf_field_name' => '_token',
                'csrf_token_id'   => 'rating_item',
            ]
        );
    }
}
