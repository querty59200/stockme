<?php

namespace App\Form;

use App\Entity\Luggage;
use App\Entity\Option;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LuggageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('images', FileType::class, [
                'label' => false,
                'multiple' => true,
                'mapped' => false,
                'required' => false
            ])
            ->add('name', TextType::class, [
                'required' => true,
                'label' => 'Nom'
             ])
//            ->add('description', TextareaType::class, [
            ->add('description', CKEditorType::class, [
                'required' => true,
                'label' => 'Description'
            ])
            ->add('available',CheckboxType::class, [
                'required' => true,
                'label' => 'Disponibilité'
            ])
            ->add('price', NumberType::class, [
                'required' => true,
                'label' => 'Prix'
            ])
            ->add('height', NumberType::class, [
                'required' => true,
                'label' => 'Hauteur'
            ])
            ->add('length', NumberType::class, [
                'required' => true,
                'label' => 'Longueur'
            ])
            ->add('width', NumberType::class, [
                'required' => true,
                'label' => 'Largeur'
            ])
            ->add('weight', NumberType::class, [
                'required' => true,
                'label' => 'Poids'
            ])
            ->add('options', EntityType::class, [
                'class' => Option::class,
                'choice_label' => 'name',
                'multiple' => true,
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
