<?php

namespace App\Entity;

use App\Repository\ClueRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ClueRepository::class)
 */
class Clue
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
     * @ORM\Column(type="integer")
     */
    private $xAxis;

    /**
     * @ORM\Column(type="integer")
     */
    private $yAxis;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $clueName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $clueImg;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     */
    private $sceneN;

    /**
     * @ORM\ManyToOne(targetEntity=Game::class, inversedBy="clue")
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

    public function getXAxis(): ?int
    {
        return $this->xAxis;
    }

    public function setXAxis(int $xAxis): self
    {
        $this->xAxis = $xAxis;

        return $this;
    }

    public function getYAxis(): ?int
    {
        return $this->yAxis;
    }

    public function setYAxis(int $yAxis): self
    {
        $this->yAxis = $yAxis;

        return $this;
    }

    public function getClueName(): ?string
    {
        return $this->clueName;
    }

    public function setClueName(string $clueName): self
    {
        $this->clueName = $clueName;

        return $this;
    }

    public function getClueImg(): ?string
    {
        return $this->clueImg;
    }

    public function setClueImg(string $clueImg): self
    {
        $this->clueImg = $clueImg;

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

    public function getSceneN(): ?int
    {
        return $this->sceneN;
    }

    public function setSceneN(int $sceneN): self
    {
        $this->sceneN = $sceneN;

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
