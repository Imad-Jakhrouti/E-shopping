<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud

            ->setEntityLabelInSingular('Produit')
            ->setEntityLabelInPlural('Produits');
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name', 'Titre')
                ->setHelp('Le titre de produit')
                ->setRequired(true),
            SlugField::new('slug', 'URL')
                ->setTargetFieldName('name')->
                setHelp('URL  de votre produit'),
            TextEditorField::new('description', 'Description')
                ->setHelp('Description de votre produit'),
            ImageField::new('image', 'Image')
                ->setHelp('Image de votre produit')
                ->setUploadDir('public/uploads'),
            NumberField::new('price', 'Prix')
                ->setHelp('Le prix de votre produit'),
            ChoiceField::new('tva','TVA')
                ->setHelp('TVA de votre produit')
                ->setChoices([
                    '5.5%' => '5.5',
                    '10%' => '10',
                    '15%' => '15',
                    '20%' => '20',
                ]),
            AssociationField::new('category', 'Catégorie associé')
        ];
    }
}
