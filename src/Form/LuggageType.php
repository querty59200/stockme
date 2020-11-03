<?php

namespace App\Form;

use App\Entity\Luggage;
use App\Entity\Option;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
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
            ->add('options', EntityType::class, [
                'label' => 'Option',
                'class' => Option::class,
                'choice_label' => 'name'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Luggage::class,
        ]);
    }
}
