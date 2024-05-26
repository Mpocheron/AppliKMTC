<?php

namespace App\Form;

use App\Entity\Commande;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Relais;
use App\Entity\Adresse;

class CommandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('adresseExpedition', AdresseType::class, [
                'label' => 'Adresse d\'expédition',
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Veuillez choisir une adresse d\'expédition.'])
                ],
            ])
            ->add('adresseDestination', AdresseType::class, [
                'label' => 'Adresse de destination',
                'required' => false,
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Adresse de destination obligatoire',
                        'groups' => ['adresse_required'],
                    ]),
                ],
            ])
            ->add('adresseFacturation', AdresseType::class, [
                'label' => 'Adresse de facturation',
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Veuillez fournir une adresse de facturation.'])
                ],
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
                        'min' => 1,
                        'max' => 40,
                        'notInRangeMessage' => 'Le poids doit être entre {{ min }} et {{ max }} kg.',
                    ]),
                ],
            ])
            
            ->add('nomDestinataire', TextType::class, [
                'label' => 'Nom du destinataire',
                'required' => false,
            ])
            ->add('prenomDestinataire', TextType::class, [
                'label' => 'Prénom du destinataire',
                'required' => false,
            ])
            ->add('relais', EntityType::class, [
                'class' => Relais::class,
                'choice_label' => 'nom',
                'label' => 'Relais',
                'placeholder' => 'Sélectionnez un relais',
                'required' => false,
                'choices' => $options['relais_choices'], // Utiliser l'option définie
                'attr' => [
                    'data-is-relais-selected' => $options['is_relais_selected'] // Utiliser l'option définie
                ],
            ])
            // ->add('submit', SubmitType::class, [
            //     'label' => 'Valider la commande'
            //])
            ->add('COMMANDER', SubmitType::class, ['label' => 'ENVOYER']);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Commande::class,
            'relais_choices' => [], // Définir une valeur par défaut
            'is_relais_selected' => false, // Définir une valeur par défaut
        ]);
    }
}
