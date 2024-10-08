<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\MatchesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\Context;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

#[ORM\Entity(repositoryClass: MatchesRepository::class)]
#[ApiResource(
    operations : [
        new Get(uriTemplate: '/matches/{id}'),
        new GetCollection(uriTemplate: '/matches')
    ],
    normalizationContext: ['groups' => ['matches:collection:get']]
)]

class Matches
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['matches:collection:get'])]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Team::class, cascade: ["persist"], inversedBy: 'matches')]
    #[ORM\JoinColumn(name: 'team_a_id', referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
    #[Groups(['admin:read'])]
    private ?Team $teamA = null;

    #[ORM\ManyToOne(targetEntity: Team::class, cascade:["persist"], inversedBy: 'matches')]
    #[ORM\JoinColumn(name: 'team_b_id', referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
    #[Groups(['admin:read'])]
    private ?Team $teamB = null;

    #[ORM\Column(type: 'datetime')]
    #[Context([DateTimeNormalizer::FORMAT_KEY => 'Y-m-d'])]
    #[Groups(['admin:read'])]
    private ?\DateTimeInterface $date = null;

    #[ORM\ManyToOne(targetEntity: Stadium::class, cascade:["persist"])]
    #[ORM\JoinColumn(name: 'stadium_id', referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
    #[Groups(['admin:read'])]
    private ?Stadium $stadium = null;

    #[ORM\ManyToOne(targetEntity: Competition::class, cascade:["persist"])]
    #[ORM\JoinColumn(name: 'competition_id', referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
    #[Groups(['admin:read'])]
    private ?Competition $competition = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTeamA(): ?Team
    {
        return $this->teamA;
    }

    public function setTeamA(?Team $teamA): Matches
    {
        $this->teamA = $teamA;
        return $this;
    }

    public function getStadium(): ?Stadium
    {
        return $this->stadium;
    }

    public function setStadium(?Stadium $stadium): static
    {
        $this->stadium = $stadium;

        return $this;
    }

    public function getTeamB(): ?Team
    {
        return $this->teamB;
    }

    public function setTeamB(?Team $teamB): static
    {
        $this->teamB = $teamB;

        return $this;
    }

    public function getCompetition(): ?Competition
    {
        return $this->competition;
    }

    public function setCompetition(?Competition $competition): static
    {
        $this->competition = $competition;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    #[Groups(['matches:collection:get'])]
    public function getName(): string
    {
        return $this->teamA->getName() . ' vs ' . $this->teamB->getName();
    }
}
