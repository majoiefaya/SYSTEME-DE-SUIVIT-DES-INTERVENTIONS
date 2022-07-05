<?php

namespace App\Entity;

use App\Repository\TechnicienRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TechnicienRepository::class)]
class Technicien extends Employe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    protected $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $Type;

    #[ORM\ManyToOne(targetEntity: Equipe::class, inversedBy: 'technicien')]
    private $equipe;

    #[ORM\OneToOne(inversedBy: 'technicienChef', targetEntity: Equipe::class, cascade: ['persist', 'remove'])]
    private $chef;

    #[ORM\OneToMany(mappedBy: 'technicien', targetEntity: InterventionAss::class)]
    private $interventionAss;

    public function __construct()
    {
        parent::__construct();
        $this->interventionAss = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->Type;
    }

    public function setType(string $Type): self
    {
        $this->Type = $Type;

        return $this;
    }

    public function getEquipe(): ?Equipe
    {
        return $this->equipe;
    }

    public function setEquipe(?Equipe $equipe): self
    {
        $this->equipe = $equipe;

        return $this;
    }

    public function getChef(): ?Equipe
    {
        return $this->chef;
    }

    public function setChef(?Equipe $chef): self
    {
        $this->chef = $chef;

        return $this;
    }

    /**
     * @return Collection<int, InterventionAss>
     */
    public function getInterventionAss(): Collection
    {
        return $this->interventionAss;
    }

    public function addInterventionAss(InterventionAss $interventionAss): self
    {
        if (!$this->interventionAss->contains($interventionAss)) {
            $this->interventionAss[] = $interventionAss;
            $interventionAss->setTechnicien($this);
        }

        return $this;
    }

    public function removeInterventionAss(InterventionAss $interventionAss): self
    {
        if ($this->interventionAss->removeElement($interventionAss)) {
            // set the owning side to null (unless already changed)
            if ($interventionAss->getTechnicien() === $this) {
                $interventionAss->setTechnicien(null);
            }
        }

        return $this;
    }
}
