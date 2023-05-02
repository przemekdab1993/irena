<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\CountryRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

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
        'jsonhal',
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
class Country
{
    private const STATUS_CODE = ['UNVERIFIED', 'ACTIVE', 'INACTIVE'];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['country:read', 'country:write'])]
    #[NotBlank]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups(['country:read', 'country:write'])]
    #[NotBlank]
    #[Length(exactly:2, exactMessage: 'The country symbol should have exactly two characters')]
    private ?string $flagSymbol = null;

    #[ORM\Column(length: 255)]
    #[Groups(['country:write'])]
    #[ApiFilter(SearchFilter::class, strategy: 'partial')]
    private ?string $status = 'UNVERIFIED';


    public function __construct()
    {
//        $this->setStatus('UNVERIFIED');
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
}
