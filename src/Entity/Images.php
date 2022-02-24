<?php

namespace App\Entity;

use App\Repository\ImagesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ImagesRepository::class)]
class Images
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Ad::class, inversedBy: 'images')]
    #[ORM\JoinColumn(nullable: false)]
    private $ads;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAds(): ?Ad
    {
        return $this->ads;
    }

    public function setAds(?Ad $ads): self
    {
        $this->ads = $ads;

        return $this;
    }
}
