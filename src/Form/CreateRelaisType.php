<?php

namespace App\Form;

use App\Validator\ContainsNumbers;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\PositiveOrZero;

class CreateRelaisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomRelais', TextType::class, ['label' => 'Nom du relais'])
            ->add('numeroAdresse', IntegerType::class, ['label' => 'Numéro de rue'])
            ->add('nomRue', TextType::class, ['label' => 'Rue'])
            ->add('codePostal', TextType::class, [
                'constraints' => [
                    new ContainsNumbers(),
                    new Length([
                        'min' => 5,
                        'max' => 5,
                        'minMessage' => 'Veuillez entrer un numero de téléphone valide',
                        'maxMessage' => 'Veuillez entrer un numero de téléphone valide',
                    ])
                ]
            ])
            ->add('ville', TextType::class)
            ->add('nombreCasierGrand', IntegerType::class, [
                'constraints' => [
                    new PositiveOrZero()
                ],
                'label' => "Nombre de grands casiers"
            ])
            ->add('nombreCasierMoyen', IntegerType::class, [
                'constraints' => [
                    new PositiveOrZero()
                ],
                'label' => "Nombre de casiers moyens"
            ])
            ->add('nombreCasierPetit', IntegerType::class, [
                'constraints' => [
                    new PositiveOrZero()
                ],
                'label' => "Nombre de grands petits casiers"
            ])
            ->add('submit', SubmitType::class, ['label' => 'Ajouter un relais'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => null
        ]);
    }
}
