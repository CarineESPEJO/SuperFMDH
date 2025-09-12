<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\Listing;
use App\Entity\Trait\TimestampableTrait;
use App\Entity\Interface\TimestampableInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: "user")]
#[ORM\HasLifecycleCallbacks]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface, TimestampableInterface
{
    use TimestampableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Assert\NotBlank]
    #[Assert\Email(message: 'The email {{ value }} is not a valid email.')]
    private ?string $email = null;

    #[ORM\Column(type: 'json')]
    private array $roles = [];

    #[ORM\Column(length: 255)]
    #[Assert\Regex(
        pattern: '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{9,}$/',
        message: "The password must contain at least 9 characters, one lowercase, one uppercase, one number, and one special character."
    )]
    private ?string $password = null;

    #[ORM\Column]
    private bool $isVerified = false;

    #[ORM\OneToMany(mappedBy: "user", targetEntity: Listing::class)]
    private Collection $listings;

    #[ORM\ManyToMany(targetEntity: Listing::class, inversedBy: "favoritedBy")]
    #[ORM\JoinTable(name: "favorite")]
    private Collection $favoriteListings;

    public function __construct()
    {
        $this->listings = new ArrayCollection();
        $this->favoriteListings = new ArrayCollection();
    }

    // 🔹 Security methods
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';
        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;
        return $this;
    }

    public function eraseCredentials(): void
    {
        // Clear sensitive temporary data if needed
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
    public function setEmail(string $email): static
    {
        $this->email = $email;
        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }
    public function setPassword(string $password): static
    {
        $this->password = $password;
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

    public function isVerified(): bool
    {
        return $this->isVerified;
    }
    public function setIsVerified(bool $isVerified): static
    {
        $this->isVerified = $isVerified;
        return $this;
    }
}
