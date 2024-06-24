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
    use DateTimeTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank()]
    #[Assert\Length(max: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(max: 255)]
    #[Gedmo\Slug(fields: ['id', 'name'])]
    private ?string $slug = null;


    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank()]
    #[Assert\Length(max: 255)]
    private ?string $shortDescription = null;



    #[ORM\ManyToOne(inversedBy: 'programme')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Categorie $categorie = null;

    #[ORM\OneToMany(targetEntity: Commentaires::class, mappedBy: 'programme')]
    private Collection $commentaires;


    #[ORM\OneToMany(targetEntity: Exercices::class, mappedBy: 'programme', orphanRemoval: true, cascade: ['persist', 'remove'])]
    private Collection $exercices;

    #[ORM\ManyToOne(inversedBy: 'programme')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ProType $proType = null;

    #[ORM\OneToMany(targetEntity: Favoris::class, mappedBy: 'programme', orphanRemoval: true)]
    private Collection $favoris;

    #[ORM\Column(nullable: true)]
    private ?float $moyenne = null;

 

    public function __construct()
    {
        $this->commentaires = new ArrayCollection();
        $this->exercices = new ArrayCollection();
        $this->favoris = new ArrayCollection();
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

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): static
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * @return Collection<int, Commentaires>
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaires $commentaire): static
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires->add($commentaire);
            $commentaire->setProgramme($this);
            $this->setMoyenne();
        }

        return $this;
    }

    public function removeCommentaire(Commentaires $commentaire): static
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getProgramme() === $this) {
                $commentaire->setProgramme(null);
            }
            $this->setMoyenne();
        }

        return $this;
    }

    public function getMoyenne(): ?float
    {
        return $this->moyenne;
    }

    public function setMoyenne(): static
    {
        $totalNotes = 0;
        $nombreCommentaires = count($this->commentaires);

        foreach ($this->commentaires as $commentaire) {
            $totalNotes += $commentaire->getNote();
        }

        $this->moyenne = $nombreCommentaires > 0 ? $totalNotes / $nombreCommentaires : 0;

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
            $exercice->setProgramme($this);
        }

        return $this;
    }

    public function removeExercice(Exercices $exercice): static
    {
        if ($this->exercices->removeElement($exercice)) {
            // set the owning side to null (unless already changed)
            if ($exercice->getProgramme() === $this) {
                $exercice->setProgramme(null);
            }
        }

        return $this;
    }

    public function getProType(): ?ProType
    {
        return $this->proType;
    }

    public function setProType(?ProType $proType): static
    {
        $this->proType = $proType;

        return $this;
    }

    /**
     * @return Collection<int, Favoris>
     */
    public function getFavoris(): Collection
    {
        return $this->favoris;
    }

    public function addFavori(Favoris $favori): static
    {
        if (!$this->favoris->contains($favori)) {
            $this->favoris->add($favori);
            $favori->setProgramme($this);
        }

        return $this;
    }

    public function removeFavori(Favoris $favori): static
    {
        if ($this->favoris->removeElement($favori)) {
            // set the owning side to null (unless already changed)
            if ($favori->getProgramme() === $this) {
                $favori->setProgramme(null);
            }
        }

        return $this;
    }


    

}
