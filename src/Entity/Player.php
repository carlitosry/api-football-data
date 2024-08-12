<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\PlayerRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlayerRepository::class)]
#[ApiResource]
class Player
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $externalId = null;

    #[ORM\Column(length: 255)]
    private ?string $externalUrl = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\Column(length: 255)]
    private ?string $nickname = null;

    #[ORM\Column(length: 255)]
    private ?string $firstname = null;

    #[ORM\Column(length: 255)]
    private ?string $lastname = null;

    #[ORM\Column(length: 10)]
    private ?string $gender = null;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $dateOfBirth = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $place_of_birth = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $weight = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $height = null;

    #[ORM\Column(type: 'boolean')]
    private bool $international = false;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $twitter = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $instagram = null;

    #[ORM\Column(length: 2)]
    private ?string $country = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $shirtNumber = null;

    #[ORM\Column(length: 255)]
    private string $position;

    #[ORM\ManyToOne(targetEntity: Team::class, inversedBy: 'players')]
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
        return $this->place_of_birth;
    }

    public function setPlaceOfBirth(?string $place_of_birth): Player
    {
        $this->place_of_birth = $place_of_birth;
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
}
