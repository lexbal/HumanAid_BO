<?php

namespace App\Form;

use App\Entity\Event;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\{
    DateTimeType, IntegerType,
    TextareaType, TextType
};
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
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
                    'class'   => 'form-control'
                ],
                'constraints' => [
                    new NotBlank(),
                ],
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
