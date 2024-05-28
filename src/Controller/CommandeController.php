<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\Relais;
use App\Entity\Status;
use App\Entity\Etat;
use App\Form\CommandeType;
use App\Repository\CommandeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class CommandeController extends AbstractController
{
    #[Route('/createCommande', name: 'app_commande')]
    public function createCommande(Request $request, EntityManagerInterface $entityManager, SessionInterface $session, CommandeRepository $commandeRepository, UserInterface $user): Response
    {
        // Créer une nouvelle instance de Commande
        $commande = new Commande();
        $commande->setLeUser($user); // Associer l'utilisateur connecté à la commande

        // Obtenir le statut par défaut
        $defaultStatus = new Status();
        $defaultStatus->setLeEtat($entityManager->getReference(Etat::class, 1)); // Associer l'état par défaut à l'entité Status
        $defaultStatus->setDate(new \DateTimeImmutable()); // Date actuelle
        $entityManager->persist($defaultStatus); // Persistez le nouveau statut
        $commande->setStatus($defaultStatus); // Associer le statut à la commande

        // Créer le formulaire avec l'instance de Commande
        $commandeform = $this->createForm(CommandeType::class, $commande, [
            'relais_choices' => $entityManager->getRepository(Relais::class)->findAll(),
            'is_relais_selected' => false, // Par défaut
        ]);
        $commandeform->handleRequest($request);

        // Vérifiez si le formulaire est soumis et valide
        if ($commandeform->isSubmitted() && $commandeform->isValid()) {
            // Votre logique de gestion de formulaire ici...

            // Sauvegarder les données de commande
            $entityManager->persist($commande);
            $entityManager->flush();

            // Redirection vers la page de succès de la commande
            return $this->redirectToRoute('app_commande_recap', ['id' => $commande->getId()]);

        }

        // Récupérer toutes les commandes de l'utilisateur connecté pour l'historique
        $commandes = $commandeRepository->findBy(['leUser' => $user]);

        return $this->render('commande/index.html.twig', [
            'commandeform' => $commandeform->createView(),
            'user' => $this->getUser(),
            'commandes' => $commandes, // Passer les commandes à la vue
        ]);
    }


    #[Route('/commande/success', name: 'app_commande_success')]
    public function commandeSuccess(): Response
    {
        return $this->render('commande/success.html.twig', [
            'message' => 'Commande réussie!',
        ]);
    }

    #[Route('/commande/recap/{id}', name: 'app_commande_recap')]
    public function recapCommande(int $id, EntityManagerInterface $entityManager): Response
    {
        // Récupérer la commande par ID
        $commande = $entityManager->getRepository(Commande::class)->find($id);

        // Si la commande n'existe pas, lever une erreur 404
        if (!$commande) {
            throw $this->createNotFoundException('La commande n\'existe pas.');
        }

        return $this->render('commande/recap.html.twig', [
            'commande' => $commande,
        ]);
    }

    #[Route('/user/suivi/{id}', name: 'app_suivi_commande')]
    public function suiviCommande(Commande $commande): Response
    {
        return $this->render('commande/suivi.html.twig', [
            'commande' => $commande,
        ]);
    }
    #[Route('/historique', name: 'commande_historique')]
    public function historique(CommandeRepository $commandeRepository, UserInterface $user): Response
    {
        $commandes = $commandeRepository->findBy(['leUser' => $user]);

        return $this->render('commande/historique.html.twig', [
            'commandes' => $commandes,
        ]);
    }
}
