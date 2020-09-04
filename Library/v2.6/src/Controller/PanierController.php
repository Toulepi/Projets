<?php

namespace App\Controller;

use App\Service\AppService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PanierController
 * @package App\Controller
 * @Route ("/panier", name="panier_")
 */
class PanierController extends AbstractController
{
    /**
     * @Route("/", name="contenu")
     * @param AppService $service
     * @return Response
     */
    public function contenuDuPanier(AppService $service)
    {
        $contenuDuPanier = $service->contenuDuPanier();
        dd($contenuDuPanier);

        return $this->render(
            'user/panier.html.twig',
            [
                'controller_name' => 'PanierController',
            ]
        );
    }

    /**
     * @Route("/ajouter/{id}", name="ajouter", methods={"GET", "POST"})
     * @param int $id
     * @param AppService $service
     * @return RedirectResponse
     */
    public function ajouter(int $id,AppService $service)
    {
        $service->ajouterAuPanier($id);
        return $this->redirectToRoute('librairie_accueil');

    }

    /**
     * @Route("/supprimer/{id}",name="supprimer",methods={"GET", "POST"})
     * @param int $id
     * @param AppService $service
     * @return RedirectResponse
     */
    public function supprimer(int $id,AppService $service)
    {
        $service->supprimerDuPanier($id);
        return $this->redirectToRoute('librairie_accueil');
    }
}
