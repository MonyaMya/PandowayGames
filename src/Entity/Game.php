<?php

namespace App\Entity;

use App\Repository\GameRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GameRepository::class)
 */
class Game
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $poster;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $mainColor;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $secondaryColor;

    /**
     * @ORM\Column(type="text")
     */
    private $gameDescription;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isPublished;

    /**
     * @ORM\OneToMany(targetEntity=BreakScene::class, mappedBy="game", orphanRemoval=true)
     */
    private $breakScene;

    /**
     * @ORM\OneToMany(targetEntity=Clue::class, mappedBy="game", orphanRemoval=true)
     */
    private $clue;

    /**
     * @ORM\OneToMany(targetEntity=Dialog::class, mappedBy="game", orphanRemoval=true)
     */
    private $dialog;

    public function __construct()
    {
        $this->breakScene = new ArrayCollection();
        $this->clue = new ArrayCollection();
        $this->dialog = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getPoster(): ?string
    {
        return $this->poster;
    }

    public function setPoster(string $poster): self
    {
        $this->poster = $poster;

        return $this;
    }

    public function getMainColor(): ?string
    {
        return $this->mainColor;
    }

    public function setMainColor(string $mainColor): self
    {
        $this->mainColor = $mainColor;

        return $this;
    }

    public function getSecondaryColor(): ?string
    {
        return $this->secondaryColor;
    }

    public function setSecondaryColor(string $secondaryColor): self
    {
        $this->secondaryColor = $secondaryColor;

        return $this;
    }

    public function getGameDescription(): ?string
    {
        return $this->gameDescription;
    }

    public function setGameDescription(string $gameDescription): self
    {
        $this->gameDescription = $gameDescription;

        return $this;
    }

    /**
     * @return Collection|BreakScene[]
     */
    public function getBreakScene(): Collection
    {
        return $this->breakScene;
    }

    public function addBreakScene(BreakScene $breakScene): self
    {
        if (!$this->breakScene->contains($breakScene)) {
            $this->breakScene[] = $breakScene;
            $breakScene->setGame($this);
        }

        return $this;
    }

    public function removeBreakScene(BreakScene $breakScene): self
    {
        if ($this->breakScene->removeElement($breakScene)) {
            // set the owning side to null (unless already changed)
            if ($breakScene->getGame() === $this) {
                $breakScene->setGame(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Clue[]
     */
    public function getClue(): Collection
    {
        return $this->clue;
    }

    public function addClue(Clue $clue): self
    {
        if (!$this->clue->contains($clue)) {
            $this->clue[] = $clue;
            $clue->setGame($this);
        }

        return $this;
    }

    public function removeClue(Clue $clue): self
    {
        if ($this->clue->removeElement($clue)) {
            // set the owning side to null (unless already changed)
            if ($clue->getGame() === $this) {
                $clue->setGame(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Dialog[]
     */
    public function getDialog(): Collection
    {
        return $this->dialog;
    }

    public function addDialog(Dialog $dialog): self
    {
        if (!$this->dialog->contains($dialog)) {
            $this->dialog[] = $dialog;
            $dialog->setGame($this);
        }

        return $this;
    }

    public function removeDialog(Dialog $dialog): self
    {
        if ($this->dialog->removeElement($dialog)) {
            // set the owning side to null (unless already changed)
            if ($dialog->getGame() === $this) {
                $dialog->setGame(null);
            }
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIsPublished()
    {
        return $this->isPublished;
    }

    /**
     * @param mixed $isPublished
     */
    public function setIsPublished($isPublished): void
    {
        $this->isPublished = $isPublished;
    }

}
