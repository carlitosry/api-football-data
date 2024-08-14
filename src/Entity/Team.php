<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Context;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

#[ORM\Entity]
#[ApiResource(
    operations: [
        new Get(normalizationContext: ['groups' => ['team:collection:get', 'team:get'], 'enable_max_depth' => true]),
        new GetCollection()
    ],
    normalizationContext: ['groups' => ['team:collection:get'], 'enable_max_depth' => true]
)]
class Team
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['team:collection:get', 'matches:collection:get'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['team:collection:get', 'matches:collection:get'])]
    private ?string $name = null;

    #[ORM\Column(length: 10)]
    #[Groups(['team:collection:get'])]
    private ?string $shortname = null;

    #[ORM\Column(type: 'datetime')]
    #[Context([DateTimeNormalizer::FORMAT_KEY => 'Y-m-d'])]
    #[Groups(['team:collection:get'])]
    private ?\DateTimeInterface $foundation = null;

    #[ORM\Column(length: 255)]
    #[Groups(['team:collection:get', 'matches:collection:get'])]
    private ?string $shield = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['team:collection:get'])]
    private ?string $photo = null;

    #[ORM\ManyToOne(targetEntity: Stadium::class)]
    #[ORM\JoinColumn(name: 'stadium_id', referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
    #[Groups(['team:collection:get'])]
    private ?Stadium $stadium = null;

    #[ORM\OneToMany(targetEntity: Player::class, mappedBy: 'team', cascade: ['persist'], orphanRemoval: true)]
    #[Groups(['team:collection:get'])]
    private Collection $players;

    #[ORM\OneToMany(targetEntity: Matches::class, mappedBy: 'team', cascade: ['persist'], orphanRemoval: true)]
    private Collection $matches;

    public function __construct()
    {
        $this->players = new ArrayCollection();
        $this->matches = new ArrayCollection();
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

    public function getShortname(): ?string
    {
        return $this->shortname;
    }

    public function setShortname(string $shortname): self
    {
        $this->shortname = $shortname;
        return $this;
    }

    public function getFoundation(): ?\DateTimeInterface
    {
        return $this->foundation;
    }

    public function setFoundation(\DateTimeInterface $foundation): self
    {
        $this->foundation = $foundation;
        return $this;
    }

    public function getShield(): ?string
    {
        return $this->shield;
    }

    public function setShield(string $shield): self
    {
        $this->shield = $shield;
        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;
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

    /**
     * @return Collection<int, Player>
     */
    public function getPlayers(): Collection
    {
        return $this->players;
    }

    public function addPlayer(Player $player): static
    {
        if (!$this->players->contains($player)) {
            $this->players->add($player);
            $player->setTeam($this);
        }

        return $this;
    }

    public function removePlayer(Player $player): static
    {
        if ($this->players->removeElement($player)) {
            // set the owning side to null (unless already changed)
            if ($player->getTeam() === $this) {
                $player->setTeam(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Matches>
     */
    public function getMatches(): Collection
    {
        return $this->matches;
    }

    public function addMatch(Matches $match): static
    {
        if (!$this->matches->contains($match)) {
            $this->matches->add($match);

            if ($match->getTeamA() === null) {
                $match->setTeamA($this);
            }else{
                $match->setTeamB($this);

            }
        }

        return $this;
    }

    public function removeMatch(Matches $match): static
    {
        if ($this->matches->removeElement($match)) {
            // set the owning side to null (unless already changed)
            if ($match->getTeamA() === $this) {
                $match->setTeamA(null);
            }

            if ($match->getTeamB() === $this) {
                $match->setTeamB(null);
            }
        }

        return $this;
    }



}
