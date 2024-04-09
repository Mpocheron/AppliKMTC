<?php

namespace App\Form;

use App\Entity\Adresse;
use App\Entity\Casier;
use App\Entity\Commande;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommandeFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('hauteur', options:[ 'label'=>'Hauteur (en cm)'])
            ->add('largeur', options:[ 'label'=>'Largeur (en cm)'])
            ->add('longueur', options:[ 'label'=>'Longueur (en cm)'])
            ->add('poids', options:[ 'label'=>'Poids (en kg)'])
            ->add('leUser', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'nom',
                'label' => 'Client'
            ])
            ->add('adresseExpedition', EntityType::class, [
                'class' => Adresse::class,
                'choice_label' => function ($adresse) {
                    // Construire l'étiquette de choix personnalisée avec plusieurs colonnes
                    return $adresse->getNumero() . ' ' . $adresse->getNom() . ', ' . $adresse->getCodePostal() . ' ' . $adresse->getVille();
                },
                'label' => 'Adresse de l\'expéditeur'
            ])
            ->add('adresseDestination', EntityType::class, [
                'class' => adresse::class,
                'choice_label' => function ($adresse) {
                    // Construire l'étiquette de choix personnalisée avec plusieurs colonnes
                    return $adresse->getNumero() . ' ' . $adresse->getNom() . ', ' . $adresse->getCodePostal() . ' ' . $adresse->getVille();
                },
                'label' => 'Adresse de destination'
            ])
            ->add('adresseFacturation', EntityType::class, [
                'class' => Adresse::class,
                'choice_label' => function ($adresse) {
                    // Construire l'étiquette de choix personnalisée avec plusieurs colonnes
                    return $adresse->getNumero() . ' ' . $adresse->getNom() . ', ' . $adresse->getCodePostal() . ' ' . $adresse->getVille();
                },
                'label' => 'Adresse de facturation'
            ])
            ->add('leCasier', EntityType::class, [
                'class' => Casier::class,
                'choice_label' => 'id',
                'label' => 'Numéro de casier'
            ]) 
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Commande::class,
        ]);
    }
}
