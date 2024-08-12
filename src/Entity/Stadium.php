<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\StadiumRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StadiumRepository::class)]
#[ApiResource]
class Stadium
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $stadiumImage = null;

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

    public function getStadiumImage(): ?string
    {
        return $this->stadiumImage;
    }

    public function setStadiumImage(string $stadiumImage): static
    {
        $this->stadiumImage = $stadiumImage;

        return $this;
    }
}
