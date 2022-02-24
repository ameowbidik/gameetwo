<?php

namespace App\Controller\Admin;

use App\Entity\Ad;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class AdCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Ad::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
