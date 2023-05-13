<?php

namespace App\Entity;

use App\Repository\AdministratorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AdministratorRepository::class)]
class Administrator extends User
{
    
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $salary = null;

    #[ORM\OneToMany(mappedBy: 'admin', targetEntity: Schedule::class)]
    private Collection $schedules;

    #[ORM\OneToMany(mappedBy: 'creator', targetEntity: Dish::class)]
    private Collection $dishes;

    #[ORM\OneToMany(mappedBy: 'creator', targetEntity: DishCategory::class)]
    private Collection $dishCategories;

    #[ORM\OneToMany(mappedBy: 'creator', targetEntity: Formula::class)]
    private Collection $formulas;

    public function __construct()
    {
        $this->schedules = new ArrayCollection();
        $this->dishes = new ArrayCollection();
        $this->dishCategories = new ArrayCollection();
        $this->formulas = new ArrayCollection();
    }


    public function getSalary(): ?string
    {
        return $this->salary;
    }

    public function setSalary(?string $salary): self
    {
        $this->salary = $salary;

        return $this;
    }

    /**
     * @return Collection<int, Schedule>
     */
    public function getSchedules(): Collection
    {
        return $this->schedules;
    }

    public function addSchedule(Schedule $schedule): self
    {
        if (!$this->schedules->contains($schedule)) {
            $this->schedules->add($schedule);
            $schedule->setAdmin($this);
        }

        return $this;
    }

    public function removeSchedule(Schedule $schedule): self
    {
        if ($this->schedules->removeElement($schedule)) {
            // set the owning side to null (unless already changed)
            if ($schedule->getAdmin() === $this) {
                $schedule->setAdmin(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Dish>
     */
    public function getDishes(): Collection
    {
        return $this->dishes;
    }

    public function addDish(Dish $dish): self
    {
        if (!$this->dishes->contains($dish)) {
            $this->dishes->add($dish);
            $dish->setCreator($this);
        }

        return $this;
    }

    public function removeDish(Dish $dish): self
    {
        if ($this->dishes->removeElement($dish)) {
            // set the owning side to null (unless already changed)
            if ($dish->getCreator() === $this) {
                $dish->setCreator(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, DishCategory>
     */
    public function getDishCategories(): Collection
    {
        return $this->dishCategories;
    }

    public function addDishCategory(DishCategory $dishCategory): self
    {
        if (!$this->dishCategories->contains($dishCategory)) {
            $this->dishCategories->add($dishCategory);
            $dishCategory->setCreator($this);
        }

        return $this;
    }

    public function removeDishCategory(DishCategory $dishCategory): self
    {
        if ($this->dishCategories->removeElement($dishCategory)) {
            // set the owning side to null (unless already changed)
            if ($dishCategory->getCreator() === $this) {
                $dishCategory->setCreator(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Formula>
     */
    public function getFormulas(): Collection
    {
        return $this->formulas;
    }

    public function addFormula(Formula $formula): self
    {
        if (!$this->formulas->contains($formula)) {
            $this->formulas->add($formula);
            $formula->setCreator($this);
        }

        return $this;
    }

    public function removeFormula(Formula $formula): self
    {
        if ($this->formulas->removeElement($formula)) {
            // set the owning side to null (unless already changed)
            if ($formula->getCreator() === $this) {
                $formula->setCreator(null);
            }
        }

        return $this;
    }
}
