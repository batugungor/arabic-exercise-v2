<?php

namespace App\Entity;

use App\Repository\WordRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WordRepository::class)]
class Word
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $word = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $meaning = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    /**
     * @var Collection<int, WordVariation>
     */
    #[ORM\OneToMany(targetEntity: WordVariation::class, mappedBy: 'word', orphanRemoval: true)]
    private Collection $wordVariations;

    public function __construct()
    {
        $this->wordVariations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWord(): ?string
    {
        return $this->word;
    }

    public function setWord(string $word): static
    {
        $this->word = $word;

        return $this;
    }

    public function getMeaning(): ?string
    {
        return $this->meaning;
    }

    public function setMeaning(?string $meaning): static
    {
        $this->meaning = $meaning;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, WordVariation>
     */
    public function getWordVariations(): Collection
    {
        return $this->wordVariations;
    }

    public function addWordVariation(WordVariation $wordVariation): static
    {
        if (!$this->wordVariations->contains($wordVariation)) {
            $this->wordVariations->add($wordVariation);
            $wordVariation->setWord($this);
        }

        return $this;
    }

    public function removeWordVariation(WordVariation $wordVariation): static
    {
        if ($this->wordVariations->removeElement($wordVariation)) {
            // set the owning side to null (unless already changed)
            if ($wordVariation->getWord() === $this) {
                $wordVariation->setWord(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->getWord();
    }
}
