<?php

namespace App\Entity;

use App\Repository\EmployeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EmployeRepository::class)]
class Employe extends Utilisateur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    protected $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $Fonction;

    #[ORM\Column(type: 'string', length: 255)]
    private $Statut;

    #[ORM\OneToMany(mappedBy: 'employe', targetEntity: Permission::class)]
    private $permission;

    public function __construct()
    {
        parent::__construct();
        $this->permission = new ArrayCollection();
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
     * @return Collection<int, Permission>
     */
    public function getPermission(): Collection
    {
        return $this->permission;
    }

    public function addPermission(Permission $permission): self
    {
        if (!$this->permission->contains($permission)) {
            $this->permission[] = $permission;
            $permission->setEmploye($this);
        }

        return $this;
    }

    public function removePermission(Permission $permission): self
    {
        if ($this->permission->removeElement($permission)) {
            // set the owning side to null (unless already changed)
            if ($permission->getEmploye() === $this) {
                $permission->setEmploye(null);
            }
        }

        return $this;
    }
}
