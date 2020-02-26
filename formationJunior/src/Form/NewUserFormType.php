<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewUserFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, [
                'label' => "Nom d'utilisateur",
                'attr' => [
                    'class' => "form-control"
                ]
            ])
            ->add('mail', EmailType::class, [
                'label' => "Adresse mail",
                'attr' => [
                    'class' => "form-control"
                ]
            ])
            ->add('password', PasswordType::class, [
                'label' => "Mot de passe",
                'attr' => [
                    'class' => "form-control"
                ]
            ])
            ->add('confirm_password', PasswordType::class, [
                'label' => "Confirmation du mot de passe",
                'attr' => [
                    'class' => "form-control"
                ]
            ])
            ->add('S\'inscrire', SubmitType::class, [
                'attr' => [
                    'class' => "btn btn-primary"
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}
