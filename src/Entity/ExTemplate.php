<?php

namespace App\Entity;

use App\Entity\Traits\DateTimeTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ExTemplateRepository;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ExTemplateRepository::class)]
#[HasLifecycleCallbacks]
class ExTemplate
{
    use DateTimeTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank()]
    #[Assert\Length(max:255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(max:255)]
    #[Gedmo\Slug(fields: ['id', 'name'])]
    private ?string $slug = null;

    #[Assert\NotBlank()]
    #[Assert\Length(max:255)]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $shortDes = null;

    #[ORM\OneToMany(targetEntity: Exercices::class, mappedBy: 'exercice', orphanRemoval: true)]
    private Collection $exercices;

    public function __construct()
    {
        $this->exercices = new ArrayCollection();
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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function getShortDes(): ?string
    {
        return $this->shortDes;
    }

    public function setShortDes(?string $shortDes): static
    {
        $this->shortDes = $shortDes;

        return $this;
    }

    /**
     * @return Collection<int, Exercices>
     */
    public function getExercices(): Collection
    {
        return $this->exercices;
    }

    public function addExercice(Exercices $exercice): static
    {
        if (!$this->exercices->contains($exercice)) {
            $this->exercices->add($exercice);
            $exercice->setExercice($this);
        }

        return $this;
    }

    public function removeExercice(Exercices $exercice): static
    {
        if ($this->exercices->removeElement($exercice)) {
            // set the owning side to null (unless already changed)
            if ($exercice->getExercice() === $this) {
                $exercice->setExercice(null);
            }
        }

        return $this;
    }
}
