<?php

namespace App\Entity;

use App\Repository\MessageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MessageRepository::class)]
class Message
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $Contenu;

    #[ORM\Column(type: 'datetime')]
    private $DateEnvoi;

    #[ORM\ManyToOne(inversedBy: 'messagesSender')]
    private ?Utilisateur $MessageSender = null;

    #[ORM\ManyToOne(inversedBy: 'messagesReceiver')]
    private ?Utilisateur $MessageReceiver = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContenu(): ?string
    {
        return $this->Contenu;
    }

    public function setContenu(string $Contenu): self
    {
        $this->Contenu = $Contenu;

        return $this;
    }

    public function getDateEnvoi(): ?\DateTimeInterface
    {
        return $this->DateEnvoi;
    }

    public function setDateEnvoi(\DateTimeInterface $DateEnvoi): self
    {
        $this->DateEnvoi = $DateEnvoi;

        return $this;
    }

    public function getMessageSender(): ?Utilisateur
    {
        return $this->MessageSender;
    }

    public function setMessageSender(?Utilisateur $MessageSender): self
    {
        $this->MessageSender = $MessageSender;

        return $this;
    }

    public function getMessageReceiver(): ?Utilisateur
    {
        return $this->MessageReceiver;
    }

    public function setMessageReceiver(?Utilisateur $MessageReceiver): self
    {
        $this->MessageReceiver = $MessageReceiver;

        return $this;
    }

}
