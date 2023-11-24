<?php

namespace App\Entity;

use App\Traits\DateTrait;
use App\Entity\Distributeurs;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProduitsRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\HasLifecycleCallbacks]

#[ORM\Entity(repositoryClass: ProduitsRepository::class)]

class Produits
{
    use DateTrait;


    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column]
    private ?float $prix = null;


    #[ORM\OneToOne(inversedBy: 'produits', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?References $reference = null;

    #[ORM\ManyToOne(inversedBy: 'produits')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Categories $Categorie = null;

    #[ORM\ManyToMany(targetEntity: Distributeurs::class, inversedBy: 'produits')]
    private Collection $distributeur;

    // #[ORM\Column(length: 255)]
    // private ?string $image = null;

    #[ORM\OneToMany(mappedBy: 'produits', targetEntity: Photos::class, cascade:['persist'])]
    private Collection $photos;

   
    public function __construct()
    {
        $this->distributeur = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
        $this->photos = new ArrayCollection();    
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function getReference(): ?References
    {
        return $this->reference;
    }

    public function setReference(References $reference): static
    {
        $this->reference = $reference;

        return $this;
    }

    public function getCategorie(): ?Categories
    {
        return $this->Categorie;
    }

    public function setCategorie(?Categories $Categorie): static
    {
        $this->Categorie = $Categorie;

        return $this;
    }

    /**
     * @return Collection<int, Distributeurs>
     */
    public function getDistributeur(): Collection
    {
        return $this->distributeur;
    }

    public function addDistributeur(Distributeurs $distributeur): static
    {
        if (!$this->distributeur->contains($distributeur)) {
            $this->distributeur->add($distributeur);
        }

        return $this;
    }

    public function removeDistributeur(Distributeurs $distributeur): static
    {
        $this->distributeur->removeElement($distributeur);

        return $this;
    }

    // public function getImage(): ?string
    // {
    //     return $this->image;
    // }

    // public function setImage(string $image): static
    // {
    //     $this->image = $image;

    //     return $this;
    // }

    /**
     * @return Collection<int, photos>
     */
    public function getPhotos(): Collection
    {
        return $this->photos;
    }

    public function addPhoto(photos $photo): static
    {
        if (!$this->photos->contains($photo)) {
            $this->photos->add($photo);
            $photo->setProduits($this);
        }

        return $this;
    }

    public function removePhoto(photos $photo): static
    {
        if ($this->photos->removeElement($photo)) {
            // set the owning side to null (unless already changed)
            if ($photo->getProduits() === $this) {
                $photo->setProduits(null);
            }
        }

        return $this;
    }




}
