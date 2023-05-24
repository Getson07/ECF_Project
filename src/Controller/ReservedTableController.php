<?php

namespace App\Controller;
date_default_timezone_set('Europe/Paris');


use App\Entity\ReservedTable;
use App\Entity\User;
use App\Form\ReservedTableType;
use App\Repository\ReservedTableRepository;
use App\Repository\UserRepository;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/reserved/table')]
class ReservedTableController extends AbstractController
{
    #[Route('/', name: 'app_reserved_table_index', methods: ['GET'])]
    public function index(ReservedTableRepository $reservedTableRepository): Response
    {
        return $this->render('reserved_table/index.html.twig', [
            'reserved_tables' => $reservedTableRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_reserved_table_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ReservedTableRepository $reservedTableRepository, UserRepository $userRepository): Response
    {
        $reservedTable = new ReservedTable();
        $form = $this->createForm(ReservedTableType::class, $reservedTable);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->updateReservedTable($reservedTable, $userRepository, $form);
            $reservedTableRepository->save($reservedTable, true);

            return $this->redirectToRoute('app_reserved_table_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reserved_table/new.html.twig', [
            'reserved_table' => $reservedTable,
            'form' => $form,
        ]);
    }
    public function updateReservedTable(ReservedTable $reservedTable, $userRepository, $form)
    {
            $user = new User();
            if(!$this->getUser() && ($userRepository->findOneBy(['email' => $form['email']->getData()]) == null)){
                $user->setFirstname($form['name']->getData());
                $user->setEmail($form['email']->getData());
                $user->setRoles(['ROLE_USER']);
                $userRepository->save($user, true);
            }
            else
                $user = $userRepository->findOneBy(['email' => $form['email']->getData()]);
            
            in_array('ROLE_CLIENT',$this->getUser()->getRoles()) ? $reservedTable->setClient($user) : $reservedTable->setGuestInfo($user) ;
            $reservedTable->setReservedAt(new \DateTimeImmutable());
            $reservedDate = new \DateTimeImmutable();
            $reservedDate = $reservedDate->setTimestamp(date_timestamp_get($form['reservedForDate']->getData()) + date_timestamp_get($form['reservedTime']->getData())+3600);
            $reservedTable->setReservedFor($reservedDate);
    }
    #[Route('/{id}', name: 'app_reserved_table_show', methods: ['GET'])]
    public function show(ReservedTable $reservedTable): Response
    {
        return $this->render('reserved_table/show.html.twig', [
            'reserved_table' => $reservedTable,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_reserved_table_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ReservedTable $reservedTable, ReservedTableRepository $reservedTableRepository, UserRepository $userRepository): Response
    {
        $form = $this->createForm(ReservedTableType::class, $reservedTable);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->updateReservedTable($reservedTable, $userRepository, $form);
            $reservedTableRepository->save($reservedTable, true);

            return $this->redirectToRoute('app_reserved_table_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reserved_table/edit.html.twig', [
            'reserved_table' => $reservedTable,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_reserved_table_delete', methods: ['POST'])]
    public function delete(Request $request, ReservedTable $reservedTable, ReservedTableRepository $reservedTableRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reservedTable->getId(), $request->request->get('_token'))) {
            $reservedTableRepository->remove($reservedTable, true);
        }

        return $this->redirectToRoute('app_reserved_table_index', [], Response::HTTP_SEE_OTHER);
    }
}
