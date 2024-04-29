<?php

namespace App\Form;

use App\Entity\User;
use App\Validator\ContainsLetters;
use App\Validator\ContainsNumbers;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            ->add('nom', TextType::class, [
                'constraints' => [
                    new ContainsLetters(
                        null,
                        'Seuls les caractères alphabétiques sont autorisés'
                    )
                ]
            ])
            ->add('prenom', TextType::class, [
                'constraints' => [
                    new ContainsLetters(
                        null,
                        'Seuls les caractères alphabétiques sont autorisés'
                    )
                ]
            ])
            ->add('telephone', TelType::class, [
                'constraints' => [
                    new ContainsNumbers(
                        null,
                        'Veuillez entrer un numero de téléphone valide'
                    ),
                    new Length([
                        'min' => 10,
                        'max' => 10,
                        'minMessage' => 'Veuillez entrer un numero de téléphone valide',
                        'maxMessage' => 'Veuillez entrer un numero de téléphone valide',
                    ]),
                ]
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez accepter nos conditions d\'utilisation.',
                    ]),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer un mot de passe.',
                    ]),
                    new Length([
                        'min' => 8,
                        'minMessage' => 'Votre mot de passe doit contenir au moins {{ limit }} caractères.',
                        // Longueur maximale autorisée par Symfony pour des raisons de sécurité
                        'max' => 4096,
                    ]),
                ],
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
