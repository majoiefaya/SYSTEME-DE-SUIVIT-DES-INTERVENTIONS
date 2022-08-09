<?php

namespace App\Entity;

use App\Repository\TypeEquipementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypeEquipementRepository::class)]
class TypeEquipement extends ActionInfos
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    protected $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $Libelle;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $Description;

    #[ORM\OneToMany(mappedBy: 'typeEquipement', targetEntity: Equipement::class)]
    private $equipement;

    #[ORM\Column(type: 'integer')]
    private $QuantiteTypeEquipement;

    public function __construct()
    {
        $this->equipement = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(?string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }

    /**
     * @return Collection<int, Equipement>
     */
    public function getEquipement(): Collection
    {
        return $this->equipement;
    }

    public function addEquipement(Equipement $equipement): self
    {
        if (!$this->equipement->contains($equipement)) {
            $this->equipement[] = $equipement;
            $equipement->setTypeEquipement($this);
        }

        return $this;
    }

    public function removeEquipement(Equipement $equipement): self
    {
        if ($this->equipement->removeElement($equipement)) {
            // set the owning side to null (unless already changed)
            if ($equipement->getTypeEquipement() === $this) {
                $equipement->setTypeEquipement(null);
            }
        }

        return $this;
    }

    public function __toString() 
    {
        return (string) $this->Libelle; 
    }

    public function getQuantiteTypeEquipement(): ?int
    {
        return $this->QuantiteTypeEquipement;
    }

    public function setQuantiteTypeEquipement(int $QuantiteTypeEquipement): self
    {
        $this->QuantiteTypeEquipement = $QuantiteTypeEquipement;

        return $this;
    }
}
