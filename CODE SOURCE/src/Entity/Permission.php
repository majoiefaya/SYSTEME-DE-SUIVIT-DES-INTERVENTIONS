<?php

namespace App\Entity;

use App\Repository\PermissionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PermissionRepository::class)]
class Permission
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $Raisons;

    #[ORM\Column(type: 'date')]
    private $DateDemande;

    #[ORM\Column(type: 'datetime')]
    private $Heure;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $Statut;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $Duree;

    #[ORM\Column(type: 'date', nullable: true)]
    private $DateDebut;

    #[ORM\Column(type: 'date', nullable: true)]
    private $DateFin;

    #[ORM\ManyToOne(targetEntity: Employe::class, inversedBy: 'permission')]
    private $employe;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRaisons(): ?string
    {
        return $this->Raisons;
    }

    public function setRaisons(string $Raisons): self
    {
        $this->Raisons = $Raisons;

        return $this;
    }

    public function getDateDemande(): ?\DateTimeInterface
    {
        return $this->DateDemande;
    }

    public function setDateDemande(\DateTimeInterface $DateDemande): self
    {
        $this->DateDemande = $DateDemande;

        return $this;
    }

    public function getHeure(): ?\DateTimeInterface
    {
        return $this->Heure;
    }

    public function setHeure(\DateTimeInterface $Heure): self
    {
        $this->Heure = $Heure;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->Statut;
    }

    public function setStatut(?string $Statut): self
    {
        $this->Statut = $Statut;

        return $this;
    }

    public function getDuree(): ?int
    {
        return $this->Duree;
    }

    public function setDuree(?int $Duree): self
    {
        $this->Duree = $Duree;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->DateDebut;
    }

    public function setDateDebut(?\DateTimeInterface $DateDebut): self
    {
        $this->DateDebut = $DateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->DateFin;
    }

    public function setDateFin(?\DateTimeInterface $DateFin): self
    {
        $this->DateFin = $DateFin;

        return $this;
    }

    public function getEmploye(): ?Employe
    {
        return $this->employe;
    }

    public function setEmploye(?Employe $employe): self
    {
        $this->employe = $employe;

        return $this;
    }
}
