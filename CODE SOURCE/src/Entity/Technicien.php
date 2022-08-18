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

    #[ORM\OneToOne(inversedBy: 'technicienChef', targetEntity: Equipe::class, cascade: ['persist', 'remove'])]
    private $chef;

    #[ORM\OneToMany(mappedBy: 'technicien', targetEntity: InterventionAss::class)]
    private $interventionAss;

    #[ORM\ManyToMany(targetEntity: Equipe::class, mappedBy: 'technicien')]
    private $equipes;

    public function __construct()
    {
        parent::__construct();
        $this->interventionAss = new ArrayCollection();
        $this->equipes = new ArrayCollection();
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

    /**
     * @return Collection<int, Equipe>
     */
    public function getEquipes(): Collection
    {
        return $this->equipes;
    }

    public function addEquipe(Equipe $equipe): self
    {
        if (!$this->equipes->contains($equipe)) {
            $this->equipes[] = $equipe;
            $equipe->addTechnicien($this);
        }

        return $this;
    }

    public function removeEquipe(Equipe $equipe): self
    {
        if ($this->equipes->removeElement($equipe)) {
            $equipe->removeTechnicien($this);
        }

        return $this;
    }
}
