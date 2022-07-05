<?php

namespace App\Entity;

use App\Repository\InterventionAssRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InterventionAssRepository::class)]
class InterventionAss
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $Raisons;

    #[ORM\ManyToOne(targetEntity: Technicien::class, inversedBy: 'interventionAss')]
    private $technicien;

    #[ORM\ManyToOne(targetEntity: Intervention::class, inversedBy: 'interventionAss')]
    private $intervention;

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

    public function getTechnicien(): ?Technicien
    {
        return $this->technicien;
    }

    public function setTechnicien(?Technicien $technicien): self
    {
        $this->technicien = $technicien;

        return $this;
    }

    public function getIntervention(): ?Intervention
    {
        return $this->intervention;
    }

    public function setIntervention(?Intervention $intervention): self
    {
        $this->intervention = $intervention;

        return $this;
    }
}
