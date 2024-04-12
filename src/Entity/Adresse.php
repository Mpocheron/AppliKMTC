<?php

namespace App\Entity;

use App\Repository\AdresseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AdresseRepository::class)]
class Adresse
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $numero = null;

    #[ORM\Column(length: 45)]
    private ?string $nom = null;

    #[ORM\Column(length: 5)]
    private ?string $codePostal = null;

    #[ORM\Column(length: 45)]
    private ?string $ville = null;

    #[ORM\Column(length: 45, nullable: true)]
    private ?string $longitude = null;

    #[ORM\Column(length: 45, nullable: true)]
    private ?string $latitude = null;

    #[ORM\OneToMany(mappedBy: 'leAdresse', targetEntity: AdresseUser::class, orphanRemoval: true)]
    private Collection $lesAdresseUsers;

    #[ORM\OneToOne(mappedBy: 'leAdresse', cascade: ['persist', 'remove'])]
    private ?Relais $leRelais = null;

    #[ORM\OneToMany(mappedBy: 'adresseExpedition', targetEntity: Commande::class)]
    private Collection $lesExpeditionsCommandes;

    #[ORM\OneToMany(mappedBy: 'adresseDestination', targetEntity: Commande::class)]
    private Collection $lesDestinationsCommandes;

    #[ORM\OneToMany(mappedBy: 'adresseFacturation', targetEntity: Commande::class)]
    private Collection $lesFacturationsCommandes;

    public function __construct(string $adresseString)
    {
        // Suppression des caractères spéciaux
        $unwanted_array = array('Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
                            'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
                            'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
                            'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
                            'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y');

        $adresseString = strtr($adresseString, $unwanted_array );

        // Conversion de toutes les lettres en majuscule pour uniformiser les adresses
        $adresseString = strtoupper($adresseString);

        // découpage de la string
        $adresseInfos = explode(',', $adresseString);

        // Suppression des espaces en trop
        $adresseInfos = array_map('trim', $adresseInfos);

        // Stockage des infos dans l'objet
        $this->numero = $adresseInfos[0];
        $this->nom = $adresseInfos[1];
        $this->codePostal = $adresseInfos[2];
        $this->ville = $adresseInfos[3];
        
        $this->lesAdresseUsers = new ArrayCollection();
        $this->lesExpeditionsCommandes = new ArrayCollection();
        $this->lesDestinationsCommandes = new ArrayCollection();
        $this->lesFacturationsCommandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumero(): ?int
    {
        return $this->numero;
    }

    public function setNumero(int $numero): static
    {
        $this->numero = $numero;

        return $this;
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

    public function getCodePostal(): ?string
    {
        return $this->codePostal;
    }

    public function setCodePostal(string $codePostal): static
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): static
    {
        $this->ville = $ville;

        return $this;
    }

    public function getLongitude(): ?string
    {
        return $this->longitude;
    }

    public function setLongitude(?string $longitude): static
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getLatitude(): ?string
    {
        return $this->latitude;
    }

    public function setLatitude(?string $latitude): static
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * @return Collection<int, AdresseUser>
     */
    public function getLesAdresseUsers(): Collection
    {
        return $this->lesAdresseUsers;
    }

    public function addLesAdresseUser(AdresseUser $lesAdresseUser): static
    {
        if (!$this->lesAdresseUsers->contains($lesAdresseUser)) {
            $this->lesAdresseUsers->add($lesAdresseUser);
            $lesAdresseUser->setLeAdresse($this);
        }

        return $this;
    }

    public function removeLesAdresseUser(AdresseUser $lesAdresseUser): static
    {
        if ($this->lesAdresseUsers->removeElement($lesAdresseUser)) {
            // set the owning side to null (unless already changed)
            if ($lesAdresseUser->getLeAdresse() === $this) {
                $lesAdresseUser->setLeAdresse(null);
            }
        }

        return $this;
    }

    public function getLeRelais(): ?Relais
    {
        return $this->leRelais;
    }

    public function setLeRelais(?Relais $leRelais): static
    {
        // unset the owning side of the relation if necessary
        if ($leRelais === null && $this->leRelais !== null) {
            $this->leRelais->setLeAdresse(null);
        }

        // set the owning side of the relation if necessary
        if ($leRelais !== null && $leRelais->getLeAdresse() !== $this) {
            $leRelais->setLeAdresse($this);
        }

        $this->leRelais = $leRelais;

        return $this;
    }

    /**
     * @return Collection<int, Commande>
     */
    public function getLesExpeditionsCommandes(): Collection
    {
        return $this->lesExpeditionsCommandes;
    }

    public function addLesExpeditionsCommande(Commande $lesExpeditionsCommande): static
    {
        if (!$this->lesExpeditionsCommandes->contains($lesExpeditionsCommande)) {
            $this->lesExpeditionsCommandes->add($lesExpeditionsCommande);
            $lesExpeditionsCommande->setAdresseExpedition($this);
        }

        return $this;
    }

    public function removeLesExpeditionsCommande(Commande $lesExpeditionsCommande): static
    {
        if ($this->lesExpeditionsCommandes->removeElement($lesExpeditionsCommande)) {
            // set the owning side to null (unless already changed)
            if ($lesExpeditionsCommande->getAdresseExpedition() === $this) {
                $lesExpeditionsCommande->setAdresseExpedition(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Commande>
     */
    public function getLesDestinationsCommandes(): Collection
    {
        return $this->lesDestinationsCommandes;
    }

    public function addLesDestinationsCommande(Commande $lesDestinationsCommande): static
    {
        if (!$this->lesDestinationsCommandes->contains($lesDestinationsCommande)) {
            $this->lesDestinationsCommandes->add($lesDestinationsCommande);
            $lesDestinationsCommande->setAdresseDestination($this);
        }

        return $this;
    }

    public function removeLesDestinationsCommande(Commande $lesDestinationsCommande): static
    {
        if ($this->lesDestinationsCommandes->removeElement($lesDestinationsCommande)) {
            // set the owning side to null (unless already changed)
            if ($lesDestinationsCommande->getAdresseDestination() === $this) {
                $lesDestinationsCommande->setAdresseDestination(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Commande>
     */
    public function getLesFacturationsCommandes(): Collection
    {
        return $this->lesFacturationsCommandes;
    }

    public function addLesFacturationsCommande(Commande $lesFacturationsCommande): static
    {
        if (!$this->lesFacturationsCommandes->contains($lesFacturationsCommande)) {
            $this->lesFacturationsCommandes->add($lesFacturationsCommande);
            $lesFacturationsCommande->setAdresseFacturation($this);
        }

        return $this;
    }

    public function removeLesFacturationsCommande(Commande $lesFacturationsCommande): static
    {
        if ($this->lesFacturationsCommandes->removeElement($lesFacturationsCommande)) {
            // set the owning side to null (unless already changed)
            if ($lesFacturationsCommande->getAdresseFacturation() === $this) {
                $lesFacturationsCommande->setAdresseFacturation(null);
            }
        }

        return $this;
    }
}
