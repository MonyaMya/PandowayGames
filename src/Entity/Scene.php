<?php
namespace App\Entity;
use App\Repository\SceneRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
/**
 * @ORM\Entity(repositoryClass=SceneRepository::class)
 * @Vich\Uploadable
 */
class Scene
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /* _______________________________________*/

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="scene_image", fileNameProperty="imageName")
     *
     * @var File|null
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string")
     *
     * @var string|null
     */
    private $imageName;

    /* _______________________________________*/

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

    /**
     * @ORM\Column(type="integer")
     */
    private $position;
    public function getId(): ?int
    {
        return $this->id;
    }

    /* _______________________________________*/

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $imageFile
     */
    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    /* _______________________________________*/

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

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(int $position): self
    {
        $this->position = $position;

        return $this;
    }
}