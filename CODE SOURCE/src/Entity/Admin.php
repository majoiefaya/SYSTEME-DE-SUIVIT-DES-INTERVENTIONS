<?php

namespace App\Entity;

use App\Repository\AdminRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AdminRepository::class)]
class Admin extends Utilisateur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    protected $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $Fonction;

    #[ORM\Column(type: 'string', length: 255)]
    private $Statut;

    #[ORM\OneToMany(mappedBy: 'admin', targetEntity: Intervention::class)]
    private $intervention;

    #[ORM\OneToMany(mappedBy: 'admin', targetEntity: Equipe::class)]
    private $equipe;

    #[ORM\OneToMany(mappedBy: 'admin', targetEntity: AssistantAuto::class)]
    private $assistantAuto;

    #[ORM\OneToMany(mappedBy: 'admin', targetEntity: Rapport::class)]
    private $rapport;

    public function __construct()
    {
        parent::__construct();
        $this->intervention = new ArrayCollection();
        $this->equipe = new ArrayCollection();
        $this->assistantAuto = new ArrayCollection();
        $this->rapport = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFonction(): ?string
    {
        return $this->Fonction;
    }

    public function setFonction(string $Fonction): self
    {
        $this->Fonction = $Fonction;

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
            $intervention->setAdmin($this);
        }

        return $this;
    }

    public function removeIntervention(Intervention $intervention): self
    {
        if ($this->intervention->removeElement($intervention)) {
            // set the owning side to null (unless already changed)
            if ($intervention->getAdmin() === $this) {
                $intervention->setAdmin(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Equipe>
     */
    public function getEquipe(): Collection
    {
        return $this->equipe;
    }

    public function addEquipe(Equipe $equipe): self
    {
        if (!$this->equipe->contains($equipe)) {
            $this->equipe[] = $equipe;
            $equipe->setAdmin($this);
        }

        return $this;
    }

    public function removeEquipe(Equipe $equipe): self
    {
        if ($this->equipe->removeElement($equipe)) {
            // set the owning side to null (unless already changed)
            if ($equipe->getAdmin() === $this) {
                $equipe->setAdmin(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, AssistantAuto>
     */
    public function getAssistantAuto(): Collection
    {
        return $this->assistantAuto;
    }

    public function addAssistantAuto(AssistantAuto $assistantAuto): self
    {
        if (!$this->assistantAuto->contains($assistantAuto)) {
            $this->assistantAuto[] = $assistantAuto;
            $assistantAuto->setAdmin($this);
        }

        return $this;
    }

    public function removeAssistantAuto(AssistantAuto $assistantAuto): self
    {
        if ($this->assistantAuto->removeElement($assistantAuto)) {
            // set the owning side to null (unless already changed)
            if ($assistantAuto->getAdmin() === $this) {
                $assistantAuto->setAdmin(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Rapport>
     */
    public function getRapport(): Collection
    {
        return $this->rapport;
    }

    public function addRapport(Rapport $rapport): self
    {
        if (!$this->rapport->contains($rapport)) {
            $this->rapport[] = $rapport;
            $rapport->setAdmin($this);
        }

        return $this;
    }

    public function removeRapport(Rapport $rapport): self
    {
        if ($this->rapport->removeElement($rapport)) {
            // set the owning side to null (unless already changed)
            if ($rapport->getAdmin() === $this) {
                $rapport->setAdmin(null);
            }
        }

        return $this;
    }

}
