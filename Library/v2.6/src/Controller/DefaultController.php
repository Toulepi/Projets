<?php

namespace App\Controller;

use App\Repository\CatalogueRepository;
use App\Repository\ExemplaireRepository;
use App\Repository\LivreRepository;
use App\Repository\RubriqueRepository;
use App\Service\AppService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class DefaultController
 * @package App\Controller
 * @Route ("/",name="librairie_")
 *
 */
class DefaultController extends AbstractController
{

    /**
     * @param CatalogueRepository $repository
     * @param LivreRepository $repository1
     * @param AppService $service
     * @return Response
     * @Route ("/",name="accueil")
     */
    public function accueil(CatalogueRepository $repository, ExemplaireRepository $exemplaireRepository, AppService $service)
    {
        $exemplaires = $exemplaireRepository->findAll();
        $catalogue = $repository->findAll();
        return $this->render("user/accueil.html.twig", [
            'catalogue' => $catalogue,
            'exemplaires' => $exemplaires,
            'lignesCmds' => $service->contenuDuPanier(),
            'total'=>$service->getTotalPanier()
        ]);
    }

    /**
     * @return Response
     * @Route ("/rubrique", name="rubrique")
     */
    public function rubrique(RubriqueRepository $repository)
    {
        $rubriques = $repository->findAll();
        return $this->render("user/rubrique.html.twig", [
            'rubriques' => $rubriques,
        ]);
    }

    /**
     * @return Response
     * @Route ("/livre", name="livre")
     */
    public function livre()
    {
        return $this->render("user/livre.html.twig");
    }

    /**
     * @return Response
     * @Route ("/connexion", name="connexion")
     */
    public function connexion()
    {
        return $this->render("user/connexion.html.twig");
    }

    /**
     * @return Response
     * @Route ("/panier", name="panier")
     */
    public function panier()
    {
        return $this->render("user/panier.html.twig");
    }

    /**
     * @return Response
     * @Route ("/paiement", name="paiement")
     */
    public function paiement()
    {
        return $this->render("user/paiement.html.twig");
    }

    /**
     * @return Response
     * @Route ("/compte_connexion_actif",name="compte_connexion_actif")
     */
    public function compte_connexion_actif()
    {
        return $this->render("user/compte_connexion_actif.html.twig");
    }
}