<?php

namespace App\Controller\Admin;

use App\Entity\Categorie;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CategorieCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Categorie::class;
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
    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) {
                return $action->setIcon('fa fa-plus')->setLabel("Créer une catégorie");
            })
            ->update(Crud::PAGE_INDEX, Action::EDIT, function(Action $action){
                return $action->setIcon('fa fa-edit')->setLabel('Editer')
                    ->addCssClass('btn btn-transparant');
            })
            ->update(Crud::PAGE_INDEX, Action::DELETE, function(Action $action){
                return $action->setIcon('fa fa-trash')->setLabel('Supprimer')
                    ->addCssClass('btn btn-transparant');
            });
    }
}
