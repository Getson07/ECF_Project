<?php

namespace App\Controller;

use App\Entity\Administrator;
use App\Form\AdministratorType;
use App\Repository\AdministratorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/administrator')]
class AdministratorController extends AbstractController
{
    #[Route('/', name: 'app_administrator_index', methods: ['GET'])]
    public function index(AdministratorRepository $administratorRepository): Response
    {
        return $this->render('administrator/index.html.twig', [
            'administrators' => $administratorRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_administrator_new', methods: ['GET', 'POST'])]
    public function new(Request $request, AdministratorRepository $administratorRepository): Response
    {
        $administrator = new Administrator();
        $form = $this->createForm(AdministratorType::class, $administrator);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $administratorRepository->save($administrator, true);

            return $this->redirectToRoute('app_administrator_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('administrator/new.html.twig', [
            'administrator' => $administrator,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_administrator_show', methods: ['GET'])]
    public function show(Administrator $administrator): Response
    {
        return $this->render('administrator/show.html.twig', [
            'administrator' => $administrator,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_administrator_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Administrator $administrator, AdministratorRepository $administratorRepository): Response
    {
        $form = $this->createForm(AdministratorType::class, $administrator);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $administratorRepository->save($administrator, true);

            return $this->redirectToRoute('app_administrator_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('administrator/edit.html.twig', [
            'administrator' => $administrator,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_administrator_delete', methods: ['POST'])]
    public function delete(Request $request, Administrator $administrator, AdministratorRepository $administratorRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$administrator->getId(), $request->request->get('_token'))) {
            $administratorRepository->remove($administrator, true);
        }

        return $this->redirectToRoute('app_administrator_index', [], Response::HTTP_SEE_OTHER);
    }
}
