<?php

namespace App\Entity\Interface;

interface TimestampableInterface
{
    public function getcreated_at(): ?\DateTimeImmutable;

    public function setcreated_at(): void;

    public function getupdated_at(): ?\DateTimeImmutable;

    public function setupdated_at(): void;
}
