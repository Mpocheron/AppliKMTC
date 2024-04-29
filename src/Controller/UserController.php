<?php

namespace App\Controller;

use App\Entity\User;  
use App\Form\EditUserType;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;

class UserController extends AbstractController
{
    /**
     * Ce controller nous permet d'éditer le profil de l'utilisateur connecté
     * 
     * @param User $user
     * @param EntityManagerInterface $entityManager
     * @param UserPasswordHasherInterface $userPasswordHasher
     * @param Request $request
     * @return Response
     */

    #[Route('/user', name: 'home_user')]

    public function homeuser(Request $request): Response
    {
        return $this->render('user/homeuser.html.twig');
    }


    #[Route('/user/edit', name: 'app_user')] 
    
    public function editUser(Request $request, User $user, EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        //Si l'utilisateur n'est pas connecté, il est redirigé vers la page de connexion

        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }


        $form = $this->createForm(EditUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $user = $form->getData();
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
                );
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'Votre profil a bien été modifié');

            return $this->redirectToRoute('app_user');
        }

        return $this->render('user/edit.html.twig', [
           'user' => $user,
           'editUserForm' => $form->createView(),
        ]);
        
        
    }
    #[Route('/user/{id}', name: 'app_user_details')]
    public function details(int $id, UserRepository $userRepository): Response
    {
        // Récupère le user depuis le repository
        $user = $userRepository->find($id);

        // Vérifie si le user existe
        if (!$user) {
            throw $this->createNotFoundException('Utilisateur non trouvé');
        }

        // Rend le template Twig avec les informations du relais
        return $this->render('user/details.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/profil', name: 'app_user_profil')]
public function profil(): Response
{
    // Récupère l'utilisateur connecté
    $user = $this->getUser();

    // Vérifie si l'utilisateur est connecté
    if (!$user) {
        // Redirige l'utilisateur vers la page de connexion s'il n'est pas connecté
        return $this->redirectToRoute('app_login');
    }

    // Rend le template Twig avec les informations de l'utilisateur connecté
    return $this->render('user/profil.html.twig', [
        'user' => $user,
    ]);
}



}
