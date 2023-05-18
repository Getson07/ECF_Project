<?php

namespace App\Entity;

use App\Repository\DishCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DishCategoryRepository::class)]
class DishCategory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: Dish::class)]
    private Collection $dishes;

    #[ORM\ManyToOne(inversedBy: 'dishCategories')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Administrator $creator = null;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: CategoryFormula::class)]
    private Collection $categoryFormulas;

    public function __construct()
    {
        $this->dishes = new ArrayCollection();
        $this->categoryFormulas = new ArrayCollection();
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
            $dish->setCategory($this);
        }

        return $this;
    }

    public function removeDish(Dish $dish): self
    {
        if ($this->dishes->removeElement($dish)) {
            // set the owning side to null (unless already changed)
            if ($dish->getCategory() === $this) {
                $dish->setCategory(null);
            }
        }

        return $this;
    }

    
    public function getCreator(): ?Administrator
    {
        return $this->creator;
    }

    public function setCreator(?Administrator $creator): self
    {
        $this->creator = $creator;

        return $this;
    }
    public function __toString()
    {
        return $this->getName();
    }

    /**
     * @return Collection<int, CategoryFormula>
     */
    public function getCategoryFormulas(): Collection
    {
        return $this->categoryFormulas;
    }

    public function addCategoryFormula(CategoryFormula $categoryFormula): self
    {
        if (!$this->categoryFormulas->contains($categoryFormula)) {
            $this->categoryFormulas->add($categoryFormula);
            $categoryFormula->setCategory($this);
        }

        return $this;
    }

    public function removeCategoryFormula(CategoryFormula $categoryFormula): self
    {
        if ($this->categoryFormulas->removeElement($categoryFormula)) {
            // set the owning side to null (unless already changed)
            if ($categoryFormula->getCategory() === $this) {
                $categoryFormula->setCategory(null);
            }
        }

        return $this;
    }
}
