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
     * @ORM\Column(type="string", length=150,unique=true)
     */
    private $mot_cle;

    /**
     * @ORM\OneToMany(targetEntity=Rubrique::class, mappedBy="catalogue", orphanRemoval=true)
     */
    private $rubrique;

    public function __construct()
    {
        $this->rubrique = new ArrayCollection();
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
     * @return Collection|Rubrique[]
     */
    public function getRubrique(): Collection
    {
        return $this->rubrique;
    }

    public function addRubrique(Rubrique $rubrique): self
    {
        if (!$this->rubrique->contains($rubrique)) {
            $this->rubrique[] = $rubrique;
            $rubrique->setCatalogue($this);
        }

        return $this;
    }

    public function removeRubrique(Rubrique $rubrique): self
    {
        if ($this->rubrique->contains($rubrique)) {
            $this->rubrique->removeElement($rubrique);
            // set the owning side to null (unless already changed)
            if ($rubrique->getCatalogue() === $this) {
                $rubrique->setCatalogue(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->mot_cle;
    }
}
