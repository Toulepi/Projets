<?php

namespace App\Entity;

use App\Repository\EditeurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EditeurRepository::class)
 */
class Editeur
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
    private $maison_edition;

    /**
     * @ORM\OneToMany(targetEntity=Exemplaire::class, mappedBy="editeur", orphanRemoval=true)
     */
    private $exemplaire;

    public function __construct()
    {
        $this->exemplaire = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMaisonEdition(): ?string
    {
        return $this->maison_edition;
    }

    public function setMaisonEdition(string $maison_edition): self
    {
        $this->maison_edition = $maison_edition;

        return $this;
    }

    /**
     * @return Collection|Exemplaire[]
     */
    public function getExemplaire(): Collection
    {
        return $this->exemplaire;
    }

    public function addExemplaire(Exemplaire $exemplaire): self
    {
        if (!$this->exemplaire->contains($exemplaire)) {
            $this->exemplaire[] = $exemplaire;
            $exemplaire->setEditeur($this);
        }

        return $this;
    }

    public function removeExemplaire(Exemplaire $exemplaire): self
    {
        if ($this->exemplaire->contains($exemplaire)) {
            $this->exemplaire->removeElement($exemplaire);
            // set the owning side to null (unless already changed)
            if ($exemplaire->getEditeur() === $this) {
                $exemplaire->setEditeur(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->maison_edition;
    }
}
