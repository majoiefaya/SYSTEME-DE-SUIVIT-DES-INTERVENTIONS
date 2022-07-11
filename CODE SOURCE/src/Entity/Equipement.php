<?php

namespace App\Entity;

use App\Repository\EquipementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EquipementRepository::class)]
class Equipement extends ActionInfos
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    protected $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $Libelle;

    #[ORM\Column(type: 'string', length: 255)]
    private $Disponibilite;

    #[ORM\Column(type: 'integer')]
    private $NombreUtilisation;

    #[ORM\ManyToMany(targetEntity: Intervention::class, mappedBy: 'equipement')]
    private $interventions;

    #[ORM\ManyToOne(targetEntity: TypeEquipement::class, inversedBy: 'equipement')]
    private $typeEquipement;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $Image;

    public function __construct()
    {
        $this->interventions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->Libelle;
    }

    public function setLibelle(string $Libelle): self
    {
        $this->Libelle = $Libelle;

        return $this;
    }

    public function getDisponibilite(): ?string
    {
        return $this->Disponibilite;
    }

    public function setDisponibilite(string $Disponibilite): self
    {
        $this->Disponibilite = $Disponibilite;

        return $this;
    }

    public function getNombreUtilisation(): ?int
    {
        return $this->NombreUtilisation;
    }

    public function setNombreUtilisation(int $NombreUtilisation): self
    {
        $this->NombreUtilisation = $NombreUtilisation;

        return $this;
    }

    /**
     * @return Collection<int, Intervention>
     */
    public function getInterventions(): Collection
    {
        return $this->interventions;
    }

    public function addIntervention(Intervention $intervention): self
    {
        if (!$this->interventions->contains($intervention)) {
            $this->interventions[] = $intervention;
            $intervention->addEquipement($this);
        }

        return $this;
    }

    public function removeIntervention(Intervention $intervention): self
    {
        if ($this->interventions->removeElement($intervention)) {
            $intervention->removeEquipement($this);
        }

        return $this;
    }

    public function getTypeEquipement(): ?TypeEquipement
    {
        return $this->typeEquipement;
    }

    public function setTypeEquipement(?TypeEquipement $typeEquipement): self
    {
        $this->typeEquipement = $typeEquipement;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->Image;
    }

    public function setImage(?string $Image): self
    {
        $this->Image = $Image;

        return $this;
    }
}
