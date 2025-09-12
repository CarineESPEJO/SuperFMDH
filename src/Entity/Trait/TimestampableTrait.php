<?php

namespace App\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;

trait TimestampableTrait
{
    #[ORM\Column(name: "created_at", type: "datetime_immutable")]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(name: "updated_at", type: "datetime_immutable")]
    private ?\DateTimeImmutable $updated_at = null;

    public function getcreated_at(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    #[ORM\PrePersist]
    public function setcreated_at(): void
    {
        $this->created_at = new \DateTimeImmutable();
    }

    public function getupdated_at(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    #[ORM\PreUpdate]
    #[ORM\PrePersist]
    public function setupdated_at(): void
    {
        $this->updated_at = new \DateTimeImmutable();
    }
}
