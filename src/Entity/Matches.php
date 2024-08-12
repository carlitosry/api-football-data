<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\MatcheRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MatcheRepository::class)]
#[ApiResource]
class Matches
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Team::class, inversedBy: 'matches')]
    #[ORM\JoinColumn(name: 'team_a_id', referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
    private ?Team $teamA = null;

    #[ORM\ManyToOne(targetEntity: Team::class, inversedBy: 'matches')]
    #[ORM\JoinColumn(name: 'team_b_id', referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
    private ?Team $teamB = null;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $date = null;

    #[ORM\ManyToOne(targetEntity: Stadium::class)]
    #[ORM\JoinColumn(name: 'stadium_id', referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
    private ?Stadium $stadium = null;

    #[ORM\ManyToOne(targetEntity: Competition::class)]
    #[ORM\JoinColumn(name: 'competition_id', referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
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
}
