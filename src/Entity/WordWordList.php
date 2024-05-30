<?php

namespace App\Entity;

use App\Repository\WordWordListRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WordWordListRepository::class)]
class WordWordList
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'wordWordLists')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Word $word = null;

    #[ORM\ManyToOne(inversedBy: 'wordWordLists')]
    #[ORM\JoinColumn(nullable: false)]
    private ?WordList $wordList = null;

    #[ORM\ManyToOne(inversedBy: 'wordWordLists')]
    private ?WordVariation $variation = null;

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

    public function getWordList(): ?WordList
    {
        return $this->wordList;
    }

    public function setWordList(?WordList $wordList): static
    {
        $this->wordList = $wordList;

        return $this;
    }

    public function getVariation(): ?WordVariation
    {
        return $this->variation;
    }

    public function setVariation(?WordVariation $variation): static
    {
        $this->variation = $variation;

        return $this;
    }
}
