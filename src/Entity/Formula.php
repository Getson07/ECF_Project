<?php

namespace App\Entity;

use App\Repository\FormulaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FormulaRepository::class)]
class Formula
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 5, scale: 2)]
    private ?string $price = null;

    #[ORM\ManyToOne(inversedBy: 'formulas')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Administrator $creator = null;

    #[ORM\OneToMany(mappedBy: 'formula', targetEntity: CategoryFormula::class)]
    private Collection $categoryFormulas;

    public function __construct()
    {
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

    

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

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
            $categoryFormula->setFormula($this);
        }

        return $this;
    }

    public function removeCategoryFormula(CategoryFormula $categoryFormula): self
    {
        if ($this->categoryFormulas->removeElement($categoryFormula)) {
            // set the owning side to null (unless already changed)
            if ($categoryFormula->getFormula() === $this) {
                $categoryFormula->setFormula(null);
            }
        }

        return $this;
    }
}
