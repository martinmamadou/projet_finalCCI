<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\EnableTrait;
use App\Entity\Traits\DateTimeTrait;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\Collection;
use App\Repository\ExerciceMaisonRepository;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ExerciceMaisonRepository::class)]
#[UniqueEntity(fields: ['name'], message: 'ce nom est deja utilisé ')]
#[HasLifecycleCallbacks]
class ExerciceMaison
{
    use DateTimeTrait, EnableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(max:255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Gedmo\Slug(fields:['id','name'])]
    private ?string $slug = null;

    #[ORM\ManyToMany(targetEntity: ProgrammeMaison::class, inversedBy: 'exerciceMaisons')]
    private Collection $progMaison;

    public function __construct()
    {
        $this->progMaison = new ArrayCollection();
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

    /**
     * @return Collection<int, ProgrammeMaison>
     */
    public function getProgMaison(): Collection
    {
        return $this->progMaison;
    }

    public function addProgMaison(ProgrammeMaison $progMaison): static
    {
        if (!$this->progMaison->contains($progMaison)) {
            $this->progMaison->add($progMaison);
        }

        return $this;
    }

    public function removeProgMaison(ProgrammeMaison $progMaison): static
    {
        $this->progMaison->removeElement($progMaison);

        return $this;
    }
}
