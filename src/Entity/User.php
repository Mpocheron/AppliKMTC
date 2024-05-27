<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\OneToMany(mappedBy: 'leuser', targetEntity: AdresseUser::class, orphanRemoval: true)]
    private Collection $lesAdresseUsers;

    #[ORM\OneToOne(mappedBy: 'leUser', cascade: ['persist', 'remove'])]
    private ?Preferences $lePreferences = null;

    #[ORM\OneToMany(mappedBy: 'leUser', targetEntity: Commande::class)]
    private Collection $lesCommandes;

    #[ORM\Column(length: 45)]
    private ?string $nom = null;

    #[ORM\Column(length: 45)]
    private ?string $prenom = null;

    #[ORM\Column(length: 10)]
    private ?string $telephone = null;

    #[ORM\OneToOne(targetEntity: Adresse::class, cascade: ['persist', 'remove'])]
    private ?Adresse $adresseUser = null;

    public function __construct()
    {
        $this->lesAdresseUsers = new ArrayCollection();
        $this->lesCommandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';
        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;
        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;
        return $this;
    }

    public function eraseCredentials(): void
    {
        // Effacer les données temporaires sensibles
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;
        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): static
    {
        $this->telephone = $telephone;
        return $this;
    }

    public function getLePreferences(): ?Preferences
    {
        return $this->lePreferences;
    }

    public function setLePreferences(?Preferences $lePreferences): static
    {
        if ($lePreferences === null && $this->lePreferences !== null) {
            $this->lePreferences->setLeUser(null);
        }

        if ($lePreferences !== null && $lePreferences->getLeUser() !== $this) {
            $lePreferences->setLeUser($this);
        }

        $this->lePreferences = $lePreferences;
        return $this;
    }

    public function getLesAdresseUsers(): Collection
    {
        return $this->lesAdresseUsers;
    }

    public function addLesAdresseUser(AdresseUser $lesAdresseUser): static
    {
        if (!$this->lesAdresseUsers->contains($lesAdresseUser)) {
            $this->lesAdresseUsers->add($lesAdresseUser);
            $lesAdresseUser->setLeuser($this);
        }

        return $this;
    }

    public function removeLesAdresseUser(AdresseUser $lesAdresseUser): static
    {
        if ($this->lesAdresseUsers->removeElement($lesAdresseUser)) {
            if ($lesAdresseUser->getLeuser() === $this) {
                $lesAdresseUser->setLeuser(null);
            }
        }

        return $this;
    }

    public function getLesCommandes(): Collection
    {
        return $this->lesCommandes;
    }

    public function addLesCommande(Commande $lesCommande): static
    {
        if (!$this->lesCommandes->contains($lesCommande)) {
            $this->lesCommandes->add($lesCommande);
            $lesCommande->setLeUser($this);
        }

        return $this;
    }

    public function removeLesCommande(Commande $lesCommande): static
    {
        if ($this->lesCommandes->removeElement($lesCommande)) {
            if ($lesCommande->getLeUser() === $this) {
                $lesCommande->setLeUser(null);
            }
        }

        return $this;
    }

    public function getAdresseUser(): ?Adresse
    {
        return $this->adresseUser;
    }

    public function setAdresseUser(?Adresse $adresseUser): static
    {
        $this->adresseUser = $adresseUser;
        return $this;
    }
}
