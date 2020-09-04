<?php

namespace App\Entity;

use App\Repository\LigneCommandeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LigneCommandeRepository::class)
 */
class LigneCommande
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantite;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $pourcentage_remise;

    public function __construct($quantite,$exemplaire)
    {
        $this->quantite=$quantite;
        $this->exemplaire=$exemplaire;
    }

    /**
     * @ORM\ManyToOne(targetEntity=Commande::class, inversedBy="lignecommande")
     * @ORM\JoinColumn(nullable=false)
     */
    private $commande;

    /**
     * @ORM\ManyToOne(targetEntity=Exemplaire::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $exemplaire;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getPourcentageRemise(): ?int
    {
        return $this->pourcentage_remise;
    }

    public function setPourcentageRemise(?int $pourcentage_remise): self
    {
        $this->pourcentage_remise = $pourcentage_remise;

        return $this;
    }

    public function getCommande(): ?Commande
    {
        return $this->commande;
    }

    public function setCommande(?Commande $commande): self
    {
        $this->commande = $commande;

        return $this;
    }

    public function getExemplaire(): ?Exemplaire
    {
        return $this->exemplaire;
    }

    public function setExemplaire(?Exemplaire $exemplaire): self
    {
        $this->exemplaire = $exemplaire;

        return $this;
    }

    public function __toString()
    {
        return $this->getExemplaire()->getLivre()->getTitre();
    }

    public function getSousTotal()
    {
        //return $this->quantite * $this->getLivre()->getPrix();
        // to complete
        return ($this->quantite) * $this->getExemplaire()->getPrixUnitaire();
    }

}
