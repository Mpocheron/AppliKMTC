<?php

namespace App\Entity;

use App\Repository\EtatRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EtatRepository::class)]
class Etat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 45)]
    private ?string $typeEtat = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeEtat(): ?string
    {
        return $this->typeEtat;
    }

    public function setTypeEtat(string $typeEtat): static
    {
        $this->typeEtat = $typeEtat;

        return $this;
    }
}
