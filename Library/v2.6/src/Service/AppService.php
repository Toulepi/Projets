<?php

namespace App\Service;

use App\Entity\LigneCommande;
use App\Repository\ExemplaireRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**Permet entre autres de retourner un titre, mettre un mot en majuscules.
 * Les injections de dépendances (DI) se font par 'méthode' ou 'constructeur';
 * il faut savoir qu'il y a des injections que l'on ne peut faire par constructeur comme "Request"
 * Class AppService
 * @package App\Service
 */
class AppService
{
    /**
     * @var SessionInterface
     */
    private $session;
    /**
     * @var ExemplaireRepository
     */
    private $exemplaireRepository;

    /**
     * AppService constructor.
     * @param ExemplaireRepository $exemplaireRepository
     * @param SessionInterface $session
     */
    public function __construct(ExemplaireRepository $exemplaireRepository, SessionInterface $session)
    {
       // $this->exemplaireRepository = $exemplaireRepository;
        $this->exemplaireRepository = $exemplaireRepository;
        $this->session = $session;
    }

    public function capitalize(string $mot)
    {
        return ucwords(mb_strtoupper(trim($mot)));
    }

    /**Met toutes les lettres d'un mot en majuscules
     * @param string $mot
     * @return mixed|string|string[]
     */
    public function uppercase(string $mot)
    {
        return mb_strtoupper(trim($mot));
    }

    public function getTitre(string $titre)
    {
        return $titre;
    }

    public function getListeLivres(Request $request)
    {
        // Récupération de la liste des livres en BDD
       // $donnees = $this->livreRepository->findAll();
        $donnees = $this->exemplaireRepository->findAll();
        return $donnees;  // retourne la liste des livres récupérée
        /* Mise en place de la pagination
            $livres = $this->paginator->paginate(
                $donnees,
                $request->query->getInt('page',1),
                limit:8
            );
        */
    }

    public function ajouterAuPanier(int $id)
    {
        $panier = $this->session->get('panier', []);

        if (!empty($panier[$id])) {
            $panier[$id]++;
        } else {
            $panier[$id] = 1;
        }
        $this->session->set('panier', $panier);  // ajout d'une variable 'panier' en session
    }

    public function contenuDuPanier():array
    {
        // $session = $request->getSession();
        $panier = $this->session ->get('panier', []);

        $contenuDuPanier=[];

       // dd($contenuDuPanier);

        foreach($panier as $id => $quantite)  //parcours du contenu du panier
        {
            // à chaque tour de boucle, on créé une "ligne de commande"
            //$ldc = new LigneCommande($quantite,$this->exemplaireRepository->find($id));

            //$ldc = new LigneCommande($quantite,$this->livreRepository->find($id));
            $ldc = new LigneCommande($quantite,$this->exemplaireRepository->find($id));
            $contenuDuPanier[]=[
                'ligne_cmd'=>$ldc,
                /*
                'livre'=>$this->livreRepository->find($id),
                'quantite'=>$quantite,
                */
            ];
        }
        return $contenuDuPanier;  // retourne un tableau (array)
    }

    public function supprimerDuPanier($id){
        $panier = $this->session->get('panier',[]);
        if (!empty($panier[$id])){
            unset($panier[$id]);  // supression de l'element d'identifiant '$id' du panier
        }
        $this->session->set('panier',$panier);
    }

    public function getTotalPanier()
    {
        $items =$this->contenuDuPanier();
        $total = 0;
        foreach ($items as $item){  // un 'item' représente une ligne de commande
            $sous_total = $item['ligne_cmd']->getSousTotal();
            $total+=$sous_total;
        }
        return $total;
    }
}

?>