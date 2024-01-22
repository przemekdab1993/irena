<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\UserAppVisitedCountryRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: UserAppVisitedCountryRepository::class)]
#[ApiResource]
class UserAppVisitedCountry
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['country:read', 'country:write'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'userAppVisitedCountries')]
    #[Groups(['country:read', 'country:write'])]
    private ?UserApp $userApp = null;

    #[ORM\ManyToOne(inversedBy: 'userAppVisitedCountries')]
    private ?Country $country = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserApp(): ?UserApp
    {
        return $this->userApp;
    }

    public function setUserApp(?UserApp $userApp): static
    {
        $this->userApp = $userApp;

        return $this;
    }

    public function getCountry(): ?Country
    {
        return $this->country;
    }

    public function setCountry(?Country $country): static
    {
        $this->country = $country;

        return $this;
    }
}
