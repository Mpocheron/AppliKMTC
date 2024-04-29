<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Adresse;
use App\Entity\AdresseUser;
use App\Form\RegistrationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

class RegistrationController extends AbstractController
{
    private $registry;

    public function __construct(ManagerRegistry $registry)
    {
        $this->registry = $registry;
    }

    #[Route('/register', name: 'register')]
    public function register(Request $request): Response
    {
        $user = new User();
        $adresse = new Adresse();
        
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérer les données du formulaire
            $formData = $form->getData();

            // Enregistrer l'utilisateur
            $entityManager = $this->registry->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            // Associer l'adresse à l'utilisateur
            $adresse->setNom($formData->getAdresseNom());
            $adresse->setNumero($formData->getAdresseNumero());
            // Autres propriétés d'adresse...

            // Enregistrer l'adresse
            $entityManager->persist($adresse);
            $entityManager->flush();

            // Créer une relation entre l'utilisateur et l'adresse
            $adresseUser = new AdresseUser();
            $adresseUser->setLeuser($user);
            $adresseUser->setLeAdresse($adresse);
            $entityManager->persist($adresseUser);
            $entityManager->flush();

            // Rediriger l'utilisateur vers une page de confirmation
            return $this->redirectToRoute('registration_success');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/register/success', name: 'registration_success')]
    public function registrationSuccess(): Response
    {
        return $this->render('registration/success.html.twig');
    }
}
