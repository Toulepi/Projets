<?php

namespace App\Entity;

use App\Repository\AuteurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AuteurRepository::class)
 */
class Auteur
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $nom_auteur;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $prenom_auteur;


    /**
     */
    private $livres;

    /**
     * @ORM\OneToMany(targetEntity=Rediger::class, mappedBy="auteur")
     */
    private $redacteur;

    public function __construct()
    {
        $this->livres = new ArrayCollection();
        $this->redacteur = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomAuteur(): ?string
    {
        return $this->nom_auteur;
    }

    public function setNomAuteur(string $nom_auteur): self
    {
        $this->nom_auteur = $nom_auteur;

        return $this;
    }

    public function getPrenomAuteur(): ?string
    {
        return $this->prenom_auteur;
    }

    public function setPrenomAuteur(string $prenom_auteur): self
    {
        $this->prenom_auteur = $prenom_auteur;

        return $this;
    }


    /**
     * @return Collection|Livre[]
     */
    public function getLivres(): Collection
    {
        return $this->livres;
    }

    public function addLivre(Livre $livre): self
    {
        if (!$this->livres->contains($livre)) {
            $this->livres[] = $livre;
        }

        return $this;
    }

    public function removeLivre(Livre $livre): self
    {
        if ($this->livres->contains($livre)) {
            $this->livres->removeElement($livre);
        }

        return $this;
    }

    /**
     * @return Collection|Rediger[]
     */
    public function getRedacteur(): Collection
    {
        return $this->redacteur;
    }

    public function addRedacteur(Rediger $redacteur): self
    {
        if (!$this->redacteur->contains($redacteur)) {
            $this->redacteur[] = $redacteur;
            $redacteur->setAuteur($this);
        }

        return $this;
    }

    public function removeRedacteur(Rediger $redacteur): self
    {
        if ($this->redacteur->contains($redacteur)) {
            $this->redacteur->removeElement($redacteur);
            // set the owning side to null (unless already changed)
            if ($redacteur->getAuteur() === $this) {
                $redacteur->setAuteur(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
       return $this->nom_auteur;
    }

}
