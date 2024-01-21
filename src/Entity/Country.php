<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Link;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\CountryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CountryRepository::class)]
#[ApiResource(
    operations: [
        new Get(),
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
        'groups' => ['country:read']
    ]
    , denormalizationContext: [
        'groups' => ['country:write']
    ],
    paginationItemsPerPage: 15
)]
#[ApiResource(
    uriTemplate: '/user/{user_id}/countries_visited.{_format}',
    operations: [new GetCollection()],
    uriVariables: [
        'user_id' => new Link(
            toProperty: 'usersVisited',
            fromClass: UserApp::class,
        ),
    ],
    normalizationContext: [
        'groups'=> ['country:visited:read']
    ]
)]
#[ApiFilter(OrderFilter::class, properties: ['name' => 'DESC'])]

class Country
{
    use TimestampableEntity;

    private const STATUS_CODE = ['UNVERIFIED', 'ACTIVE', 'INACTIVE'];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups([
        'country:read',
        'country:write'
    ])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups([
        'country:read', 'user:read', 'country:visited:read',
        'country:write'
    ])]
    #[Assert\NotBlank]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups([
        'country:read', 'user:item:get',
        'country:write'
    ])]
    #[Assert\NotBlank]
    #[Assert\Length(exactly:2, exactMessage: 'The country symbol should have exactly two characters')]
    private ?string $flagSymbol = null;

    #[ORM\Column(length: 255)]
    #[Groups(['country:write'])]
    #[ApiFilter(SearchFilter::class, strategy: 'partial')]
    private ?string $status = 'UNVERIFIED';

    #[ORM\OneToMany(mappedBy: 'country', targetEntity: UserAppVisitedCountry::class)]
    #[Groups(['country:read', 'country:write'])]
    #[Assert\Valid]
    private Collection $userAppVisitedCountries;

    public function __construct()
    {
//        $this->setStatus('UNVERIFIED');
        $this->userAppVisitedCountries = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getFlagSymbol(): ?string
    {
        return $this->flagSymbol;
    }

    public function setFlagSymbol(string $flagSymbol): self
    {
        $this->flagSymbol = $flagSymbol;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $status = strtoupper($status);

        if (in_array($status,self::STATUS_CODE)) {
            $this->status = $status;
        }

        return $this;
    }

/**
 * @return Collection<int, UserAppVisitedCountry>
 */
public function getUserAppVisitedCountries(): Collection
{
    return $this->userAppVisitedCountries;
}

public function addUserAppVisitedCountry(UserAppVisitedCountry $userAppVisitedCountry): static
{
    if (!$this->userAppVisitedCountries->contains($userAppVisitedCountry)) {
        $this->userAppVisitedCountries->add($userAppVisitedCountry);
        $userAppVisitedCountry->setCountry($this);
    }

    return $this;
}

public function removeUserAppVisitedCountry(UserAppVisitedCountry $userAppVisitedCountry): static
{
    if ($this->userAppVisitedCountries->removeElement($userAppVisitedCountry)) {
        // set the owning side to null (unless already changed)
        if ($userAppVisitedCountry->getCountry() === $this) {
            $userAppVisitedCountry->setCountry(null);
        }
    }

    return $this;
}
}
