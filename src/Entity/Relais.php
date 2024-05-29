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

    /**
     * @var Collection<int, Commande>
     */
    #[ORM\OneToMany(targetEntity: Commande::class, mappedBy: 'leRelais')]
    private Collection $lesCommandes;

    public function __construct()
    {
        $this->lesCasiers = new ArrayCollection();
        $this->lesCommandes = new ArrayCollection();
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
    public function denombrerCasier(): int
    {
        // Initialise le nombre de casiers à zéro
        $nombreCasiers = 0;
        
        // Initialise l'adresse du relais
        $adresse = '';
        
        // Parcours tous les casiers associés à ce relais
        foreach ($this->lesCasiers as $casier) {
                // Incrémente le nombre de casiers
                $nombreCasiers++;
        }

               
            // Retourne les informations sous forme de tableau associatif
            return $nombreCasiers;
        }

    /**
     * @return Collection<int, Commande>
     */
    public function getLesCommandes(): Collection
    {
        return $this->lesCommandes;
    }

    public function addLesCommande(Commande $lesCommande): static
    {
        if (!$this->lesCommandes->contains($lesCommande)) {
            $this->lesCommandes->add($lesCommande);
            $lesCommande->setLeRelais($this);
        }

        return $this;
    }

    public function removeLesCommande(Commande $lesCommande): static
    {
        if ($this->lesCommandes->removeElement($lesCommande)) {
            // set the owning side to null (unless already changed)
            if ($lesCommande->getLeRelais() === $this) {
                $lesCommande->setLeRelais(null);
            }
        }

        return $this;
    }
    

}