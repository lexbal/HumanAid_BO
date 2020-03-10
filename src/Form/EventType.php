<?php

namespace App\Form;

use App\Entity\Event;
use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\{
    DateTimeType, IntegerType,
    TextareaType, TextType
};
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;


/**
 * Class EventType
 * @package App\Form
 */
class EventType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label'       => 'Titre :',
                'required'    => true,
                'attr'        => [
                    'class'   => 'form-control'
                ],
                'constraints' => [
                    new NotBlank()
                ]
            ])->add('description', TextareaType::class, [
                'label'       => 'Description :',
                'required'    => true,
                'attr'        => [
                    'class'   => 'form-control'
                ],
                'constraints' => [
                    new NotBlank()
                ]
            ])->add('start_date', DateTimeType::class, [
                'label'       => 'Date de début :',
                'date_widget' => 'single_text',
                'time_widget' => 'single_text'
            ])->add('end_date', DateTimeType::class, [
                'label'       => 'Date de fin :',
                'date_widget' => 'single_text',
                'time_widget' => 'single_text'
            ])->add('rating', IntegerType::class, [
                'label'       => 'Note :',
                'required'    => true,
                'attr'        => [
                    'class'   => 'form-control',
                    'min'     => '0',
                    'max'     => '5',
                ],
            ])->add('owner', EntityType ::class, [
                'label'        => 'Association :',
                'class'        => User::class,
                'choice_label' => 'name',
                'attr'         => [
                    'class'    => 'form-control'
                ],
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                              ->where("'ROLE_ASSOC' = u.roles");
                },
            ])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
