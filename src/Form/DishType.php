<?php

namespace App\Form;

use App\Entity\Dish;
use App\Entity\DishCategory;
use App\Repository\DishCategoryRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;

use function PHPSTORM_META\map;

class DishType extends AbstractType
{
    private array $categories;
    public function __construct(DishCategoryRepository $dishCategoryRepository)
    {
        $this->categories = $dishCategoryRepository->findAll();
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // dd($this->categoryRepository->findAll());
        $builder
            ->add('title', TextType::class, ['required' => true])
            ->add('imageFile', FileType::class, ['required' => true, 'constraints' => new Image(), 'mapped' => false])
            ->add('description', TextareaType::class, ['required' => false])
            ->add('price', NumberType::class, ['required' => true])
            ->add('rating', NumberType::class, ['required' => false])
            ->add('category', ChoiceType::class, [
                'choices' => $this->getAllCategories(),
                'required' => true
            ])
            ->add('creator', TextType::class, [
                'required' => true,
                'disabled' => true,
            ])
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
            'data_class' => Dish::class,
        ]);
    }
}
