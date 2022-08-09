<?php

namespace App\Entity;

use App\Repository\EquipeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EquipeRepository::class)]
class Equipe extends ActionInfos
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    protected $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $NomEquipe;

    #[ORM\Column(type: 'string', length: 255)]
    private $Type;

    #[ORM\ManyToOne(targetEntity: Admin::class, inversedBy: 'equipe')]
    private $admin;

    #[ORM\OneToMany(mappedBy: 'equipe', targetEntity: Technicien::class)]
    private $technicien;

    #[ORM\ManyToMany(targetEntity: Intervention::class, inversedBy: 'equipes')]
    private $intervention;

    #[ORM\OneToOne(mappedBy: 'chef', targetEntity: Technicien::class, cascade: ['persist', 'remove'])]
    private $technicienChef;

    public function __construct()
    {
        $this->technicien = new ArrayCollection();
        $this->intervention = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomEquipe(): ?string
    {
        return $this->NomEquipe;
    }

    public function setNomEquipe(string $NomEquipe): self
    {
        $this->NomEquipe = $NomEquipe;

        return $this;
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

    public function getAdmin(): ?Admin
    {
        return $this->admin;
    }

    public function setAdmin(?Admin $admin): self
    {
        $this->admin = $admin;

        return $this;
    }

    /**
     * @return Collection<int, Technicien>
     */
    public function getTechnicien(): Collection
    {
        return $this->technicien;
    }

    public function addTechnicien(Technicien $technicien): self
    {
        if (!$this->technicien->contains($technicien)) {
            $this->technicien[] = $technicien;
            $technicien->setEquipe($this);
        }

        return $this;
    }

    public function removeTechnicien(Technicien $technicien): self
    {
        if ($this->technicien->removeElement($technicien)) {
            // set the owning side to null (unless already changed)
            if ($technicien->getEquipe() === $this) {
                $technicien->setEquipe(null);
            }
        }

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
        }

        return $this;
    }

    public function removeIntervention(Intervention $intervention): self
    {
        $this->intervention->removeElement($intervention);

        return $this;
    }

    public function getTechnicienChef(): ?Technicien
    {
        return $this->technicienChef;
    }

    public function setTechnicienChef(?Technicien $technicienChef): self
    {
        // unset the owning side of the relation if necessary
        if ($technicienChef === null && $this->technicienChef !== null) {
            $this->technicienChef->setChef(null);
        }

        // set the owning side of the relation if necessary
        if ($technicienChef !== null && $technicienChef->getChef() !== $this) {
            $technicienChef->setChef($this);
        }

        $this->technicienChef = $technicienChef;

        return $this;
    }

        
    public function __toString() 
    {
        return (string) $this->NomEquipe; 
    }
}
