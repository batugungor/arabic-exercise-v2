<?php

namespace App\Entity;

use App\Repository\VariationTypesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VariationTypesRepository::class)]
class VariationTypes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    /**
     * @var Collection<int, WordVariation>
     */
    #[ORM\OneToMany(targetEntity: WordVariation::class, mappedBy: 'variationType')]
    private Collection $wordVariations;

    public function __construct()
    {
        $this->wordVariations = new ArrayCollection();
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
            $wordVariation->setVariationType($this);
        }

        return $this;
    }

    public function removeWordVariation(WordVariation $wordVariation): static
    {
        if ($this->wordVariations->removeElement($wordVariation)) {
            // set the owning side to null (unless already changed)
            if ($wordVariation->getVariationType() === $this) {
                $wordVariation->setVariationType(null);
            }
        }

        return $this;
    }
}
