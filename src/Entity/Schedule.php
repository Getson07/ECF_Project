<?php

namespace App\Entity;

use App\Repository\ScheduleRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ScheduleRepository::class)]
class Schedule
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $day = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $openingTime = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $closingTime = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $breakStartTime = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $breakEndTime = null;

    #[ORM\ManyToOne(inversedBy: 'schedules')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Administrator $admin = null;

    public function __construct(Schedule $schedule = null )
    {
        if($schedule !== null){
            $this->id = null;
            $this->setDay($schedule->getDay());
            $this->setOpeningTime($schedule->getOpeningTime());
            $this->setClosingTime($schedule->getClosingTime());
            $this->setBreakStartTime($schedule->getBreakStartTime());
            $this->setBreakEndTime($schedule->getBreakEndTime());
            $this->setAdmin($schedule->getAdmin());
        }
    }
    public function getId(): ?int
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;
    }

    public function getDay(): ?string
    {
        return $this->day;
    }

    public function setDay(string $day): self
    {
        $this->day = $day;

        return $this;
    }

    public function getOpeningTime(): ?\DateTimeInterface
    {
        return $this->openingTime;
    }

    public function setOpeningTime(\DateTimeInterface $openingTime): self
    {
        $this->openingTime = $openingTime;

        return $this;
    }

    public function getClosingTime(): ?\DateTimeInterface
    {
        return $this->closingTime;
    }

    public function setClosingTime(\DateTimeInterface $closingTime): self
    {
        $this->closingTime = $closingTime;

        return $this;
    }

    public function getBreakStartTime(): ?\DateTimeInterface
    {
        return $this->breakStartTime;
    }

    public function setBreakStartTime(\DateTimeInterface $breakStartTime): self
    {
        $this->breakStartTime = $breakStartTime;

        return $this;
    }

    public function getBreakEndTime(): ?\DateTimeInterface
    {
        return $this->breakEndTime;
    }

    public function setBreakEndTime(\DateTimeInterface $breakEndTime): self
    {
        $this->breakEndTime = $breakEndTime;

        return $this;
    }

    public function getAdmin(): ?Administrator
    {
        return $this->admin;
    }

    public function setAdmin(?Administrator $admin): self
    {
        $this->admin = $admin;

        return $this;
    }
}
