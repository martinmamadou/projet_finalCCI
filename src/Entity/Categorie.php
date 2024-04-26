<?php

namespace App\Entity;

use App\Entity\Traits\DateTimeTrait;
use App\Entity\Traits\EnableTrait;
use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Gedmo\Mapping\Annotation as Gedmo;

#[ORM\Entity(repositoryClass: CategorieRepository::class)]
#[UniqueEntity(fields: ['name'], message: 'ce nom est deja utilisé ')]
#[HasLifecycleCallbacks]
class Categorie
{
    use DateTimeTrait, EnableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank()]
    #[Assert\Length(max: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(targetEntity: Programme::class, mappedBy: 'categorie')]
    private Collection $programme;

    #[ORM\Column(length: 255)]
    #[Assert\Length(max: 255)]
    #[Gedmo\Slug(fields: ['id', 'name'])]
    private ?string $slug = null;

    public function __construct()
    {
        $this->programme = new ArrayCollection();
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

    /**
     * @return Collection<int, Programme>
     */
    public function getProgramme(): Collection
    {
        return $this->programme;
    }

    public function addProgramme(Programme $programme): static
    {
        if (!$this->programme->contains($programme)) {
            $this->programme->add($programme);
            $programme->setCategorie($this);
        }

        return $this;
    }

    public function removeProgramme(Programme $programme): static
    {
        if ($this->programme->removeElement($programme)) {
            // set the owning side to null (unless already changed)
            if ($programme->getCategorie() === $this) {
                $programme->setCategorie(null);
            }
        }

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
}
