<?php

namespace App\Form;

use App\Entity\Scene;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class SceneType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('background')
            ->add('description')
            ->add('previousScene')
            ->add('dialog')
            ->add('investigation')
            ->add('game', null, ['choice_label' => 'title'])
            ->add('imageFile', VichImageType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Scene::class,
        ]);
    }
}
