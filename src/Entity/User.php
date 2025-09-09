<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Listing;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: "user")]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updated_at = null;

    // Relation OneToMany avec Listing
    #[ORM\OneToMany(mappedBy: "user", targetEntity: Listing::class)]
    private Collection $listings;

    //  Relation ManyToMany pour les favoris (côté propriétaire)
    #[ORM\ManyToMany(targetEntity: Listing::class, inversedBy: "favoritedBy")]
    #[ORM\JoinTable(name: "favorite")]
    private Collection $favoriteListings;

    public function __construct()
    {
        $this->listings = new ArrayCollection();
        $this->favoriteListings = new ArrayCollection();
    }

    // 🔹 Getters / Setters
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }
    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }
    public function setPassword(string $password): self
    {
        $this->password = $password;
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

    /** @return Collection|Listing[] */
    public function getListings(): Collection
    {
        return $this->listings;
    }

    /** @return Collection|Listing[] */
    public function getFavoriteListings(): Collection
    {
        return $this->favoriteListings;
    }

    public function addFavoriteListing(Listing $listing): self
    {
        if (!$this->favoriteListings->contains($listing)) {
            $this->favoriteListings->add($listing);
            $listing->addFavoritedBy($this);
        }
        return $this;
    }

    public function removeFavoriteListing(Listing $listing): self
    {
        if ($this->favoriteListings->removeElement($listing)) {
            $listing->removeFavoritedBy($this);
        }
        return $this;
    }
}
