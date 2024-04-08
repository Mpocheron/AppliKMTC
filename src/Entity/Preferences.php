<?php

namespace App\Entity;

use App\Repository\PreferencesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PreferencesRepository::class)]
class Preferences
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $sms = null;

    #[ORM\Column]
    private ?bool $mail = null;

    #[ORM\Column]
    private ?bool $push = null;

    #[ORM\OneToOne(inversedBy: 'lePreferences', cascade: ['persist', 'remove'])]
    private ?User $leUser = null;

    #[ORM\ManyToOne]
    private ?Relais $leRelais = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isSms(): ?bool
    {
        return $this->sms;
    }

    public function setSms(bool $sms): static
    {
        $this->sms = $sms;

        return $this;
    }

    public function isMail(): ?bool
    {
        return $this->mail;
    }

    public function setMail(bool $mail): static
    {
        $this->mail = $mail;

        return $this;
    }

    public function isPush(): ?bool
    {
        return $this->push;
    }

    public function setPush(bool $push): static
    {
        $this->push = $push;

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

    public function getLeRelais(): ?Relais
    {
        return $this->leRelais;
    }

    public function setLeRelais(?Relais $leRelais): static
    {
        $this->leRelais = $leRelais;

        return $this;
    }
}
