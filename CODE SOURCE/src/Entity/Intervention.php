<?php

namespace App\Entity;

use App\Repository\InterventionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InterventionRepository::class)]
class Intervention extends ActionInfos
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    protected $id;

    #[ORM\Column(type: 'date', nullable: true)]
    private $DateIntervention;

    #[ORM\Column(type: 'string', length: 255,nullable: true)]
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

    #[ORM\Column(type: 'float')]
    private $Latitude;

    #[ORM\Column(type: 'float')]
    private $Longitude;

    #[ORM\OneToMany(mappedBy: 'intervention', targetEntity: Rapport::class)]
    private $rapport;

    #[ORM\OneToMany(mappedBy: 'intervention', targetEntity: Commentaire::class)]
    private $commentaires;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $DateDebutIntervention;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $DateFinIntervention;

    #[ORM\OneToOne(mappedBy: 'intervention', targetEntity: Calendar::class, cascade: ['persist', 'remove'])]
    private $calendar;

    public function __construct()
    {
        $this->equipes = new ArrayCollection();
        $this->interventionAss = new ArrayCollection();
        $this->equipement = new ArrayCollection();
        $this->rapport = new ArrayCollection();
        $this->commentaires = new ArrayCollection();
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

    public function getLatitude(): ?float
    {
        return $this->Latitude;
    }

    public function setLatitude(float $Latitude): self
    {
        $this->Latitude = $Latitude;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->Longitude;
    }

    public function setLongitude(float $Longitude): self
    {
        $this->Longitude = $Longitude;

        return $this;
    }

    public function __toString() 
    {
        return (string) $this->id; 
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
            $rapport->setIntervention($this);
        }

        return $this;
    }

    public function removeRapport(Rapport $rapport): self
    {
        if ($this->rapport->removeElement($rapport)) {
            // set the owning side to null (unless already changed)
            if ($rapport->getIntervention() === $this) {
                $rapport->setIntervention(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Commentaire>
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaire $commentaire): self
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires[] = $commentaire;
            $commentaire->setIntervention($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): self
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getIntervention() === $this) {
                $commentaire->setIntervention(null);
            }
        }

        return $this;
    }

    public function getDateDebutIntervention(): ?\DateTimeInterface
    {
        return $this->DateDebutIntervention;
    }

    public function setDateDebutIntervention(?\DateTimeInterface $DateDebutIntervention): self
    {
        $this->DateDebutIntervention = $DateDebutIntervention;

        return $this;
    }

    public function getDateFinIntervention(): ?\DateTimeInterface
    {
        return $this->DateFinIntervention;
    }

    public function setDateFinIntervention(?\DateTimeInterface $DateFinIntervention): self
    {
        $this->DateFinIntervention = $DateFinIntervention;

        return $this;
    }

    public function getCalendar(): ?Calendar
    {
        return $this->calendar;
    }

    public function setCalendar(?Calendar $calendar): self
    {
        // unset the owning side of the relation if necessary
        if ($calendar === null && $this->calendar !== null) {
            $this->calendar->setIntervention(null);
        }

        // set the owning side of the relation if necessary
        if ($calendar !== null && $calendar->getIntervention() !== $this) {
            $calendar->setIntervention($this);
        }

        $this->calendar = $calendar;

        return $this;
    }

}
