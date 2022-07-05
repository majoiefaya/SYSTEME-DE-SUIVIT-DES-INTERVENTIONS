<?php

namespace App\Entity;

use App\Repository\InterventionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InterventionRepository::class)]
class Intervention
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'date', nullable: true)]
    private $DateIntervention;

    #[ORM\Column(type: 'date')]
    private $DatePrevue;

    #[ORM\Column(type: 'string', length: 255)]
    private $Latitude;

    #[ORM\Column(type: 'string', length: 255)]
    private $Longitude;

    #[ORM\Column(type: 'string', length: 255)]
    private $Titre;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $Description;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $DureeIntervention;

    #[ORM\ManyToOne(targetEntity: Client::class, inversedBy: 'intervention')]
    private $client;

    #[ORM\ManyToOne(targetEntity: Admin::class, inversedBy: 'intervention')]
    private $admin;

    #[ORM\ManyToMany(targetEntity: Equipe::class, mappedBy: 'intervention')]
    private $equipes;

    #[ORM\OneToMany(mappedBy: 'intervention', targetEntity: InterventionAss::class)]
    private $interventionAss;

    #[ORM\ManyToMany(targetEntity: Equipement::class, inversedBy: 'interventions')]
    private $equipement;

    #[ORM\ManyToOne(targetEntity: Zone::class, inversedBy: 'intervention')]
    private $zone;

    public function __construct()
    {
        $this->equipes = new ArrayCollection();
        $this->interventionAss = new ArrayCollection();
        $this->equipement = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateIntervention(): ?\DateTimeInterface
    {
        return $this->DateIntervention;
    }

    public function setDateIntervention(?\DateTimeInterface $DateIntervention): self
    {
        $this->DateIntervention = $DateIntervention;

        return $this;
    }

    public function getDatePrevue(): ?\DateTimeInterface
    {
        return $this->DatePrevue;
    }

    public function setDatePrevue(\DateTimeInterface $DatePrevue): self
    {
        $this->DatePrevue = $DatePrevue;

        return $this;
    }

    public function getLatitude(): ?string
    {
        return $this->Latitude;
    }

    public function setLatitude(string $Latitude): self
    {
        $this->Latitude = $Latitude;

        return $this;
    }

    public function getLongitude(): ?string
    {
        return $this->Longitude;
    }

    public function setLongitude(string $Longitude): self
    {
        $this->Longitude = $Longitude;

        return $this;
    }

    public function getTitre(): ?string
    {
        return $this->Titre;
    }

    public function setTitre(string $Titre): self
    {
        $this->Titre = $Titre;

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

    public function getDureeIntervention(): ?string
    {
        return $this->DureeIntervention;
    }

    public function setDureeIntervention(?string $DureeIntervention): self
    {
        $this->DureeIntervention = $DureeIntervention;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

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
            $equipe->addIntervention($this);
        }

        return $this;
    }

    public function removeEquipe(Equipe $equipe): self
    {
        if ($this->equipes->removeElement($equipe)) {
            $equipe->removeIntervention($this);
        }

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
            $interventionAss->setIntervention($this);
        }

        return $this;
    }

    public function removeInterventionAss(InterventionAss $interventionAss): self
    {
        if ($this->interventionAss->removeElement($interventionAss)) {
            // set the owning side to null (unless already changed)
            if ($interventionAss->getIntervention() === $this) {
                $interventionAss->setIntervention(null);
            }
        }

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
        }

        return $this;
    }

    public function removeEquipement(Equipement $equipement): self
    {
        $this->equipement->removeElement($equipement);

        return $this;
    }

    public function getZone(): ?Zone
    {
        return $this->zone;
    }

    public function setZone(?Zone $zone): self
    {
        $this->zone = $zone;

        return $this;
    }
}
