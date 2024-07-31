<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    //Cette méthode est utilisée pour personnaliser l'affichage et le comportement du CRUD pour l'entité "Utilisateur".
    public function configureCrud(Crud $crud): Crud
    {
        return $crud

            ->setEntityLabelInSingular('Utilisateur')
            ->setEntityLabelInPlural('Utilisateurs');
    }

    // cette methode permet de cree les champs necissaire pour les formulaire de crud lie a l'entite user
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('firstname', 'Prenom'),
            TextField::new('lastname', 'Nom'),
            EmailField::new('email', 'Email' )->onlyOnIndex()
        ];
    }

}
