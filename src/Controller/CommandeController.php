<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Form\CommandeType;
use App\Entity\Commande;
use App\Entity\Relais;
use App\Entity\Adresse;

class CommandeController extends AbstractController
{
    #[Route('/createCommande', name: 'app_commande')]
    public function createCommande(Request $request, EntityManagerInterface $entityManager, SessionInterface $session): Response
    {
        // Obtenir l'utilisateur connecté
        $user = $this->getUser(); 
        
        // Créer une nouvelle instance de Commande
        $commande = new Commande();
        $commande->setLeUser($user); // Associer l'utilisateur connecté à la commande

        // Créer le formulaire avec l'instance de Commande
        $commandeform = $this->createForm(CommandeType::class, $commande, [
            'relais_choices' => $entityManager->getRepository(Relais::class)->findAll()
        ]);
        $commandeform->handleRequest($request);

        // Vérifiez si le formulaire est soumis et valide
        if ($commandeform->isSubmitted() && $commandeform->isValid()) {
            // Vérification si un relais est choisi comme adresse d'expédition
            if ($commande->getAdresseExpedition() instanceof Relais) {
                // Si un relais est choisi, on supprime l'adresse de destination de la commande
                $commande->setAdresseDestination(null);
            }

            // Récupérer les adresses et les assigner à la commande
            $adresseExpedition = $commandeform->get('adresseExpedition')->getData();
            $adresseDestination = $commandeform->get('adresseDestination')->getData();
            $adresseFacturation = $commandeform->get('adresseFacturation')->getData();

            $commande->setAdresseExpedition($adresseExpedition);
            $commande->setAdresseDestination($adresseDestination);
            $commande->setAdresseFacturation($adresseFacturation);

            // Sauvegarder les données de commande
            $entityManager->persist($commande);
            $entityManager->flush();  

            // Ajouter un message flash de succès
            $this->addFlash('success', 'La commande a été validée avec succès.');

            // Redirection vers la page récapitulatif de commande
            return $this->redirectToRoute('app_commande_recap', ['id' => $commande->getId()]);
        } else {
            // Ajouter un message flash d'erreur
            $this->addFlash('error', 'Une erreur est survenue lors de la validation de la commande.');
        }

        return $this->render('commande/index.html.twig', [
            'commandeform' => $commandeform->createView(),
            'user' => $this->getUser(),
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
}
