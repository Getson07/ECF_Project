<?php

namespace App\Controller;

use App\Entity\DishCategory;
use App\Form\DishCategoryType;
use App\Repository\DishCategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/dish/category')]
class DishCategoryController extends AbstractController
{
    #[Route('/', name: 'app_dish_category_index', methods: ['GET'])]
    public function index(DishCategoryRepository $dishCategoryRepository): Response
    {
        return $this->render('dish_category/index.html.twig', [
            'dish_categories' => $dishCategoryRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_dish_category_new', methods: ['GET', 'POST'])]
    public function new(Request $request, DishCategoryRepository $dishCategoryRepository): Response
    {
        $dishCategory = new DishCategory();
        $form = $this->createForm(DishCategoryType::class, $dishCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dishCategoryRepository->save($dishCategory, true);

            return $this->redirectToRoute('app_dish_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('dish_category/new.html.twig', [
            'dish_category' => $dishCategory,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_dish_category_show', methods: ['GET'])]
    public function show(DishCategory $dishCategory): Response
    {
        return $this->render('dish_category/show.html.twig', [
            'dish_category' => $dishCategory,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_dish_category_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, DishCategory $dishCategory, DishCategoryRepository $dishCategoryRepository): Response
    {
        $form = $this->createForm(DishCategoryType::class, $dishCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dishCategoryRepository->save($dishCategory, true);

            return $this->redirectToRoute('app_dish_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('dish_category/edit.html.twig', [
            'dish_category' => $dishCategory,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_dish_category_delete', methods: ['POST'])]
    public function delete(Request $request, DishCategory $dishCategory, DishCategoryRepository $dishCategoryRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$dishCategory->getId(), $request->request->get('_token'))) {
            $dishCategoryRepository->remove($dishCategory, true);
        }

        return $this->redirectToRoute('app_dish_category_index', [], Response::HTTP_SEE_OTHER);
    }
}
