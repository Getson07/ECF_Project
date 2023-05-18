<?php

namespace App\Entity;

use App\Repository\CategoryFormulaRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryFormulaRepository::class)]
class CategoryFormula
{ 
    #[ORM\Id]
    #[ORM\ManyToOne(inversedBy: 'categoryFormulas')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Formula $formula = null;

    #[ORM\Id]
    #[ORM\ManyToOne(inversedBy: 'categoryFormulas')]
    #[ORM\JoinColumn(nullable: false)]
    private ?DishCategory $category = null;

    public function __construct(DishCategory $category, Formula $formula)
    {
    	$this->category = $category;
        $this->formula = $formula;
    }
    public function getFormula(): ?Formula
    {
        return $this->formula;
    }

    public function setFormula(?Formula $formula): self
    {
        $this->formula = $formula;

        return $this;
    }

    public function getCategory(): ?DishCategory
    {
        return $this->category;
    }

    public function setCategory(?DishCategory $category): self
    {
        $this->category = $category;

        return $this;
    }
}
