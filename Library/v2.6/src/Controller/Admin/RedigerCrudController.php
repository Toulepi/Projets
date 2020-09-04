<?php

namespace App\Controller\Admin;

use App\Entity\Rediger;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;

class RedigerCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Rediger::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            //IdField::new('id'),
            AssociationField::new('auteur'),
            AssociationField::new('livre')
        ];
    }

}
