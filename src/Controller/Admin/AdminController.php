<?php

namespace App\Controller\Admin;

use App\Entity\Users;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\EditUserType;

#[Route('/admin', name: 'admin_')]
class AdminController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    #[Route('/users', name: 'users')]
    public function usersList(UsersRepository $users): Response
    {
        return $this->render('admin/usersList.html.twig', [
            'users' => $users->findAll(),

        ]);
    }

    #[Route('/users/edit/{id}', name: 'edit_user')]
    public function editUser(Users $user, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EditUserType::class, $user);
        $form->handleRequest($request);
        //dd($form);
        
        if ($form->isSubmitted() && $form->isValid()) {
           
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('message','Utilisateur modifié avec succès');
            return $this->redirectToRoute('admin_users');
            }
            return $this->render('admin/edituser.html.twig', [
            'editUserForm' => $form->createView(),

        ]);

    }

}
