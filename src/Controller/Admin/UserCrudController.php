<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Doctrine\ORM\Mapping\Id;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return parent::configureCrud($crud)
            ->setDefaultSort([
                'roles' => 'DESC'
            ]);
    }

    public function configureFields(string $pageName): iterable
    {
        $roles = ['ROLE_SUPER_ADMIN', 'ROLE_ADMIN', 'ROLE_USER'];

        yield IdField::new('id')
            ->hideOnForm();
        yield EmailField::new('email');
        yield TextField::new('fullname', 'Nom')
            ->hideOnForm();
        yield TextField::new("nom")
            ->onlyOnForms();
        yield TextField::new("prenom")
            ->onlyOnForms();
        yield TextField::new('telephone', 'Téléphone');

        // Seul les super_admin ont les droits pour modifier les rôles des utilisateurs
        if ($this->isGranted('ROLE_SUPER_ADMIN')) {
            yield ChoiceField::new('roles', 'Rôles')
            ->setChoices(array_combine($roles, $roles))
            ->allowMultipleChoices()
            ->renderExpanded()
            ->renderAsBadges();
        }
        else {
            yield ChoiceField::new('roles', 'Rôles')
            ->hideOnForm()
            ->setChoices(array_combine($roles, $roles))
            ->allowMultipleChoices()
            ->renderExpanded()
            ->renderAsBadges();
        }
    }
}
