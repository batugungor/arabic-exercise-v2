<?php

namespace App\Entity;

use App\Repository\WordListRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WordListRepository::class)]
class WordList
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column]
    private ?bool $visible = null;

    /**
     * @var Collection<int, Page>
     */
    #[ORM\OneToMany(targetEntity: Page::class, mappedBy: 'wordList')]
    private Collection $pages;

    /**
     * @var Collection<int, WordWordList>
     */
    #[ORM\OneToMany(targetEntity: WordWordList::class, mappedBy: 'wordList')]
    private Collection $wordWordLists;

    public function __construct()
    {
        $this->pages = new ArrayCollection();
        $this->wordWordLists = new ArrayCollection();
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

    public function isVisible(): ?bool
    {
        return $this->visible;
    }

    public function setVisible(bool $visible): static
    {
        $this->visible = $visible;

        return $this;
    }

    /**
     * @return Collection<int, Page>
     */
    public function getPages(): Collection
    {
        return $this->pages;
    }

    public function addPage(Page $page): static
    {
        if (!$this->pages->contains($page)) {
            $this->pages->add($page);
            $page->setWordList($this);
        }

        return $this;
    }

    public function removePage(Page $page): static
    {
        if ($this->pages->removeElement($page)) {
            // set the owning side to null (unless already changed)
            if ($page->getWordList() === $this) {
                $page->setWordList(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, WordWordList>
     */
    public function getWordWordLists(): Collection
    {
        return $this->wordWordLists;
    }

    public function addWordWordList(WordWordList $wordWordList): static
    {
        if (!$this->wordWordLists->contains($wordWordList)) {
            $this->wordWordLists->add($wordWordList);
            $wordWordList->setWordList($this);
        }

        return $this;
    }

    public function removeWordWordList(WordWordList $wordWordList): static
    {
        if ($this->wordWordLists->removeElement($wordWordList)) {
            // set the owning side to null (unless already changed)
            if ($wordWordList->getWordList() === $this) {
                $wordWordList->setWordList(null);
            }
        }

        return $this;
    }
}
