<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\EnableTrait;
use App\Entity\Traits\DateTimeTrait;
use App\Repository\ExercicesRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Gedmo\Mapping\Annotation as Gedmo;
use PhpParser\Node\Name;

#[ORM\Entity(repositoryClass: ExercicesRepository::class)]
#[UniqueEntity(fields: ['name'], message: 'ce nom est deja utilisé ')]
#[HasLifecycleCallbacks]
class Exercices
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

    #[ORM\ManyToMany(targetEntity: Programme::class, inversedBy: 'exercices')]
    private Collection $programme;



    #[ORM\Column(nullable: true)]
    private ?int $repetitions = null;

    #[ORM\Column(nullable: true)]
    private ?int $serie = null;

    #[ORM\Column(nullable: true)]
    private ?int $temps = null;


 

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
    
    public function __toString()
    {
        return $this->name;
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
        }

        return $this;
    }

    public function removeProgramme(Programme $programme): static
    {
        $this->programme->removeElement($programme);

        return $this;
    }

 
 

    public function getRepetitions(): ?int
    {
        return $this->repetitions;
    }

    public function setRepetitions(?int $repetitions): static
    {
        $this->repetitions = $repetitions;

        return $this;
    }

    public function getSerie(): ?int
    {
        return $this->serie;
    }

    public function setSerie(?int $serie): static
    {
        $this->serie = $serie;

        return $this;
    }

    public function getTemps(): ?int
    {
        return $this->temps;
    }

    public function setTemps(?int $temps): static
    {
        $this->temps = $temps;

        return $this;
    }

}
