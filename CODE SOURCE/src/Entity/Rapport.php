<?php

namespace App\Entity;

use App\Repository\RapportRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RapportRepository::class)]
class Rapport extends ActionInfos
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    protected $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $Contenu;

    #[ORM\Column(type: 'date', nullable: true)]
    private $DateEnvoi;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $fichier;

    #[ORM\ManyToOne(targetEntity: Employe::class, inversedBy: 'rapport')]
    #[ORM\JoinColumn(nullable: false)]
    private $employe;

    #[ORM\Column(type: 'string', length: 255)]
    private $SujetRapport;

    #[ORM\ManyToOne(targetEntity: Admin::class, inversedBy: 'rapport')]
    private $admin;

    #[ORM\Column(type: 'string', length: 255)]
    private $StatutRapport;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContenu(): ?string
    {
        return $this->Contenu;
    }

    public function setContenu(string $Contenu): self
    {
        $this->Contenu = $Contenu;

        return $this;
    }

    public function getDateEnvoi(): ?\DateTimeInterface
    {
        return $this->DateEnvoi;
    }

    public function setDateEnvoi(\DateTimeInterface $DateEnvoi): self
    {
        $this->DateEnvoi = $DateEnvoi;

        return $this;
    }

    public function getFichier(): ?string
    {
        return $this->fichier;
    }

    public function setFichier(?string $fichier): self
    {
        $this->fichier = $fichier;

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

    public function getSujetRapport(): ?string
    {
        return $this->SujetRapport;
    }

    public function setSujetRapport(string $SujetRapport): self
    {
        $this->SujetRapport = $SujetRapport;

        return $this;
    }

    public function getAdmin(): ?Admin
    {
        return $this->admin;
    }

    public function setAdmin(?Admin $admin): self
    {
        $this->admin = $admin;

        return $this;
    }

    public function getStatutRapport(): ?string
    {
        return $this->StatutRapport;
    }

    public function setStatutRapport(string $StatutRapport): self
    {
        $this->StatutRapport = $StatutRapport;

        return $this;
    }

}
