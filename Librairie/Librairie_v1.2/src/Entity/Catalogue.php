<?php

namespace App\Entity;

use App\Repository\CatalogueRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CatalogueRepository::class)
 */
class Catalogue
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
    private $mot_cle;

    /**
     * @ORM\OneToMany(targetEntity=Livre::class, mappedBy="catalogue", orphanRemoval=true)
     */
    private $livres;

    /**
     * @ORM\OneToMany(targetEntity=Rubrique::class, mappedBy="catalogue", orphanRemoval=true)
     */
    private $rubriques;

    public function __construct()
    {
        $this->livres = new ArrayCollection();
        $this->rubriques = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMotCle(): ?string
    {
        return $this->mot_cle;
    }

    public function setMotCle(string $mot_cle): self
    {
        $this->mot_cle = $mot_cle;

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
            $livre->setCatalogue($this);
        }

        return $this;
    }

    public function removeLivre(Livre $livre): self
    {
        if ($this->livres->contains($livre)) {
            $this->livres->removeElement($livre);
            // set the owning side to null (unless already changed)
            if ($livre->getCatalogue() === $this) {
                $livre->setCatalogue(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Rubrique[]
     */
    public function getRubriques(): Collection
    {
        return $this->rubriques;
    }

    public function addRubrique(Rubrique $rubrique): self
    {
        if (!$this->rubriques->contains($rubrique)) {
            $this->rubriques[] = $rubrique;
            $rubrique->setCatalogue($this);
        }

        return $this;
    }

    public function removeRubrique(Rubrique $rubrique): self
    {
        if ($this->rubriques->contains($rubrique)) {
            $this->rubriques->removeElement($rubrique);
            // set the owning side to null (unless already changed)
            if ($rubrique->getCatalogue() === $this) {
                $rubrique->setCatalogue(null);
            }
        }

        return $this;
    }
}
