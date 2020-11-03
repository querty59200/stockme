<?php

namespace App\Form;

use App\Entity\Luggage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LuggageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('available')
            ->add('price')
            ->add('height')
            ->add('length')
            ->add('width')
            ->add('weight')
            ->add('options')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Luggage::class,
        ]);
    }
}
