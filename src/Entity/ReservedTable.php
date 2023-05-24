<?php

namespace App\Entity;

use App\Repository\ReservedTableRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReservedTableRepository::class)]
class ReservedTable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'reservedTables')]
    private ?Client $client = null;

    #[ORM\ManyToOne(inversedBy: 'reservedTables')]
    private ?User $guestInfo = null;

    #[ORM\Column]
    private ?int $numberOfTables = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $reservedAt = null;

    #[ORM\Column()]
    private ?\DateTimeImmutable $reservedFor = null;

    #[ORM\Column]
    private ?bool $hasArrived = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $reservedForDate = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getGuestInfo(): ?User
    {
        return $this->guestInfo;
    }

    public function setGuestInfo(?User $guestInfo): self
    {
        $this->guestInfo = $guestInfo;

        return $this;
    }

    public function getNumberOfTables(): ?int
    {
        return $this->numberOfTables;
    }

    public function setNumberOfTables(int $numberOfTables): self
    {
        $this->numberOfTables = $numberOfTables;

        return $this;
    }

    public function getReservedAt(): ?\DateTimeImmutable
    {
        return $this->reservedAt;
    }

    public function setReservedAt(\DateTimeImmutable $reservedAt): self
    {
        $this->reservedAt = $reservedAt;

        return $this;
    }

    public function getReservedFor(): ?\DateTimeImmutable
    {
        return $this->reservedFor;
    }

    public function setReservedFor(\DateTimeImmutable $reservedFor): self
    {
        $this->reservedFor = $reservedFor;

        return $this;
    }

    public function isHasArrived(): ?bool
    {
        return $this->hasArrived;
    }

    public function setHasArrived(bool $hasArrived): self
    {
        $this->hasArrived = $hasArrived;

        return $this;
    }

    public function getReservedForDate(): ?\DateTimeImmutable
    {
        return $this->reservedForDate;
    }

    public function setReservedForDate(\DateTimeImmutable $reservedForDate): self
    {
        $this->reservedForDate = $reservedForDate;

        return $this;
    }
}
