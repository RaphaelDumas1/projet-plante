<?php

namespace App\Entity;

use App\Repository\PlanteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlanteRepository::class)]
class Plante
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 75)]
    private ?string $nom = null;

    #[ORM\Column]
    private ?int $niveau = null;

    #[ORM\Column]
    private ?bool $Active = null;

    #[ORM\OneToMany(mappedBy: 'plante', targetEntity: TexteBefore::class)]
    private Collection $texteBefores;

    public function __construct()
    {
        $this->texteBefores = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getNiveau(): ?int
    {
        return $this->niveau;
    }

    public function setNiveau(int $niveau): self
    {
        $this->niveau = $niveau;

        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->Active;
    }

    public function setActive(bool $Active): self
    {
        $this->Active = $Active;

        return $this;
    }


    /**
     * @return Collection<int, TexteBefore>
     */
    public function getTexteBefores(): Collection
    {
        return $this->texteBefores;
    }

    public function addTexteBefore(TexteBefore $texteBefore): self
    {
        if (!$this->texteBefores->contains($texteBefore)) {
            $this->texteBefores->add($texteBefore);
            $texteBefore->setPlante($this);
        }

        return $this;
    }

    public function removeTexteBefore(TexteBefore $texteBefore): self
    {
        if ($this->texteBefores->removeElement($texteBefore)) {
            // set the owning side to null (unless already changed)
            if ($texteBefore->getPlante() === $this) {
                $texteBefore->setPlante(null);
            }
        }

        return $this;
    }
}
