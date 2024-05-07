<?php

namespace App\Controller\Admin;

use App\Entity\Relais;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class RelaisCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Relais::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->hideOnForm(),
            TextField::new('nom'),
            AssociationField::new('leAdresse', 'Adresse'),
            AssociationField::new('lesCasiers', 'Casiers')
                ->setFormTypeOption('by_reference', false),
        ];
    }
}
