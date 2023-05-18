<?php

namespace App\Controller;

use App\Entity\CategoryFormula;
use App\Entity\Formula;
use App\Form\FormulaType;
use App\Repository\CategoryFormulaRepository;
use App\Repository\FormulaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/formula')]
class FormulaController extends AbstractController
{
    #[Route('/', name: 'app_formula_index', methods: ['GET'])]
    public function index(FormulaRepository $formulaRepository): Response
    {
        return $this->render('formula/index.html.twig', [
            'formulas' => $formulaRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_formula_new', methods: ['GET', 'POST'])]
    public function new(Request $request, FormulaRepository $formulaRepository, CategoryFormulaRepository $categoryFormulaRepository): Response
    {
        $formula = new Formula();
        $form = $this->createForm(FormulaType::class, $formula);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->fullFillAssociative($form['categories']->getData(), $formula, $categoryFormulaRepository);
            $formulaRepository->save($formula, true);

            return $this->redirectToRoute('app_formula_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('formula/new.html.twig', [
            'formula' => $formula,
            'form' => $form,
        ]);
    }
    public function fullFillAssociative(array $categories, Formula $formula, CategoryFormulaRepository $categoryFormulaRepository, $new = true){
        $outCategories = [];
        $formulaCategories = [];
        $toDelete = [] ;
        if(!$new){
            foreach($formula->getCategoryFormulas()->toArray() as $categoryFormula){
                $formulaCategories[] = $categoryFormula->getCategory();
            }
            foreach($categories as $category){
                    if(!in_array($category, $formulaCategories))
                        $outCategories[] = $category;
            }
            $toDelete = array_diff($formulaCategories, $categories);//Supprimer les catégories préexistantes et décocher
            foreach($toDelete as $category){
                $formulaToDelete = $categoryFormulaRepository->findOneBy(['formula' => $formula, 'category' => $category]);
                $formulaToDelete == null ?: $categoryFormulaRepository->remove($formulaToDelete, true);
            }
        }
       
        foreach($outCategories as $category){
            $formulaCategory = new CategoryFormula($category, $formula);
            $categoryFormulaRepository->save($formulaCategory, true);
        }
    }

    #[Route('/{id}', name: 'app_formula_show', methods: ['GET'])]
    public function show(Formula $formula): Response
    {
        return $this->render('formula/show.html.twig', [
            'formula' => $formula,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_formula_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Formula $formula, FormulaRepository $formulaRepository, CategoryFormulaRepository $categoryFormulaRepository): Response
    {
        $form = $this->createForm(FormulaType::class, $formula);
        //Pour auto remplir les checkbox categories
        $formulaCategories = [];
        foreach($formula->getCategoryFormulas()->toArray() as $categoryFormula){
            $formulaCategories[] = $categoryFormula->getCategory();
        }
        $form['categories']->setData($formulaCategories);
        //Fin auto remplissage
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->fullFillAssociative($form['categories']->getData(), $formula, $categoryFormulaRepository, false);
            $formulaRepository->save($formula, true);

            return $this->redirectToRoute('app_formula_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('formula/edit.html.twig', [
            'formula' => $formula,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_formula_delete', methods: ['POST'])]
    public function delete(Request $request, Formula $formula, FormulaRepository $formulaRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$formula->getId(), $request->request->get('_token'))) {
            $formulaRepository->remove($formula, true);
        }

        return $this->redirectToRoute('app_formula_index', [], Response::HTTP_SEE_OTHER);
    }
}
