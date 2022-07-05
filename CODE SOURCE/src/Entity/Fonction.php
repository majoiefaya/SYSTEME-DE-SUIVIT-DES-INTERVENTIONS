<?php

namespace App\Entity;

use App\Repository\FonctionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FonctionRepository::class)]
class Fonction
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $NomFonction;

    #[ORM\Column(type: 'string', length: 255)]
    private $Contenu;

    #[ORM\Column(type: 'string', length: 255)]
    private $Description;

    #[ORM\ManyToOne(targetEntity: AssistantAuto::class, inversedBy: 'fonction')]
    private $assistantAuto;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomFonction(): ?string
    {
        return $this->NomFonction;
    }

    public function setNomFonction(string $NomFonction): self
    {
        $this->NomFonction = $NomFonction;

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

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }

    public function getAssistantAuto(): ?AssistantAuto
    {
        return $this->assistantAuto;
    }

    public function setAssistantAuto(?AssistantAuto $assistantAuto): self
    {
        $this->assistantAuto = $assistantAuto;

        return $this;
    }
}
