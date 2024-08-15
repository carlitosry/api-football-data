<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\CompetitionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CompetitionRepository::class)]
#[ApiResource(
    operations: [
        new Get(),
        new GetCollection()
    ],
    normalizationContext: ['groups' => ['competition:collection:get']]
)]
class Competition
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['matches:collection:get', 'competition:collection:get'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['matches:collection:get', 'competition:collection:get' ])]
    private ?string $name = null;

    #[ORM\OneToMany(targetEntity: Season::class, mappedBy: 'competition')]
    #[ORM\JoinColumn(name: 'season_id', referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
    #[Groups(['competition:collection:get'])]
    private Collection $seasons ;

    public function __construct()
    {
        $this->seasons = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection<int, Season>
     */
    public function getSeasons(): \Doctrine\Common\Collections\Collection
    {
        return $this->seasons;
    }

    public function addSeason(Season $season): static
    {
        if (!$this->seasons->contains($season)) {
            $this->seasons->add($season);
            $season->setCompetition($this);
        }

        return $this;
    }

    public function removeSeason(Season $season): static
    {
        if ($this->seasons->removeElement($season)) {
            // set the owning side to null (unless already changed)
            if ($season->getCompetition() === $this) {
                $season->setCompetition(null);
            }
        }

        return $this;
    }

}
