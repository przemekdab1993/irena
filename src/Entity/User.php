<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Link;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ApiResource(
    operations: [
        new Get(
            normalizationContext: [
                'groups' => ['user:read', 'user:item:get']
            ]
        ),
        new GetCollection(),
        new Post(),
        new Put(),
        new Patch(),
        new Delete()
    ],
    formats: [
        'json',
        'jsonld',
        'html',
        'csv'
    ],
    normalizationContext: [
        'groups' => ['user:read']
    ],
    denormalizationContext: [
        'groups' => ['user:write']
    ],
)]
#[ApiResource(
    uriTemplate: '/country/{country_id}/users_visited.{_format}',
    operations: [new GetCollection()],
    uriVariables: [
        'country_id' => new Link(
            toProperty: 'countriesVisited',
            fromClass: Country::class,
        ),
    ],
    normalizationContext: [
        'groups'=> ['user:visited:read']
    ]
)]
#[UniqueEntity(fields: ['email'], message:  'There is already an account with the email')]
#[UniqueEntity(fields: ['username'], message:  'There is already an account with the username')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Groups([
        'user:read',
        'user:write'
    ])]
    #[Assert\NotBlank]
    private ?string $username = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    #[Groups(['user:write'])]
    #[Assert\NotBlank]
    private ?string $password = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups([
        'user:read', 'user:visited:read',
        'user:write'
    ])]
    private ?string $firstName = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups([
        'user:read', 'user:visited:read',
        'user:write'
    ])]
    private ?string $lastName = null;

    #[ORM\Column]
    #[Groups(['user:read', 'user:write'])]
    #[Assert\NotBlank]
    #[Assert\GreaterThanOrEqual(16)]
    #[Assert\LessThanOrEqual(99)]
    private ?int $age = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Groups(['user:read', 'user:write'])]
    #[Assert\Email]
    private ?string $email = null;

    #[ORM\ManyToMany(targetEntity: Country::class, inversedBy: 'usersVisited', cascade: ['persist'])]
    #[Groups(['user:read', 'user:write'])]
    #[Assert\Valid]
    private Collection $countriesVisited;

    public function __construct()
    {
        $this->countriesVisited = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection<int, Country>
     */
    public function getCountriesVisited(): Collection
    {
        return $this->countriesVisited;
    }

    public function addCountriesVisited(Country $countriesVisited): self
    {
        if (!$this->countriesVisited->contains($countriesVisited)) {
            $this->countriesVisited->add($countriesVisited);
        }

        return $this;
    }

    public function removeCountriesVisited(Country $countriesVisited): self
    {
        $this->countriesVisited->removeElement($countriesVisited);

        return $this;
    }
}
