<?php

namespace App\Entity;

use App\Repository\ListingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\User;
use App\Entity\PropertyType;
use App\Entity\TransactionType;
use App\Entity\Trait\TimestampableTrait;
use App\Entity\Interface\TimestampableInterface;

#[ORM\Entity(repositoryClass: ListingRepository::class)]
#[ORM\Table(name: "listing")]
#[ORM\HasLifecycleCallbacks]
class Listing implements TimestampableInterface
{
    use TimestampableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 5, max: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 50, max: 1000)]
    private ?string $description = null;

    #[ORM\Column(type: "decimal", precision: 10, scale: 2)]
    #[Assert\NotBlank]
    #[Assert\Positive]
    private ?float $price = null;

    #[ORM\Column(length: 150)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 1, max: 150)]
    private ?string $city = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image_url = null;

    // 🔹 Relations
    #[ORM\ManyToOne(inversedBy: "listings")]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull(message: "Property type must be set.")]
    private ?PropertyType $propertyType = null;

    #[ORM\ManyToOne(inversedBy: "listings")]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull(message: "Transaction type must be set.")]
    private ?TransactionType $transactionType = null;

    #[ORM\ManyToOne(inversedBy: "listings")]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull(message: "User must be set.")]
    private ?User $user = null;

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
    public function getPrice(): ?float
    {
        return $this->price;
    }
    public function setPrice(float $price): self
    {
        $this->price = round($price, 2);
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
