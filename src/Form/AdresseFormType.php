<?php

namespace App\Form;

use App\Entity\Adresse;
use App\Validator\ContainsLetters;
use App\Validator\ContainsNumbers;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdresseFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('numero')
            ->add('nom', TextType::class, [
                'constraints' => [
                    new ContainsLetters(
                        null,
                        'Seuls les caractères alphabétiques sont autorisés'
                    )
                ]
            ])
            ->add('codePostal', TextType::class, [
                'constraints' => [
                    new ContainsNumbers(
                        null,
                        'Veuillez entrer un code postal valide'
                    )
                ]
            ])
            ->add('ville')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Adresse::class,
        ]);
    }
}
