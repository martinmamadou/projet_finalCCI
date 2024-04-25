<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\EnableTrait;
use App\Entity\Traits\DateTimeTrait;
use App\Repository\ProgrammeRepository;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Gedmo\Mapping\Annotation as Gedmo;

#[ORM\Entity(repositoryClass: ProgrammeRepository::class)]
#[UniqueEntity(fields: ['name'], message: 'ce nom est deja utilisé ')]
#[HasLifecycleCallbacks]
class Programme
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
    #[Assert\Length(max:255)]
    #[Gedmo\Slug(fields: ['id', 'name'])]
    private ?string $slug = null;

    
    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank()]
    #[Assert\Length(max:255)]
    private ?string $shortDescription = null;

    #[ORM\ManyToMany(targetEntity: Exercices::class, mappedBy: 'programme')]
    private Collection $exercices;

    #[ORM\ManyToOne(inversedBy: 'programme')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Categorie $categorie = null;

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

    public function getShortDescription(): ?string
    {
        return $this->shortDescription;
    }

    public function setShortDescription(?string $shortDescription): static
    {
        $this->shortDescription = $shortDescription;

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
            $exercice->addProgramme($this);
        }

        return $this;
    }

    public function removeExercice(Exercices $exercice): static
    {
        if ($this->exercices->removeElement($exercice)) {
            $exercice->removeProgramme($this);
        }

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): static
    {
        $this->categorie = $categorie;

        return $this;
    }
}
