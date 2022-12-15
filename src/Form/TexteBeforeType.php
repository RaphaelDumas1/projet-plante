<?php

namespace App\Form;

use App\Entity\TexteBefore;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class TexteBeforeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class, ['required' => false,'empty_data' => ''])
            ->add('texte', TextareaType::class)
            ->add('logo', FileType::class, ['data_class' => null,'required' => false,'empty_data' => ''])
            ->add('plante')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TexteBefore::class,
        ]);
    }
}
