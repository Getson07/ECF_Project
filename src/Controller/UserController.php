<?php

namespace App\Controller;

use App\Entity\Administrator;
use App\Entity\Client;
use App\Entity\User;
use App\Form\UserType;
use App\Repository\AdministratorRepository;
use App\Repository\ClientRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user')]
class UserController extends AbstractController
{
    #[Route('/', name: 'app_user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_user_new', methods: ['GET', 'POST'])]
    public function new(Request $request, UserRepository $userRepository, AdministratorRepository $administratorRepository, ClientRepository $clientRepository, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->submiteForm($user, $passwordHasher, $clientRepository, $administratorRepository, $userRepository);
        }

        return $this->renderForm('user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, UserRepository $userRepository, AdministratorRepository $administratorRepository, ClientRepository $clientRepository, UserPasswordHasherInterface $passwordHasher): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            dd($user);
            return $this->submiteForm($user, $passwordHasher, $clientRepository, $administratorRepository, $userRepository, false);
        }

        return $this->renderForm('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, UserRepository $userRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $userRepository->remove($user, true);
        }

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }

    private function submiteForm($user, $passwordHasher, $clientRepository, $administratorRepository, $userRepository, $new=true): Response
    {
        
        if(!$new) $userRepository->remove($user, true);
        else $user->setPassword($passwordHasher->hashPassword($user, $user->getPassword()));
        if(in_array('ROLE_CLIENT', $user->getRoles())){
            $client = new Client($user);
            $clientRepository->save($client, true);
        }
        elseif(in_array('ROLE_ADMINISTRATOR', $user->getRoles())){
            $administrator = new Administrator($user);
            $administratorRepository->save($administrator, true);
        }
        else
            $userRepository->save($user, true);

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }
}
