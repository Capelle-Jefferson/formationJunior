<?php

namespace App\Form;

use App\Entity\CategorieArticle;
use App\Entity\Articles;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ArticleFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextType::class, [
                'label' => "Titre de l'article",
                'attr' => [
                    'class' => "form-control",
                    'placeholder' => "Titre de l'article"
                ]
            ])
            ->add('resume', TextareaType::class, [
                'label' => "Résumé:",
                'attr' => [
                    'class' => "form-control",
                    'placeholder' => "Résumé"
                ]
            ])
            ->add('contenu', CKEditorType::class)
            ->add('categorie', EntityType::class, [
                'class' => CategorieArticle::class,
                'placeholder' => false,
            ])
            ->add('Envoyer', SubmitType::class, [
                'attr' => [
                    'class' => "btn btn-primary"
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Articles::class,
        ]);
    }
}
