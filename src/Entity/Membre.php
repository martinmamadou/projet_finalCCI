<?php

namespace App\Entity;

use App\Repository\MembreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MembreRepository::class)]
class Membre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToMany(targetEntity: ExTemplate::class, inversedBy: 'membres')]
    private Collection $exTemplate;

    public function __construct()
    {
        $this->exTemplate = new ArrayCollection();
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
     * @return Collection<int, ExTemplate>
     */
    public function getExTemplate(): Collection
    {
        return $this->exTemplate;
    }

    public function addExTemplate(ExTemplate $exTemplate): static
    {
        if (!$this->exTemplate->contains($exTemplate)) {
            $this->exTemplate->add($exTemplate);
        }

        return $this;
    }

    public function removeExTemplate(ExTemplate $exTemplate): static
    {
        $this->exTemplate->removeElement($exTemplate);

        return $this;
    }
}
