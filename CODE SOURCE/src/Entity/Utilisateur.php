<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\InheritanceType;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
#[InheritanceType("JOINED")]
#[UniqueEntity(fields:['Email'],message:'Il existe deja un utilisateur avec cet Email')]
class Utilisateur extends ActionInfos
implements UserInterface,PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    protected $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $Nom;

    #[ORM\Column(type: 'string', length: 255)]
    private $Prenom;

    #[ORM\Column(type: 'integer')]
    private $Age;

    #[ORM\Column(type: 'string', length: 255)]
    private $Sexe;

    #[ORM\Column(type: 'integer')]
    private $Telephone;

    #[ORM\Column(type: 'string', length: 255)]
    private $Adresse;

    #[ORM\Column(type: 'string', length: 255)]
    private $Email;

    #[ORM\Column(type: 'string', length: 255)]
    private $MotDePasse;

    #[ORM\Column(type: 'json')]
    private $Roles = [];

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $Image;

    #[ORM\Column(type: 'string', length: 255)]
    private $Code;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $Newsletter;

    #[ORM\OneToMany(mappedBy: 'MessageSender', targetEntity: Message::class)]
    private Collection $messagesSender;

    #[ORM\OneToMany(mappedBy: 'MessageReceiver', targetEntity: Message::class)]
    private Collection $messagesReceiver;

    public function __construct()
    {
        $this->messagesSender = new ArrayCollection();
        $this->messagesReceiver = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): self
    {
        $this->Nom = $Nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->Prenom;
    }

    public function setPrenom(string $Prenom): self
    {
        $this->Prenom = $Prenom;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->Age;
    }

    public function setAge(int $Age): self
    {
        $this->Age = $Age;

        return $this;
    }

    public function getSexe(): ?string
    {
        return $this->Sexe;
    }

    public function setSexe(string $Sexe): self
    {
        $this->Sexe = $Sexe;

        return $this;
    }

    public function getTelephone(): ?int
    {
        return $this->Telephone;
    }

    public function setTelephone(int $Telephone): self
    {
        $this->Telephone = $Telephone;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->Adresse;
    }

    public function setAdresse(string $Adresse): self
    {
        $this->Adresse = $Adresse;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->Email;
    }

    public function setEmail(string $Email): self
    {
        $this->Email = $Email;

        return $this;
    }

    public function getMotDePasse(): ?string
    {
        return $this->MotDePasse;
    }

    public function setMotDePasse(string $MotDePasse): self
    {
        $this->MotDePasse = $MotDePasse;

        return $this;
    }

    
    public function getRoles(): array
    {
        $Roles = $this->Roles;
        $Roles[] = 'ROLE_USER';

        return array_unique($Roles);
    }

    public function setRoles(array $Roles): self
    {
        $this->Roles = $Roles;

        return $this;
    }

    public function eraseCredentials()
    {

    }

    public function getUserIdentifier(): string
    {
        return (string) $this->Email;
    }


    public function getPassword(): ? string
    {
        return $this->MotDePasse;
    }

    public function setPassword(string $password): self
    {
        $this->MotDePasse = $password;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->Image;
    }

    public function setImage(?string $Image): self
    {
        $this->Image = $Image;

        return $this;
    }

    
    public function __toString() 
    {
        return (string) $this->Nom; 
    }

    public function getCode(): ?string
    {
        return $this->Code;
    }

    public function setCode(string $Code): self
    {
        $this->Code = $Code;

        return $this;
    }

    public function isNewsletter(): ?bool
    {
        return $this->Newsletter;
    }

    public function setNewsletter(?bool $Newsletter): self
    {
        $this->Newsletter = $Newsletter;

        return $this;
    }

    /**
     * @return Collection<int, Message>
     */
    public function getMessagesSender(): Collection
    {
        return $this->messagesSender;
    }

    public function addMessagesSender(Message $messagesSender): self
    {
        if (!$this->messagesSender->contains($messagesSender)) {
            $this->messagesSender->add($messagesSender);
            $messagesSender->setMessageSender($this);
        }

        return $this;
    }

    public function removeMessagesSender(Message $messagesSender): self
    {
        if ($this->messagesSender->removeElement($messagesSender)) {
            // set the owning side to null (unless already changed)
            if ($messagesSender->getMessageSender() === $this) {
                $messagesSender->setMessageSender(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Message>
     */
    public function getMessagesReceiver(): Collection
    {
        return $this->messagesReceiver;
    }

    public function addMessagesReceiver(Message $messagesReceiver): self
    {
        if (!$this->messagesReceiver->contains($messagesReceiver)) {
            $this->messagesReceiver->add($messagesReceiver);
            $messagesReceiver->setMessageReceiver($this);
        }

        return $this;
    }

    public function removeMessagesReceiver(Message $messagesReceiver): self
    {
        if ($this->messagesReceiver->removeElement($messagesReceiver)) {
            // set the owning side to null (unless already changed)
            if ($messagesReceiver->getMessageReceiver() === $this) {
                $messagesReceiver->setMessageReceiver(null);
            }
        }

        return $this;
    }

}
