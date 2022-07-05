<?php

namespace App\Entity;

use App\Repository\ZoneRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ZoneRepository::class)]
class Zone
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $Libelle;

    #[ORM\OneToMany(mappedBy: 'zone', targetEntity: Intervention::class)]
    private $intervention;

    #[ORM\ManyToMany(targetEntity: PointsGeo::class, inversedBy: 'zones')]
    private $pointsGeo;

    public function __construct()
    {
        $this->intervention = new ArrayCollection();
        $this->pointsGeo = new ArrayCollection();
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

    /**
     * @return Collection<int, Intervention>
     */
    public function getIntervention(): Collection
    {
        return $this->intervention;
    }

    public function addIntervention(Intervention $intervention): self
    {
        if (!$this->intervention->contains($intervention)) {
            $this->intervention[] = $intervention;
            $intervention->setZone($this);
        }

        return $this;
    }

    public function removeIntervention(Intervention $intervention): self
    {
        if ($this->intervention->removeElement($intervention)) {
            // set the owning side to null (unless already changed)
            if ($intervention->getZone() === $this) {
                $intervention->setZone(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PointsGeo>
     */
    public function getPointsGeo(): Collection
    {
        return $this->pointsGeo;
    }

    public function addPointsGeo(PointsGeo $pointsGeo): self
    {
        if (!$this->pointsGeo->contains($pointsGeo)) {
            $this->pointsGeo[] = $pointsGeo;
        }

        return $this;
    }

    public function removePointsGeo(PointsGeo $pointsGeo): self
    {
        $this->pointsGeo->removeElement($pointsGeo);

        return $this;
    }
}
