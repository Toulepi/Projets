<?php

namespace App\Entity;

use App\Repository\RedigerRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RedigerRepository::class)
 */
class Rediger
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Auteur::class, inversedBy="redacteur")
     */
    private $auteur;

    /**
     * @ORM\ManyToOne(targetEntity=Livre::class, inversedBy="redigers")
     */
    private $livre;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAuteur(): ?Auteur
    {
        return $this->auteur;
    }

    public function setAuteur(?Auteur $auteur): self
    {
        $this->auteur = $auteur;

        return $this;
    }

    public function getRediger(): ?Livre
    {
        return $this->livre;
    }

    public function setRediger(?Livre $livre): self
    {
        $this->livre = $livre;

        return $this;
    }

    public function getLivre(): ?Livre
    {
        return $this->livre;
    }

}
