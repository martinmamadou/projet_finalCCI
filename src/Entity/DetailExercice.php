<?php

namespace App\Entity;

use App\Repository\DetailExerciceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DetailExerciceRepository::class)]
class DetailExercice
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $repetition = null;

    #[ORM\Column(nullable: true)]
    private ?int $temps = null;

    #[ORM\ManyToMany(targetEntity: Exercices::class, inversedBy: 'detailExercices')]
    private Collection $exercice;

    public function __construct()
    {
        $this->exercice = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRepetition(): ?int
    {
        return $this->repetition;
    }

    public function setRepetition(?int $repetition): static
    {
        $this->repetition = $repetition;

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

    /**
     * @return Collection<int, Exercices>
     */
    public function getExercice(): Collection
    {
        return $this->exercice;
    }

    public function addExercice(Exercices $exercice): static
    {
        if (!$this->exercice->contains($exercice)) {
            $this->exercice->add($exercice);
        }

        return $this;
    }

    public function removeExercice(Exercices $exercice): static
    {
        $this->exercice->removeElement($exercice);

        return $this;
    }
}
