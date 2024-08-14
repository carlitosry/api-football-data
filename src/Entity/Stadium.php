<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\StadiumRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: StadiumRepository::class)]
#[ApiResource(
    operations: [
        new Get(uriTemplate: '/stadiums/{id}'),
        new GetCollection(uriTemplate: '/stadiums')
    ]
)]
class Stadium
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups([ 'matches:collection:get', 'team:collection:get'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups([ 'matches:collection:get', 'team:collection:get'])]
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
