<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $hauteur = null;

    #[ORM\Column]
    private ?int $largeur = null;

    #[ORM\Column]
    private ?int $longueur = null;

    #[ORM\Column]
    private ?int $poids = null;

    #[ORM\OneToMany(mappedBy: 'laCommande', targetEntity: Status::class)]
    private Collection $lesStatus;

    #[ORM\ManyToOne(inversedBy: 'lesCommandes')]
    private ?User $leUser = null;

    #[ORM\ManyToOne(inversedBy: 'lesExpeditionsCommandes')]
    private ?Adresse $adresseExpedition = null;

    #[ORM\ManyToOne(inversedBy: 'lesDestinationsCommandes')]
    private ?Adresse $adresseDestination = null;

    #[ORM\ManyToOne(inversedBy: 'lesFacturationsCommandes')]
    private ?Adresse $adresseFacturation = null;

    #[ORM\OneToOne(inversedBy: 'laCommande', cascade: ['persist', 'remove'])]
    private ?Casier $leCasier = null;

    public function __construct()
    {
        $this->lesStatus = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHauteur(): ?int
    {
        return $this->hauteur;
    }

    public function setHauteur(int $hauteur): static
    {
        $this->hauteur = $hauteur;

        return $this;
    }

    public function getLargeur(): ?int
    {
        return $this->largeur;
    }

    public function setLargeur(int $largeur): static
    {
        $this->largeur = $largeur;

        return $this;
    }

    public function getLongueur(): ?int
    {
        return $this->longueur;
    }

    public function setLongueur(int $longueur): static
    {
        $this->longueur = $longueur;

        return $this;
    }

    public function getPoids(): ?int
    {
        return $this->poids;
    }

    public function setPoids(int $poids): static
    {
        $this->poids = $poids;

        return $this;
    }

    /**
     * @return Collection<int, Status>
     */
    public function getLesStatus(): Collection
    {
        return $this->lesStatus;
    }

    public function addLesStatus(Status $lesStatus): static
    {
        if (!$this->lesStatus->contains($lesStatus)) {
            $this->lesStatus->add($lesStatus);
            $lesStatus->setLaCommande($this);
        }

        return $this;
    }

    public function removeLesStatus(Status $lesStatus): static
    {
        if ($this->lesStatus->removeElement($lesStatus)) {
            // set the owning side to null (unless already changed)
            if ($lesStatus->getLaCommande() === $this) {
                $lesStatus->setLaCommande(null);
            }
        }

        return $this;
    }

    public function getLeUser(): ?User
    {
        return $this->leUser;
    }

    public function setLeUser(?User $leUser): static
    {
        $this->leUser = $leUser;

        return $this;
    }

    public function getAdresseExpedition(): ?Adresse
    {
        return $this->adresseExpedition;
    }

    public function setAdresseExpedition(?Adresse $adresseExpedition): static
    {
        $this->adresseExpedition = $adresseExpedition;

        return $this;
    }

    public function getAdresseDestination(): ?Adresse
    {
        return $this->adresseDestination;
    }

    public function setAdresseDestination(?Adresse $adresseDestination): static
    {
        $this->adresseDestination = $adresseDestination;

        return $this;
    }

    public function getAdresseFacturation(): ?Adresse
    {
        return $this->adresseFacturation;
    }

    public function setAdresseFacturation(?Adresse $adresseFacturation): static
    {
        $this->adresseFacturation = $adresseFacturation;

        return $this;
    }

    public function getLeCasier(): ?Casier
    {
        return $this->leCasier;
    }

    public function setLeCasier(?Casier $leCasier): static
    {
        $this->leCasier = $leCasier;

        return $this;
    }
}
