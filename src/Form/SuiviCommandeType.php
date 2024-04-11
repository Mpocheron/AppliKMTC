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
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class SuiviCommandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('leUser', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'id',
            ])
            ->add('adresseDestination', EntityType::class, [
                'class' => Adresse::class,
                'choice_label' => 'id',
            ])
            ->add('orderNumber', TextType::class)
            ->add('orderStatus', ChoiceType::class, [
                'choices' => [
                    'En attente' => 'pending',
                    'En cours de livraison' => 'processing',
                    'Delivré' => 'delivered',
                ],
            ])
            ->add('deliveryDate', TextType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Commande::class,
        ]);
    }
    
}
