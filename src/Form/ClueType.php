<?php

namespace App\Form;

use App\Entity\Clue;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('background')
            ->add('xAxis')
            ->add('yAxis')
            ->add('clueName')
            ->add('clueImg')
            ->add('description')
            ->add('sceneN')
            ->add('game', null, ['choice_label' => 'title'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Clue::class,
        ]);
    }
}
