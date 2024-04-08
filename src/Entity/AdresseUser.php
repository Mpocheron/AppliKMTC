<?php

namespace App\Entity;

use App\Repository\AdresseUserRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AdresseUserRepository::class)]
class AdresseUser
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'lesAdresseUsers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $leuser = null;

    #[ORM\ManyToOne(inversedBy: 'lesAdresseUsers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Adresse $leAdresse = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLeuser(): ?User
    {
        return $this->leuser;
    }

    public function setLeuser(?User $leuser): static
    {
        $this->leuser = $leuser;

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
}
