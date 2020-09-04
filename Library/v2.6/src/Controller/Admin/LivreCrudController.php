<?php

namespace App\Controller\Admin;

use App\Entity\Livre;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class LivreCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Livre::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $infosLivre = FormField::addPanel("Infos Livre");
        $titre = TextField::new('titre');
        $prix =  IntegerField::new('prix','Prix HT(€)');
        $isbn = TextField::new('isbn');

        // Lors de l'insertion d'un livre, on priviligiera une convention de type livre{id}
        $imageFile = ImageField::new("imageFile")->setFormType(VichImageType::class);
        $imageName =  ImageField::new('imageName')->setBasePath('img/couvertureLivre');

        $theme = AssociationField::new("theme");

        $parution = DateField::new('date_parution');

        $resume = TextEditorField::new('resumer','Résumé');

        $updateAt = DateField::new('updatedAt','Date Mise à jour');

        $infosEditeur = FormField::addPanel("Infos Editeurs");
        $editeur = AssociationField::new('editeur');

       // $infosAuteur = FormField::addPanel("Infos Auteurs");
        //$auteurs = AssociationField::new('auteurs');

        $champs = [
            $infosLivre, $titre, $prix,$theme,$isbn, $parution, $resume /* $updateAt */
        ];

        if (Crud::PAGE_INDEX === $pageName || Crud::PAGE_DETAIL === $pageName) {
            $champs[] = $imageName;
        } else {
            $champs[] = $imageFile;
        }
        //$champs[] = $infosEditeur;
       // $champs[] = $editeur;
       // $champs[] = $infosAuteur;
        //$champs[] = $auteurs;
        return $champs;
    }
}
