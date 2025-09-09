<?php

namespace App\Entity;

use App\Repository\ListingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\User;
use App\Entity\PropertyType;
use App\Entity\TransactionType;

#[ORM\Entity(repositoryClass: ListingRepository::class)]
#[ORM\Table(name: "listing")]
class Listing
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    private ?int $price = null;

    #[ORM\Column(length: 150)]
    private ?string $city = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image_url = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updated_at = null;

    //  Relations ManyToOne
    #[ORM\ManyToOne(inversedBy: "listings")]
    #[ORM\JoinColumn(nullable: false)]
    private ?PropertyType $propertyType = null;

    #[ORM\ManyToOne(inversedBy: "listings")]
    #[ORM\JoinColumn(nullable: false)]
    private ?TransactionType $transactionType = null;

    #[ORM\ManyToOne(inversedBy: "listings")]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    // Relation ManyToMany inverse
    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: "favoriteListings")]
    private Collection $favoritedBy;

    public function __construct()
    {
        $this->favoritedBy = new ArrayCollection();
    }

    // 🔹 Getters / Setters
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }
    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }
    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }
    public function setPrice(int $price): self
    {
        $this->price = $price;
        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }
    public function setCity(string $city): self
    {
        $this->city = $city;
        return $this;
    }

    public function getImageUrl(): ?string
    {
        return $this->image_url;
    }
    public function setImageUrl(?string $image_url): self
    {
        $this->image_url = $image_url;
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }
    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;
        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }
    public function setUpdatedAt(\DateTimeImmutable $updated_at): self
    {
        $this->updated_at = $updated_at;
        return $this;
    }


    public function getPropertyType(): ?PropertyType
    {
        return $this->propertyType;
    }
    public function setPropertyType(?PropertyType $propertyType): self
    {
        $this->propertyType = $propertyType;
        return $this;
    }

    public function getTransactionType(): ?TransactionType
    {
        return $this->transactionType;
    }
    public function setTransactionType(?TransactionType $transactionType): self
    {
        $this->transactionType = $transactionType;
        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }
    public function setUser(?User $user): self
    {
        $this->user = $user;
        return $this;
    }

    /** @return Collection|User[] */
    public function getFavoritedBy(): Collection
    {
        return $this->favoritedBy;
    }

    public function addFavoritedBy(User $user): self
    {
        if (!$this->favoritedBy->contains($user)) {
            $this->favoritedBy->add($user);
            $user->addFavoriteListing($this);
        }
        return $this;
    }

    public function removeFavoritedBy(User $user): self
    {
        if ($this->favoritedBy->removeElement($user)) {
            $user->removeFavoriteListing($this);
        }
        return $this;
    }
}
