<?php

namespace App\Entity;

use App\Repository\ActionInfosRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\InheritanceType;

#[ORM\Entity(repositoryClass: ActionInfosRepository::class)]
#[InheritanceType("JOINED")]
class ActionInfos
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    protected $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $CreerPar;

    #[ORM\Column(type: 'date')]
    private $CreerLe;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $ModifierPar;

    #[ORM\Column(type: 'date', nullable: true)]
    private $ModifierLe;

    #[ORM\Column(type: 'boolean')]
    private $Enable;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $SupprimerPar;

    #[ORM\Column(type: 'date', nullable: true)]
    private $SupprimerLe;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreerPar(): ?string
    {
        return $this->CreerPar;
    }

    public function setCreerPar(string $CreerPar): self
    {
        $this->CreerPar = $CreerPar;

        return $this;
    }

    public function getCreerLe(): ?\DateTimeInterface
    {
        return $this->CreerLe;
    }

    public function setCreerLe(\DateTimeInterface $CreerLe): self
    {
        $this->CreerLe = $CreerLe;

        return $this;
    }

    public function getModifierPar(): ?string
    {
        return $this->ModifierPar;
    }

    public function setModifierPar(?string $ModifierPar): self
    {
        $this->ModifierPar = $ModifierPar;

        return $this;
    }

    public function getModifierLe(): ?\DateTimeInterface
    {
        return $this->ModifierLe;
    }

    public function setModifierLe(?\DateTimeInterface $ModifierLe): self
    {
        $this->ModifierLe = $ModifierLe;

        return $this;
    }

    public function isEnable(): ?bool
    {
        return $this->Enable;
    }

    public function setEnable(bool $Enable): self
    {
        $this->Enable = $Enable;

        return $this;
    }

    public function getSupprimerPar(): ?string
    {
        return $this->SupprimerPar;
    }

    public function setSupprimerPar(?string $SupprimerPar): self
    {
        $this->SupprimerPar = $SupprimerPar;

        return $this;
    }

    public function getSupprimerLe(): ?\DateTimeInterface
    {
        return $this->SupprimerLe;
    }

    public function setSupprimerLe(?\DateTimeInterface $SupprimerLe): self
    {
        $this->SupprimerLe = $SupprimerLe;

        return $this;
    }
}
