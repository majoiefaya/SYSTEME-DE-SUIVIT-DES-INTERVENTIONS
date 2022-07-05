<?php

namespace App\Entity;

use App\Repository\AssistantAutoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AssistantAutoRepository::class)]
class AssistantAuto
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $NomAss;

    #[ORM\Column(type: 'date')]
    private $DateCreation;

    #[ORM\ManyToOne(targetEntity: Admin::class, inversedBy: 'assistantAuto')]
    private $admin;

    #[ORM\OneToMany(mappedBy: 'assistantAuto', targetEntity: Fonction::class)]
    private $fonction;

    public function __construct()
    {
        $this->fonction = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomAss(): ?string
    {
        return $this->NomAss;
    }

    public function setNomAss(string $NomAss): self
    {
        $this->NomAss = $NomAss;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->DateCreation;
    }

    public function setDateCreation(\DateTimeInterface $DateCreation): self
    {
        $this->DateCreation = $DateCreation;

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
     * @return Collection<int, Fonction>
     */
    public function getFonction(): Collection
    {
        return $this->fonction;
    }

    public function addFonction(Fonction $fonction): self
    {
        if (!$this->fonction->contains($fonction)) {
            $this->fonction[] = $fonction;
            $fonction->setAssistantAuto($this);
        }

        return $this;
    }

    public function removeFonction(Fonction $fonction): self
    {
        if ($this->fonction->removeElement($fonction)) {
            // set the owning side to null (unless already changed)
            if ($fonction->getAssistantAuto() === $this) {
                $fonction->setAssistantAuto(null);
            }
        }

        return $this;
    }
}
