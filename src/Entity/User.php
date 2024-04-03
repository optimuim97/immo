<?php

namespace App\Entity;

use App\Repository\UserRepository;
use App\Traits\Timer;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[UniqueEntity('phone', 'Numéro existant')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    use Timer;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[ORM\CustomIdGenerator(class:'doctrine.ulid_generator')]
    #[Groups('user', 'agent')]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups('user', 'agent')]
    private ?string $firstname = null;

    #[ORM\Column(length: 255)]
    #[Groups('user', 'agent')]
    private ?string $lastname = null;

    #[ORM\Column(length: 255)]
    private ?string $dialCode = null;

    #[ORM\Column(length: 255)]
    private ?string $phoneNumber = null;

    #[ORM\Column(length: 255)]
    #[Groups('user')]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    #[Groups('user')]
    private ?string $phone = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column()]
    #[Groups('user')]
    private ?array $roles = [];

    #[ORM\OneToMany(targetEntity: UserProfil::class, mappedBy: 'UserImmo')]
    // #[Groups('user')]
    private Collection $userProfil;

    public function __construct()
    {
        $this->userProfil = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(?string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getDialCode(): ?string
    {
        return $this->dialCode;
    }

    public function setDialCode(string $dialCode): static
    {
        $this->dialCode = $dialCode;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): static
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @return Collection<int, UserProfil>
     */
    public function getProfil(): Collection
    {
        return $this->userProfil;
    }

    public function addProfil(UserProfil $profil): static
    {
        if (!$this->userProfil->contains($profil)) {
            $this->userProfil->add($profil);
            $profil->setUserImmo($this);
        }

        return $this;
    }

    public function removeProfil(UserProfil $profil): static
    {
        if ($this->userProfil->removeElement($profil)) {
            // set the owning side to null (unless already changed)
            if ($profil->getUserImmo() === $this) {
                $profil->setUserImmo(null);
            }
        }

        return $this;
    }


    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function setRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function eraseCredentials(): void
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function getUserIdentifier(): string
    {
        // TODO: Implement getUserIdentifier() method.
        return (string) $this->phone;
    }
}
