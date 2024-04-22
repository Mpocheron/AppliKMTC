<?php

namespace App\Form;



use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class ColisFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('hauteur', IntegerType::class, [
                'label' => 'Hauteur (en cm)',
                'required' => true,
            ])
            ->add('largeur', IntegerType::class, [
                'label' => 'Largeur (en cm)',
                'required' => true,
            ])
            ->add('longueur', IntegerType::class, [
                'label' => 'Longueur (en cm)',
                'required' => true,
            ])
            ->add('poids', IntegerType::class, [
                'label' => 'Poids (en kg)',
                'required' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Vous n'avez pas besoin de spécifier de classe de données ici car il ne s'agit pas d'une entité
        ]);
    }
}