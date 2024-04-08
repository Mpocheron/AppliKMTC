<?php

namespace App\Entity;

use App\Repository\RelaisRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RelaisRepository::class)]
class Relais
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 45)]
    private ?string $nom = null;

    #[ORM\OneToOne(inversedBy: 'leRelais', cascade: ['persist', 'remove'])]
    private ?Adresse $leAdresse = null;

    #[ORM\OneToMany(mappedBy: 'leRelais', targetEntity: Casier::class, orphanRemoval: true)]
    private Collection $lesCasiers;

    public function __construct()
    {
        $this->lesCasiers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getLeAdresse(): ?Adresse
    {
        return $this->leAdresse;
    }

    public function setLeAdresse(?Adresse $leAdresse): static
    {
        $this->leAdresse = $leAdresse;

        return $this;
    }

    /**
     * @return Collection<int, Casier>
     */
    public function getLesCasiers(): Collection
    {
        return $this->lesCasiers;
    }

    public function addLesCasier(Casier $lesCasier): static
    {
        if (!$this->lesCasiers->contains($lesCasier)) {
            $this->lesCasiers->add($lesCasier);
            $lesCasier->setLeRelais($this);
        }

        return $this;
    }

    public function removeLesCasier(Casier $lesCasier): static
    {
        if ($this->lesCasiers->removeElement($lesCasier)) {
            // set the owning side to null (unless already changed)
            if ($lesCasier->getLeRelais() === $this) {
                $lesCasier->setLeRelais(null);
            }
        }

        return $this;
    }
}
