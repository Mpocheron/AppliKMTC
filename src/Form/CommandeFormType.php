<?php

namespace App\Form;

use App\Entity\Adresse;
use App\Entity\Casier;
use App\Entity\Commande;
use App\Entity\User;
use App\Entity\Relais;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints as Assert;
use App\Form\ColisFormType; 

class CommandeFormType extends AbstractType
{   //création du formulaire de commande
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        /* Dans le cas ou l'on souhaite avoir 1 ou + de colis
        // ici on rentre le nombre de colis à envoyer 
        ->add('nombreColis', IntegerType::class, [
                'label' => 'Nombre de colis',
                // Autres options du champ nombreColis
            ])
            ->add('colis', CollectionType::class, [
                'entry_type' => ColisFormType::class,
                'entry_options' => ['label' => false], // Option pour masquer le label des champs de colis
                'allow_add' => true, // Autoriser l'ajout dynamique de nouveaux champs de colis
                'by_reference' => false, // Nécessaire pour que les éléments ajoutés soient correctement associés à l'entité parente
            ])*/
 
       ->add('adresseFacturation', EntityType::class, [
                'class' => Adresse::class,
                'choice_label' => function ($adresse) {
                    // Construire l'étiquette de choix personnalisée avec plusieurs colonnes
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
                        'max' => 30, // Exemple : 30 caractères maximum
                        'maxMessage' => 'Le nom ne doit pas dépasser {{ limit }} caractères.',
                    ]),
                    new Assert\Regex([
                        'pattern' => '/^[a-zA-Z]+$/', // Permet uniquement les lettres
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
                        'max' => 30, // Exemple : 30 caractères maximum
                        'maxMessage' => 'Le prénom ne doit pas dépasser {{ limit }} caractères.',
                    ]),
                    new Assert\Regex([
                        'pattern' => '/^[a-zA-Z]+$/', // Permet uniquement les lettres
                        'message' => 'Le prénom ne doit contenir que des lettres sans espace.',
                    ]),
                ],
            ])
            
            // Deroulant choix du point relais
            ->add('relais', EntityType::class, [
                'class' => Relais::class,
                'choices' => $options['relais_choices'],  // Utilisez le paramètre fourni
                'choice_label' => 'nom', // Assurez-vous que l'entité Relais a un champ "nom" ou similaire
                'mapped' => false, // Parce que ce n'est pas une relation directe
                'label' => 'Choix du relais',
                'placeholder' => 'Sélectionner un relais', // Optionnel
                'required' => false, // Ajustez selon vos besoins
            ])
            
            
            ->add('adresseDestination', AdresseDestinationType::class, [
                'label' => 'Adresse de Destination',
                'required' => false,
            ])
            
            ->add('COMMANDER', SubmitType::class,['label'=>'ENVOYER'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Commande::class,
        ]);
        $resolver->setDefined(['relais_choices']);  // Autoriser des paramètres supplémentaires
    }
}
