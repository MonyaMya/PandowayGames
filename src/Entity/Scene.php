<?php

namespace App\Entity;

use App\Repository\SceneRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SceneRepository::class)
 */
class Scene
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
    private $background;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     */
    private $previousScene;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $dialog;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $investigation;

    /**
     * @ORM\ManyToOne(targetEntity=Game::class, inversedBy="scenes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $game;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBackground(): ?string
    {
        return $this->background;
    }

    public function setBackground(string $background): self
    {
        $this->background = $background;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPreviousScene(): ?int
    {
        return $this->previousScene;
    }

    public function setPreviousScene(int $previousScene): self
    {
        $this->previousScene = $previousScene;

        return $this;
    }

    public function getDialog(): ?int
    {
        return $this->dialog;
    }

    public function setDialog(?int $dialog): self
    {
        $this->dialog = $dialog;

        return $this;
    }

    public function getInvestigation(): ?int
    {
        return $this->investigation;
    }

    public function setInvestigation(?int $investigation): self
    {
        $this->investigation = $investigation;

        return $this;
    }

    public function getGame(): ?Game
    {
        return $this->game;
    }

    public function setGame(?Game $game): self
    {
        $this->game = $game;

        return $this;
    }


}
