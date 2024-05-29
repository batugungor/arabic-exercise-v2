<?php

namespace App\Entity;

use App\Repository\WordVariationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WordVariationRepository::class)]
class WordVariation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'wordVariations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Word $word = null;

    #[ORM\Column(length: 255)]
    private ?string $variation = null;

    #[ORM\ManyToOne(inversedBy: 'wordVariations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?VariationTypes $variationType = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $commentary = null;


    public function __construct()
    {
        $this->wordVariations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWord(): ?Word
    {
        return $this->word;
    }

    public function setWord(?Word $word): static
    {
        $this->word = $word;

        return $this;
    }

    public function getVariation(): ?string
    {
        return $this->variation;
    }

    public function setVariation(string $variation): static
    {
        $this->variation = $variation;

        return $this;
    }

    public function getVariationType(): ?VariationTypes
    {
        return $this->variationType;
    }

    public function setVariationType(?VariationTypes $variationType): static
    {
        $this->variationType = $variationType;

        return $this;
    }

    public function getCommentary(): ?string
    {
        return $this->commentary;
    }

    public function setCommentary(?string $commentary): static
    {
        $this->commentary = $commentary;

        return $this;
    }
}
