<?php

namespace App\Entity;

use App\Entity\Traits\DateTimeTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
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

    #[ORM\OneToMany(targetEntity: Exercices::class, mappedBy: 'exercice', orphanRemoval: true)]
    private Collection $exercices;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $gifurl = null;


    #[ORM\Column(type: Types::TEXT)]
    private ?string $instruction = null;

    #[ORM\ManyToMany(targetEntity: Membre::class, mappedBy: 'exTemplate')]
    private Collection $membres;

    public function __construct()
    {
        $this->membres = new ArrayCollection();
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

    public function getGifurl(): ?string
    {
        return $this->gifurl;
    }

    public function setGifurl(?string $gifurl): static
    {
        $this->gifurl = $gifurl;

        return $this;
    }

  
    public function getInstruction(): ?string
    {
        return $this->instruction;
    }

    public function setInstruction(string $instruction): static
    {
        $this->instruction = $instruction;

        return $this;
    }

    /**
     * @return Collection<int, Membre>
     */
    public function getMembres(): Collection
    {
        return $this->membres;
    }

    public function addMembre(Membre $membre): static
    {
        if (!$this->membres->contains($membre)) {
            $this->membres->add($membre);
            $membre->addExTemplate($this);
        }

        return $this;
    }

    public function removeMembre(Membre $membre): static
    {
        if ($this->membres->removeElement($membre)) {
            $membre->removeExTemplate($this);
        }

        return $this;
    }


 
}
