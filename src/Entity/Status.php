<?php

// namespace App\Entity;

// use App\Repository\StatusRepository;
// use Doctrine\DBAL\Types\Types;
// use Doctrine\ORM\Mapping as ORM;

// #[ORM\Entity(repositoryClass: StatusRepository::class)]
// class Status
// {
//     #[ORM\Id]
//     #[ORM\GeneratedValue]
//     #[ORM\Column]
//     private ?int $id = null;

//     #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
//     private ?\DateTimeInterface $date = null;

//     #[ORM\ManyToOne]
//     private ?Etat $leEtat = null;

//     #[ORM\ManyToOne(inversedBy: 'lesStatus')]
//     private ?commande $laCommande = null;

//     public function getId(): ?int
//     {
//         return $this->id;
//     }

//     public function getDate(): ?\DateTimeInterface
//     {
//         return $this->date;
//     }

//     public function setDate(?\DateTimeInterface $date): static
//     {
//         $this->date = $date;

//         return $this;
//     }

//     public function getLeEtat(): ?Etat
//     {
//         return $this->leEtat;
//     }

//     public function setLeEtat(?Etat $leEtat): static
//     {
//         $this->leEtat = $leEtat;

//         return $this;
//     }

//     public function getLaCommande(): ?commande
//     {
//         return $this->laCommande;
//     }

//     public function setLaCommande(?commande $laCommande): static
//     {
//         $this->laCommande = $laCommande;

//         return $this;
//     }
// }
// namespace App\Entity;

// use App\Repository\StatusRepository;
// use Doctrine\Common\Collections\ArrayCollection;
// use Doctrine\Common\Collections\Collection;
// use Doctrine\DBAL\Types\Types;
// use Doctrine\ORM\Mapping as ORM;

// #[ORM\Entity(repositoryClass: StatusRepository::class)]
// class Status
// {
//     #[ORM\Id]
//     #[ORM\GeneratedValue]
//     #[ORM\Column]
//     private ?int $id = null;

//     #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
//     private ?\DateTimeInterface $date = null;

//     #[ORM\ManyToOne]
//     private ?Etat $leEtat = null;

//     /**
//      * @var Collection<int, Commande>
//      */
//     #[ORM\OneToMany(targetEntity: Commande::class, mappedBy: 'Status')]
//     private Collection $commandes;

//     public function __construct()
//     {
//         $this->commandes = new ArrayCollection();
//     }

//     public function getId(): ?int
//     {
//         return $this->id;
//     }

//     public function getDate(): ?\DateTimeInterface
//     {
//         return $this->date;
//     }

//     public function setDate(?\DateTimeInterface $date): static
//     {
//         $this->date = $date;

//         return $this;
//     }

//     public function getLeEtat(): ?Etat
//     {
//         return $this->leEtat;
//     }

//     public function setLeEtat(?Etat $leEtat): static
//     {
//         $this->leEtat = $leEtat;

//         return $this;
//     }

//     public function setLaCommande(?commande $laCommande): static
//     {
//         $this->laCommande = $laCommande;

//         return $this;
//     }

//     /**
//      * @return Collection<int, Commande>
//      */
//     public function getCommandes(): Collection
//     {
//         return $this->commandes;
//     }

//     public function addCommande(Commande $commande): static
//     {
//         if (!$this->commandes->contains($commande)) {
//             $this->commandes->add($commande);
//             $commande->setStatus($this);
//         }

//         return $this;
//     }

//     public function removeCommande(Commande $commande): static
//     {
//         if ($this->commandes->removeElement($commande)) {
//             // set the owning side to null (unless already changed)
//             if ($commande->getStatus() === $this) {
//                 $commande->setStatus(null);
//             }
//         }

//         return $this;
//     }
// }


namespace App\Entity;

use App\Repository\StatusRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StatusRepository::class)]
class Status
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date = null;

    #[ORM\ManyToOne]
    private ?Etat $leEtat = null;

    /**
     * @var Collection<int, Commande>
     */
    #[ORM\OneToMany(targetEntity: Commande::class, mappedBy: 'Status')]
    private Collection $commandes;

    public function __construct()
    {
        $this->commandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): static
    {
        $this->date = $date;
        return $this;
    }

    public function getLeEtat(): ?Etat
    {
        return $this->leEtat;
    }

    public function setLeEtat(?Etat $leEtat): static
    {
        $this->leEtat = $leEtat;
        return $this;
    }

    /**
     * @return Collection<int, Commande>
     */
    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function addCommande(Commande $commande): static
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes->add($commande);
            $commande->setStatus($this);
        }
        return $this;
    }

    public function removeCommande(Commande $commande): static
    {
        if ($this->commandes->removeElement($commande)) {
            if ($commande->getStatus() === $this) {
                $commande->setStatus(null);
            }
        }
        return $this;
    }
}
