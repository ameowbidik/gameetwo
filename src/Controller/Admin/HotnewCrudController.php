<?php

namespace App\Controller\Admin;

use App\Entity\Hotnew;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class HotnewCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Hotnew::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title'),
            TextField::new('slug')->hideOnForm(),
            TextareaField::new('content'),
            DateTimeField::new('createAt'),
            // DateTimeField::new('publishAt'),
        
        ];
    }
    public function configureCrud( Crud $crud): Crud
    {
        return $crud
            ->setDefaultSort(['createAt' => 'DESC']);
    }
    
}
