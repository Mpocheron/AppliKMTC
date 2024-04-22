<?php

namespace App\Form;

use App\Entity\Adresse;
use App\Entity\Casier;
use App\Entity\Commande;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
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
 
       
        // je n'ai pas intégré les adresses expedition (car récupéré avec user en vue) et destination (car relais colis)
            ->add('hauteur', options:[ 'label'=>'Hauteur (en cm)',
                                        'required' => true
            ])
            ->add('largeur', options:[ 'label'=>'Largeur (en cm)',
                                        'required' => true
            ])
            ->add('longueur', options:[ 'label'=>'Longueur (en cm)',
                                        'required' => true
            ])
            ->add('poids', options:[ 'label'=>'Poids (en kg)',
                                        'required' => true,

            ])    
            ->add('leUser', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'nom',
                'label' => 'Client'
            ]) 
            

            // ici mettre le relais
            //->add('nom', EntityType::class, ['mapped' => false ])
            
            ->add('adresseFacturation', EntityType::class, [
                'class' => Adresse::class,
                'choice_label' => function ($adresse) {
                    // Construire l'étiquette de choix personnalisée avec plusieurs colonnes
                    return $adresse->getNumero() . ' ' . $adresse->getNom() . ', ' . $adresse->getCodePostal() . ' ' . $adresse->getVille();
                },
                'label' => 'Adresse de facturation'
            ])

            ->add('COMMANDER', SubmitType::class,['label'=>'ENVOYER'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Commande::class,
        ]);
    }
}
