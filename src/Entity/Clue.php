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
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $letterPosition;

    /**
     * @ORM\Column(type="integer")
     */
    private $intPosition;

    /**
     * @ORM\OneToOne(targetEntity=Scene::class, inversedBy="clue", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $scene;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getLetterPosition(): ?string
    {
        return $this->letterPosition;
    }

    public function setLetterPosition(string $letterPosition): self
    {
        $this->letterPosition = $letterPosition;

        return $this;
    }

    public function getIntPosition(): ?int
    {
        return $this->intPosition;
    }

    public function setIntPosition(int $intPosition): self
    {
        $this->intPosition = $intPosition;

        return $this;
    }

    public function getScene(): ?Scene
    {
        return $this->scene;
    }

    public function setScene(Scene $scene): self
    {
        $this->scene = $scene;

        return $this;
    }
}
