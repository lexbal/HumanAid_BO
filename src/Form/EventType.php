<?php

/**
 * EventType class file
 *
 * PHP Version 7.1
 *
 * @category EventType
 * @package  EventType
 * @author   HumanAid <contact.humanaid@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://example.com/
 */

namespace App\Form;

use App\Entity\Event;
use App\Entity\EventCategory;
use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\{
    DateTimeType, TextareaType, TextType
};
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;


/**
 * EventType class
 *
 * The class holding the root EventType class definition
 *
 * @category EventType
 * @package  EventType
 * @author   HumanAid <contact.humanaid@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://example.com/
 */
class EventType extends AbstractType
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
            'title', TextType::class, [
                'label'       => 'Titre :',
                'required'    => true,
                'attr'        => [
                    'class'   => 'form-control'
                ],
                'constraints' => [
                    new NotBlank()
                ]
            ]
        )->add(
            'description', TextareaType::class, [
                'label'       => 'Description :',
                'required'    => true,
                'attr'        => [
                    'class'   => 'form-control'
                ],
                'constraints' => [
                    new NotBlank()
                ]
            ]
        )->add(
            'start_date', DateTimeType::class, [
                'label'       => 'Date de début :',
                'date_widget' => 'single_text',
                'time_widget' => 'single_text'
            ]
        )->add(
            'end_date', DateTimeType::class, [
                'label'       => 'Date de fin :',
                'date_widget' => 'single_text',
                'time_widget' => 'single_text'
            ]
        )->add(
            'owner', EntityType::class, [
                'label'        => 'Association :',
                'required'     => false,
                'class'        => User::class,
                'choice_label' => 'name',
                'attr'         => [
                    'class'    => 'form-control'
                ],
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where("'[\"ROLE_ASSOC\"]' = u.roles");
                },
            ]
        )->add(
            'categories', EntityType::class, [
                'label'      => 'Categories :',
                'attr'       => [
                    'class'  => 'form-control'
                ],
                'class'        => EventCategory::class,
                'choice_label' => 'label',
                'multiple'     => true,
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
                'data_class'      => Event::class,
                'csrf_protection' => true,
                'csrf_field_name' => '_token',
                'csrf_token_id'   => 'event_item',
            ]
        );
    }
}
