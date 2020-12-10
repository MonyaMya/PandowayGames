<?php

namespace App\Form;

use App\Entity\Dialog;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DialogType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('background')
            ->add('name')
            ->add('text')
            ->add('characterImg')
            ->add('description')
            ->add('sceneN')
            ->add('game', null, ['choice_label' => 'title'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Dialog::class,
        ]);
    }
}
