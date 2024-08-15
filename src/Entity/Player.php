<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\PlayerRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Context;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

#[ORM\Entity(repositoryClass: PlayerRepository::class)]
#[ApiResource(
    operations: [
        new Get(),
        new GetCollection()
    ],
    normalizationContext: ['groups' => ['collection:get']]
)]
class Player
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['collection:get', 'team:collection:get'])]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups(['admin:read'])]
    private ?int $externalId = null;

    #[ORM\Column(length: 255)]
    #[Groups(['admin:read'])]
    private ?string $externalUrl = null;

    #[ORM\Column(length: 255)]
    #[Groups(['admin:read'])]
    private ?string $slug = null;

    #[ORM\Column(length: 255)]
    #[Groups(['admin:read'])]
    private ?string $nickname = null;

    #[ORM\Column(length: 255)]
    #[Groups(['admin:read'])]
    private ?string $firstname = null;

    #[ORM\Column(length: 255)]
    #[Groups(['admin:read'])]
    private ?string $lastname = null;

    #[ORM\Column(length: 10)]
    #[Groups(['admin:read'])]
    private ?string $gender = null;

    #[ORM\Column(type: 'datetime')]
    #[Context([DateTimeNormalizer::FORMAT_KEY => 'Y-m-d'])]
    #[Groups(['admin:read'])]
    private ?\DateTimeInterface $dateOfBirth = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['admin:read'])]
    private ?string $placeOfBirth = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    #[Groups(['admin:read'])]
    private ?int $weight = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    #[Groups(['admin:read'])]
    private ?int $height = null;

    #[ORM\Column(type: 'boolean')]
    #[Groups(['admin:read'])]
    private bool $international = false;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['admin:read'])]
    private ?string $twitter = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['admin:read'])]
    private ?string $instagram = null;

    #[ORM\Column(length: 255)]
    #[Groups(['admin:read'])]
    private ?string $country = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    #[Groups(['admin:read'])]
    private ?int $shirtNumber = null;

    #[ORM\Column(length: 255)]
    #[Groups(['admin:read'])]
    private string $position;

    #[ORM\ManyToOne(targetEntity: Team::class, cascade: ["persist"], inversedBy: 'players')]
    #[ORM\JoinColumn(name: 'team_id', referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
    private ?Team $team = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(): ?int
    {
        return $this->id;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): Player
    {
        $this->slug = $slug;
        return $this;
    }

    public function getNickname(): ?string
    {
        return $this->nickname;
    }

    public function setNickname(?string $nickname): Player
    {
        $this->nickname = $nickname;
        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(?string $firstname): Player
    {
        $this->firstname = $firstname;
        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(?string $lastname): Player
    {
        $this->lastname = $lastname;
        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(?string $gender): Player
    {
        $this->gender = $gender;
        return $this;
    }

    public function getDateOfBirth(): ?\DateTimeInterface
    {
        return $this->dateOfBirth;
    }

    public function setDateOfBirth(?\DateTimeInterface $dateOfBirth): Player
    {
        $this->dateOfBirth = $dateOfBirth;
        return $this;
    }

    public function getPlaceOfBirth(): ?string
    {
        return $this->placeOfBirth;
    }

    public function setPlaceOfBirth(?string $placeOfBirth): Player
    {
        $this->placeOfBirth = $placeOfBirth;
        return $this;
    }

    public function getWeight(): ?int
    {
        return $this->weight;
    }

    public function setWeight(?int $weight): Player
    {
        $this->weight = $weight;
        return $this;
    }

    public function getHeight(): ?int
    {
        return $this->height;
    }

    public function setHeight(?int $height): Player
    {
        $this->height = $height;
        return $this;
    }

    public function isInternational(): bool
    {
        return $this->international;
    }

    public function setInternational(bool $international): Player
    {
        $this->international = $international;
        return $this;
    }

    public function getTwitter(): ?string
    {
        return $this->twitter;
    }

    public function setTwitter(?string $twitter): Player
    {
        $this->twitter = $twitter;
        return $this;
    }

    public function getInstagram(): ?string
    {
        return $this->instagram;
    }

    public function setInstagram(?string $instagram): Player
    {
        $this->instagram = $instagram;
        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): Player
    {
        $this->country = $country;
        return $this;
    }

    public function getShirtNumber(): ?int
    {
        return $this->shirtNumber;
    }

    public function setShirtNumber(?int $shirtNumber): self
    {
        $this->shirtNumber = $shirtNumber;
        return $this;
    }

    public function getPosition(): ?string
    {
        return $this->position;
    }

    public function setPosition(string $position): self
    {
        $this->position = $position;
        return $this;
    }

    public function getTeam(): ?Team
    {
        return $this->team;
    }

    public function setTeam(?Team $team): Player
    {
        $this->team = $team;
        return $this;
    }

    public function getExternalId(): ?int
    {
        return $this->externalId;
    }

    public function setExternalId(int $externalId): static
    {
        $this->externalId = $externalId;

        return $this;
    }

    public function getExternalUrl(): ?string
    {
        return $this->externalUrl;
    }

    public function setExternalUrl(string $externalUrl): static
    {
        $this->externalUrl = $externalUrl;

        return $this;
    }
    #[Groups(['collection:get', 'team:collection:get'])]
    public function getFullName(): string
    {
        return $this->firstname . ' ' . $this->lastname;
    }
}
