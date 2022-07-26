<?php

namespace App\Entity;

use App\Repository\TacheRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TacheRepository::class)]
class Tache extends ActionInfos
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    protected $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $TitreTache;

    #[ORM\Column(type: 'string', length: 255)]
    private $Contenu;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $Fichier;

    #[ORM\OneToOne(inversedBy: 'tache', targetEntity: Employe::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private $DestinataireTache;

    #[ORM\Column(type: 'string', length: 255)]
    private $Statut;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitreTache(): ?string
    {
        return $this->TitreTache;
    }

    public function setTitreTache(?string $TitreTache): self
    {
        $this->TitreTache = $TitreTache;

        return $this;
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

    public function getFichier(): ?string
    {
        return $this->Fichier;
    }

    public function setFichier(?string $Fichier): self
    {
        $this->Fichier = $Fichier;

        return $this;
    }

    public function getDestinataireTache(): ?Employe
    {
        return $this->DestinataireTache;
    }

    public function setDestinataireTache(Employe $DestinataireTache): self
    {
        $this->DestinataireTache = $DestinataireTache;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->Statut;
    }

    public function setStatut(string $Statut): self
    {
        $this->Statut = $Statut;

        return $this;
    }
}
