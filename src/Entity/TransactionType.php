<?php

namespace App\Entity;

use App\Repository\TransactionTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Listing;
use App\Entity\Trait\TimestampableTrait;
use App\Entity\Interface\TimestampableInterface;

#[ORM\Entity(repositoryClass: TransactionTypeRepository::class)]
#[ORM\Table(name: "transactionType")]
#[ORM\HasLifecycleCallbacks]
class TransactionType implements TimestampableInterface
{
    use TimestampableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100, unique: true)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: "transactionType", targetEntity: Listing::class)]
    private Collection $listings;

    public function __construct()
    {
        $this->listings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /** @return Collection|Listing[] */
    public function getListings(): Collection
    {
        return $this->listings;
    }
}
