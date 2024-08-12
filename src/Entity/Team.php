<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ApiResource]
class Team
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 10)]
    private ?string $shortname = null;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $foundation = null;

    #[ORM\Column(length: 255)]
    private ?string $shield = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $photo = null;

    #[ORM\ManyToOne(targetEntity: Stadium::class)]
    #[ORM\JoinColumn(name: 'stadium_id', referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
    private ?Stadium $stadium = null;

    #[ORM\OneToMany(targetEntity: Player::class, mappedBy: 'team', cascade: ['persist'], orphanRemoval: true)]
    private Collection $players;

    public function __construct()
    {
        $this->players = new ArrayCollection();
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



}
