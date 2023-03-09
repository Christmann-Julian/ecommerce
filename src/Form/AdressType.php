<?php

namespace App\Form;

use App\Entity\Adress;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AdressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom',
                'constraints' => [new Length(['min' => 3, 'max' => 50]), new NotBlank()]
            ])
            ->add('adress', TextType::class, [
                'label' => 'Adresse',
                'constraints' => [new Length(['min' => 3, 'max' => 100]), new NotBlank()]
            ])
            ->add('postal', TextType::class, [
                'label' => 'code Postal',
                'constraints' => [new Length(['min' => 3, 'max' => 50]), new NotBlank()]
            ])
            ->add('city', TextType::class, [
                'label' => 'Ville',
                'constraints' => [new Length(['min' => 3, 'max' => 50]), new NotBlank()]
            ])
            ->add('country', TextType::class, [
                'label' => 'Pays',
                'constraints' => [new Length(['min' => 3, 'max' => 50]), new NotBlank()]
            ])
            
            ->add('submit', SubmitType::class, [
                'label' => 'Valider'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Adress::class,
        ]);
    }
}
