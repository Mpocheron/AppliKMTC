<?php

namespace App\Entity;

use App\Repository\CasierRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CasierRepository::class)]
class Casier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'lesCasiers')]
    private ?Modele $leModel = null;

    #[ORM\ManyToOne(inversedBy: 'lesCasiers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Relais $leRelais = null;

    #[ORM\OneToOne(mappedBy: 'leCasier', cascade: ['persist', 'remove'])]
    private ?Commande $laCommande = null;

    #[ORM\Column]
    private ?bool $utilise = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLeModel(): ?Modele
    {
        return $this->leModel;
    }

    public function setLeModel(?Modele $leModel): static
    {
        $this->leModel = $leModel;

        return $this;
    }

    public function getLeRelais(): ?Relais
    {
        return $this->leRelais;
    }

    public function setLeRelais(?Relais $leRelais): static
    {
        $this->leRelais = $leRelais;

        return $this;
    }

    public function getLaCommande(): ?Commande
    {
        return $this->laCommande;
    }

    public function setLaCommande(?Commande $laCommande): static
    {
        // unset the owning side of the relation if necessary
        if ($laCommande === null && $this->laCommande !== null) {
            $this->laCommande->setLeCasier(null);
        }

        // set the owning side of the relation if necessary
        if ($laCommande !== null && $laCommande->getLeCasier() !== $this) {
            $laCommande->setLeCasier($this);
        }

        $this->laCommande = $laCommande;

        return $this;
    }

    public function isUtilise(): ?bool
    {
        return $this->utilise;
    }

    public function setUtilise(bool $utilise): static
    {
        $this->utilise = $utilise;

        return $this;
    }
}
