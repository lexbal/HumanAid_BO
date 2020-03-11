<?php

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

class RatingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('rating', IntegerType::class, [
                'label'       => 'Note :',
                'required'    => true,
                'attr'        => [
                    'class'   => 'form-control',
                    'min'     => '0',
                    'max'     => '5',
                ],
            ])->add('comment', TextareaType::class, [
                'label'       => 'Commentaire :',
                'required'    => true,
                'attr'        => [
                    'class'   => 'form-control'
                ],
                'constraints' => [
                    new NotBlank()
                ]
            ])->add('user', EntityType ::class, [
                'label'        => 'Utilisateur :',
                'class'        => User::class,
                'choice_label' => 'username',
                'attr'         => [
                    'class'    => 'form-control'
                ],
            ])
            ->add('event', EntityType ::class, [
                'label'        => 'Evenement :',
                'class'        => Event::class,
                'choice_label' => 'title',
                'attr'         => [
                    'class'    => 'form-control'
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Rating::class,
        ]);
    }
}
