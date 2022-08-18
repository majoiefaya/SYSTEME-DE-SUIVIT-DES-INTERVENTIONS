<?php

namespace App\Entity;

use App\Repository\EtudiantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EtudiantRepository::class)]
class Etudiant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $Nom = null;

    #[ORM\Column(length: 200)]
    private ?string $Prenoms = null;

    #[ORM\Column(length: 10)]
    private ?string $Sexe = null;

    #[ORM\Column(length: 200)]
    private ?string $DateNaissance = null;

    #[ORM\Column(length: 100)]
    private ?string $LieuNaissance = null;

    #[ORM\Column(length: 150)]
    private ?string $Nationalite = null;

    #[ORM\Column(length: 100)]
    private ?string $PaysOrigine = null;

    #[ORM\Column]
    private ?int $AnneBac = null;

    #[ORM\Column(length: 10)]
    private ?string $SerieBac = null;

    #[ORM\Column]
    private ?int $NumeroTable = null;

    #[ORM\Column (nullable: \true)]
    private ?int $NumeroCni = null;

    #[ORM\Column (nullable: \true)]
    private ?int $NumeroPassport = null;
    
    #[ORM\Column]
    private ?int $NumeroTelephone = null;

    #[ORM\Column(length: 255)]
    private ?string $Email = null;

    #[ORM\Column(length: 255)]
    
    private ?string $Adresse = null;

   

    #[ORM\OneToMany(mappedBy: 'etudiant', targetEntity: Tuteur::class)]
    private Collection $tuteur;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Dossiers $dossier = null;



    public function __construct()
    {
        $this->dossiers = new ArrayCollection();
        $this->tuteur = new ArrayCollection();
        
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): self
    {
        $this->Nom = $Nom;

        return $this;
    }

    public function getPrenoms(): ?string
    {
        return $this->Prenoms;
    }

    public function setPrenoms(string $Prenoms): self
    {
        $this->Prenoms = $Prenoms;

        return $this;
    }

    public function getSexe(): ?string
    {
        return $this->Sexe;
    }

    public function setSexe(string $Sexe): self
    {
        $this->Sexe = $Sexe;

        return $this;
    }

    public function getDateNaissance(): ?string
    {
        return $this->DateNaissance;
    }

    public function setDateNaissance(string $DateNaissance): self
    {
        $this->DateNaissance = $DateNaissance;

        return $this;
    }

    public function getLieuNaissance(): ?string
    {
        return $this->LieuNaissance;
    }

    public function setLieuNaissance(string $LieuNaissance): self
    {
        $this->LieuNaissance = $LieuNaissance;

        return $this;
    }

    public function getNationalite(): ?string
    {
        return $this->Nationalite;
    }

    public function setNationalite(string $Nationalite): self
    {
        $this->Nationalite = $Nationalite;

        return $this;
    }

    public function getPaysOrigine(): ?string
    {
        return $this->PaysOrigine;
    }

    public function setPaysOrigine(string $PaysOrigine): self
    {
        $this->PaysOrigine = $PaysOrigine;

        return $this;
    }

    public function getAnneBac(): ?int
    {
        return $this->AnneBac;
    }

    public function setAnneBac(int $AnneBac): self
    {
        $this->AnneBac = $AnneBac;

        return $this;
    }

    public function getSerieBac(): ?string
    {
        return $this->SerieBac;
    }

    public function setSerieBac(string $SerieBac): self
    {
        $this->SerieBac = $SerieBac;

        return $this;
    }

    public function getNumeroTable(): ?int
    {
        return $this->NumeroTable;
    }

    public function setNumeroTable(int $NumeroTable): self
    {
        $this->NumeroTable = $NumeroTable;

        return $this;
    }

    public function getNumeroCni(): ?int
    {
        return $this->NumeroCni;
    }

    public function setNumeroCni(int $NumeroCni): self
    {
        $this->NumeroCni = $NumeroCni;

        return $this;
    }

    public function getNumeroPassport(): ?int
    {
        return $this->NumeroPassport;
    }

    public function setNumeroPassport(int $NumeroPassport): self
    {
        $this->NumeroPassport = $NumeroPassport;

        return $this;
    }

    public function getNumeroTelephone(): ?int
    {
        return $this->NumeroTelephone;
    }

    public function setNumeroTelephone(int $NumeroTelephone): self
    {
        $this->NumeroTelephone = $NumeroTelephone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->Email;
    }

    public function setEmail(string $Email): self
    {
        $this->Email = $Email;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->Adresse;
    }

    public function setAdresse(string $Adresse): self
    {
        $this->Adresse = $Adresse;

        return $this;
    }

    /**
     * @return Collection<int, Tuteur>
     */
    public function getTuteur(): Collection
    {
        return $this->tuteur;
    }

    public function addTuteur(Tuteur $tuteur): self
    {
        if (!$this->tuteur->contains($tuteur)) {
            $this->tuteur[] = $tuteur;
            $tuteur->setEtudiant($this);
        }

        return $this;
    }

    public function removeTuteur(Tuteur $tuteur): self
    {
        if ($this->tuteur->removeElement($tuteur)) {
            // set the owning side to null (unless already changed)
            if ($tuteur->getEtudiant() === $this) {
                $tuteur->setEtudiant(null);
            }
        }

        return $this;
    }

    public function getDossier(): ?Dossiers
    {
        return $this->dossier;
    }

    public function setDossier(?Dossiers $dossier): self
    {
        $this->dossier = $dossier;

        return $this;
    }

    public function __toString()
    {
        return $this->Nom." ".$this->Prenoms;
    }
}
