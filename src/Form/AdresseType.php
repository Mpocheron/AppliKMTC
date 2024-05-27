<?php

// namespace App\Form;

// use App\Entity\Adresse;
// use App\Entity\Relais;
// use Symfony\Bridge\Doctrine\Form\Type\EntityType;
// use Symfony\Component\Form\AbstractType;
// use Symfony\Component\Form\FormBuilderInterface;
// use Symfony\Component\OptionsResolver\OptionsResolver;

// class AdresseType extends AbstractType
// {
//     public function buildForm(FormBuilderInterface $builder, array $options): void
//     {
//         $builder
//             ->add('numero')
//             ->add('nom')
//             ->add('codePostal')
//             ->add('ville')
//             ->add('longitude')
//             ->add('latitude')
//             ->add('leRelais', EntityType::class, [
//                 'class' => Relais::class,
//                 'choice_label' => 'id',
//             ])
//         ;
//     }

//     public function configureOptions(OptionsResolver $resolver): void
//     {
//         $resolver->setDefaults([
//             'data_class' => Adresse::class,
//         ]);
//     }
// }
// src/Form/AdresseType.php

namespace App\Form;

use App\Entity\Adresse;
use App\Entity\Relais;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdresseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('numero', TextType::class, [
                'label' => 'Numéro',
                'required' => true,
            ])
            ->add('nom', TextType::class, [
                'label' => 'Nom de la rue',
                'required' => true,
            ])
            ->add('codePostal', TextType::class, [
                'label' => 'Code Postal',
                'required' => true,
            ])
            ->add('ville', TextType::class, [
                'label' => 'Ville',
                'required' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Adresse::class,
        ]);
    }
}
