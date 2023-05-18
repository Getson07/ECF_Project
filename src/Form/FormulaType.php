<?php

namespace App\Form;

use App\Entity\Formula;
use App\Repository\DishCategoryRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FormulaType extends AbstractType
{
    private array $categories;
    public function __construct(DishCategoryRepository $dishCategoryRepository)
    {
        $this->categories = $dishCategoryRepository->findAll();
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class)
            ->add('description', TextareaType::class, ['required' => false])
            ->add('price', NumberType::class)
            ->add('categories', ChoiceType::class, [
                'mapped' => false,
                'choices' => $this->getAllCategories(),
                'required' => true,
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('creator')
        ;
    }
    public function getAllCategories(): array
    {
        $allCategories = [];
        foreach($this->categories as $category){
            $allCategories[$category->getName()] = $category;
        }
        return $allCategories;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Formula::class,
        ]);
    }
}
