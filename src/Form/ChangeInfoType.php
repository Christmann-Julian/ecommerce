<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class ChangeInfoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('firstname', TextType::class, [
            'label' => 'Prénom',
            'constraints' => [new Length(['min' => 3, 'max' => 50]), new NotBlank()]
        ])
        ->add('lastname', TextType::class, [
            'label' => 'Nom',
            'constraints' => [new Length(['min' => 3, 'max' => 50]), new NotBlank()]
        ])
        ->add('old_password', PasswordType::class, [
            'label' => 'Mot de passe actuel',
            'mapped'=>false
        ])
        ->add('new_password', RepeatedType::class, [
            'type'=> PasswordType::class,
            'mapped'=> false,
            'invalid_message' => 'Les mots de passe doivent être identique.',
            'label' => 'Nouveau mot de passe',
            'first_options' => ['block_name'=>'pass','label'=>'Nouveau mot de passe'],
            'second_options' => ['label'=>'Confirmation du nouveau mot de passe']
        ])
        ->add('submit', SubmitType::class, [
            'label' => 'Modifier'
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
