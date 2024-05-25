<?php

namespace App\Form;

use App\Entity\Adresse;
use App\Entity\Commande;
use App\Entity\Relais;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class CommandeFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('adresseExpedition', EntityType::class, [
                'class' => Adresse::class,
                'choice_label' => function ($adresse) {
                    return $adresse->getNumero() . ' ' . $adresse->getNom() . ', ' . $adresse->getCodePostal() . ' ' . $adresse->getVille();
                },
                'label' => 'Adresse d\'expédition'
            ])
            ->add('adresseDestination', EntityType::class, [
                'class' => Adresse::class,
                'choice_label' => function ($adresse) {
                    return $adresse->getNumero() . ' ' . $adresse->getNom() . ', ' . $adresse->getCodePostal() . ' ' . $adresse->getVille();
                },
                'label' => 'Adresse de destination'
            ])
            ->add('adresseFacturation', EntityType::class, [
                'class' => Adresse::class,
                'choice_label' => function ($adresse) {
                    return $adresse->getNumero() . ' ' . $adresse->getNom() . ', ' . $adresse->getCodePostal() . ' ' . $adresse->getVille();
                },
                'label' => 'Adresse de facturation'
            ])
            ->add('hauteur', IntegerType::class, [
                'label' => 'Hauteur (en cm)',
                'required' => true,
                'constraints' => [
                    new Assert\Range([
                        'min' => 1,
                        'max' => 90,
                        'notInRangeMessage' => 'La hauteur doit être entre {{ min }} et {{ max }} cm.',
                    ]),
                ],
            ])
            ->add('largeur', IntegerType::class, [
                'label' => 'Largeur (en cm)',
                'required' => true,
                'constraints' => [
                    new Assert\Range([
                        'min' => 1,
                        'max' => 90,
                        'notInRangeMessage' => 'La largeur doit être entre {{ min }} et {{ max }} cm.',
                    ]),
                ],
            ])
            ->add('longueur', IntegerType::class, [
                'label' => 'Longueur (en cm)',
                'required' => true,
                'constraints' => [
                    new Assert\Range([
                        'min' => 1,
                        'max' => 90,
                        'notInRangeMessage' => 'La longueur doit être entre {{ min }} et {{ max }} cm.',
                    ]),
                ],
            ])
            ->add('poids', IntegerType::class, [
                'label' => 'Poids (en kg)',
                'required' => true,
                'constraints' => [
                    new Assert\Range([
                        'min' => 0,
                        'max' => 15,
                        'notInRangeMessage' => 'Le poids doit être entre {{ min }} et {{ max }} kg.',
                    ]),
                ],
            ])
            ->add('nomDestinataire', TextType::class, [
                'label' => 'Nom',
                'required' => true,
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Le nom du destinataire ne peut pas être vide.']),
                    new Assert\Length([
                        'max' => 30,
                        'maxMessage' => 'Le nom ne doit pas dépasser {{ limit }} caractères.',
                    ]),
                    new Assert\Regex([
                        'pattern' => '/^[a-zA-Z]+$/',
                        'message' => 'Le nom ne doit contenir que des lettres sans espace.',
                    ]),
                ],
            ])
            ->add('prenomDestinataire', TextType::class, [
                'label' => 'Prénom',
                'required' => true,
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Le prénom du destinataire ne peut pas être vide.']),
                    new Assert\Length([
                        'max' => 30,
                        'maxMessage' => 'Le prénom ne doit pas dépasser {{ limit }} caractères.',
                    ]),
                    new Assert\Regex([
                        'pattern' => '/^[a-zA-Z]+$/',
                        'message' => 'Le prénom ne doit contenir que des lettres sans espace.',
                    ]),
                ],
            ])
            ->add('relais', EntityType::class, [
                'class' => Relais::class,
                'choices' => $options['relais_choices'],
                'choice_label' => 'nom',
                'mapped' => false,
                'label' => 'Choix du relais',
                'placeholder' => 'Sélectionner un relais',
                'required' => false,
            ])
            ->add('COMMANDER', SubmitType::class, ['label' => 'ENVOYER']);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Commande::class,
            'relais_choices' => [],
        ]);
    }
}
