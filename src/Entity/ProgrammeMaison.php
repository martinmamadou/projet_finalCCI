<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\EnableTrait;
use App\Entity\Traits\DateTimeTrait;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\Collection;
use App\Repository\ProgrammeMaisonRepository;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProgrammeMaisonRepository::class)]
#[UniqueEntity(fields: ['name'], message: 'ce nom est deja utilisé ')]
#[HasLifecycleCallbacks]
class ProgrammeMaison
{
    use DateTimeTrait, EnableTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank()]
    #[Assert\Length(max:255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Gedmo\Slug(fields:['id','name'])]
    private ?string $slug = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank()]
    #[Assert\Length(max:255)]
    private ?string $shortDescription = null;

    #[ORM\ManyToMany(targetEntity: ExerciceMaison::class, mappedBy: 'progMaison')]
    private Collection $exerciceMaisons;

    public function __construct()
    {
        $this->exerciceMaisons = new ArrayCollection();
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

    public function getShortDescription(): ?string
    {
        return $this->shortDescription;
    }

    public function setShortDescription(string $shortDescription): static
    {
        $this->shortDescription = $shortDescription;

        return $this;
    }

    /**
     * @return Collection<int, ExerciceMaison>
     */
    public function getExerciceMaisons(): Collection
    {
        return $this->exerciceMaisons;
    }

    public function addExerciceMaison(ExerciceMaison $exerciceMaison): static
    {
        if (!$this->exerciceMaisons->contains($exerciceMaison)) {
            $this->exerciceMaisons->add($exerciceMaison);
            $exerciceMaison->addProgMaison($this);
        }

        return $this;
    }

    public function removeExerciceMaison(ExerciceMaison $exerciceMaison): static
    {
        if ($this->exerciceMaisons->removeElement($exerciceMaison)) {
            $exerciceMaison->removeProgMaison($this);
        }

        return $this;
    }
}
