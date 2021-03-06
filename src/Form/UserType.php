<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class UserType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Full Name',
                'attr' => [
                    'class' => 'form-control mb-3'
                ]
            ])
            ->add('email', EmailType::class, [
                'required' => false,
                'attr' => [
                    'class' => 'form-control mb-3'
                ]
            ])
            ->add('username', TextType::class, [
                'attr' => [
                    'class' => 'form-control mb-3'
                ]
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => [
                    'label' => 'Password', 
                    'attr' => [
                        'class' => 'form-control mb-3'
                    ]
                ],
                'second_options' => [
                    'label' => 'Repeat Password', 
                    'attr' => [
                    '   class' => 'form-control mb-3'
                    ]
                ]
            ])
            ->add('admin', ChoiceType::class, [
                'choices' => [
                    'Writer' => 'w',
                    'Admin' => 'a'
                ],
                'data' => 'w',
                'required' => false,
                'mapped' => false,
                'placeholder' => false,
                'label' => 'Role',
                'attr' => [
                    'class' => 'form-control mb-3'
                ]
            ])
            ->add('save', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-lg btn-blue'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => User::class
        ]);
    }
}