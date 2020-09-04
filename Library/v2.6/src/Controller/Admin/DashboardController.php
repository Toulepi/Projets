<?php

namespace App\Controller\Admin;

use App\Entity\Editeur;
use App\Entity\Exemplaire;
use App\Entity\Rediger;
use App\Entity\Theme;
use Doctrine\ORM\Mapping\Entity;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Router\CrudUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        // redirect to some CRUD controller
        $routeBuilder = $this->get(CrudUrlGenerator::class)->build();

        return $this->redirect($routeBuilder->setController(LivreCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Librairie Dwwm')
            ->setFaviconPath("/img/logo.svg");
    }

    public function configureMenuItems(): iterable
    {


        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Theme', 'fa fa-home', Theme::class);
        yield MenuItem::linkToCrud('Exemplaire', 'fa fa-home', Exemplaire::class);
        yield MenuItem::linkToCrud('Auteur', 'fa fa-home', Rediger::class);
    }
}
