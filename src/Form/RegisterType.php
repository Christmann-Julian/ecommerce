<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegisterType extends AbstractType
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
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'constraints' => [new Length(['min' => 5, 'max' => 50]), new NotBlank()]
            ])
            ->add('password', RepeatedType::class, [
                'type'=> PasswordType::class,
                'invalid_message' => 'Les mots de passe doivent être identique.',
                'label' => 'Mot de passe',
                'first_options' => ['block_name'=>'pass','label'=>'Mot de passe'],
                'second_options' => ['label'=>'Confirmation du mot de passe']
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'S\'inscrire'
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
