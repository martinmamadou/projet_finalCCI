<?php

namespace App\Entity;

use App\Repository\InfoProgrammeRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: InfoProgrammeRepository::class)]
class InfoProgramme
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'infoProgramme', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Programme $programme = null;

    #[ORM\Column(nullable: true)]
    private ?int $repetition = null;

    #[ORM\Column(nullable: true)]
    private ?int $temps = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length()]
    #[Assert\NotBlank()]
    private ?string $type = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProgramme(): ?Programme
    {
        return $this->programme;
    }

    public function setProgramme(Programme $programme): static
    {
        $this->programme = $programme;

        return $this;
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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }
}
