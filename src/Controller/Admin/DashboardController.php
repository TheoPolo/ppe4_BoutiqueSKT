<?php

namespace App\Controller\Admin;

use App\Entity\Categorie;
use App\Entity\Panier;
use App\Entity\Produit;
use App\Entity\Tag;
use App\Entity\User;
use Doctrine\ORM\Query;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        //return parent::index();
        if($this->isGranted('ROLE_ADMIN')){
            return $this->render('dashboard/my-dashboard.html.twig');
        }else if($this->isGranted('ROLE_USER')){
            return $this->render('dashboard/error.html.twig');
        }

    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Boutique');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('User', 'fas fa-address-card', User::class);
        yield MenuItem::linkToCrud('Produit', 'fas fa-list', Produit::class);
        yield MenuItem::linkToCrud('Tag', 'fas fa-tags', Tag::class);
        yield MenuItem::linkToCrud('Categorie', '	fa fa-archive', Categorie::class);
    }
}
