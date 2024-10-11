<?php

namespace App\Entity;

use App\Repository\UserSocieteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserSocieteRepository::class)]
class UserSociete
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'userSocietes')]
    private ?User $users = null;

    #[ORM\ManyToOne(inversedBy: 'userSocietes')]
    private ?Societe $societes = null;

    #[ORM\Column(length: 255)]
    private ?string $role = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsers(): ?User
    {
        return $this->users;
    }

    public function setUsers(?User $users): static
    {
        $this->users = $users;

        return $this;
    }

    public function getSocietes(): ?Societe
    {
        return $this->societes;
    }

    public function setSocietes(?Societe $societes): static
    {
        $this->societes = $societes;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): static
    {
        $this->role = $role;

        return $this;
    }
}
