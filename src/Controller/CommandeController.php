<?php

namespace App\Controller;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Form\CommandeFormType;
use App\Entity\Commande;
use App\Entity\Adresse;
use App\Entity\AdresseUser;
use App\Entity\User;
use App\Entity\Relais;

class CommandeController extends AbstractController
{
    /**
     * Page Commande
     *
     * @Route("/", name="app_commande")
     */
    /*
    */

    #[Route('/createCommande', name: 'app_commande')]
    public function createCommande(Request $request, EntityManagerInterface $entityManager, SessionInterface $session): Response
    {
        // Obtenir l'utilisateur connecté
        $user = $this->getUser(); 

        
        $adresse = null;
        $adresseUserEntity = $entityManager->getRepository(AdresseUser::class)->findOneBy(['leuser' => $user]);
        if ($adresseUserEntity) {
            $adresse = $adresseUserEntity->getLeAdresse();
        }
        
        // Créer une nouvelle instance de Commande
        $commande = new Commande();

        // Créer le formulaire avec l'instance de Commande
        $commandeform = $this->createForm(CommandeFormType::class, $commande, [
        'relais_choices' => $entityManager->getRepository(Relais::class)->findAll()
        ]);
        $commandeform->handleRequest($request);

        // Vérifiez si le formulaire est soumis et valide
        if ($commandeform->isSubmitted() && $commandeform->isValid()) {
            

            // Récupérer le relais sélectionné (si nécessaire)
            $relais = $commandeform->get('relais')->getData();

             // Obtenir les données de l'adresse de destination
            $adresseDestination = $commandeform->get('adresseDestination')->getData();

            if ($adresseDestination !== null) {
                // Si l'adresse n'est pas persisté
                if (!$entityManager->contains($adresseDestination)) {
                    // Persister la nouvelle adresse
                    $entityManager->persist($adresseDestination);
                    $entityManager->flush(); // Sauvegarder pour obtenir un ID
                }

                
                // /!!\ Lier la commande à l'utilisateur connecté /!!\
                $commande->setLeUser($user);
                // Associer l'adresse de destination à la commande
                $commande->setAdresseDestination($adresseDestination);
                // adresse de l'expediteur = adresse du user connecté
                $commande->setAdresseExpedition($adresse);

            }


            // Sauvegarder les données de commande
            $entityManager->persist($commande);
            $entityManager->flush();  

            // Ajouter un message flash de succès
            $this->addFlash('success', 'La commande a été validée avec succès.');

            return $this->redirectToRoute('app_commande_success', ['id' => $commande->getId()]); // Redirection après succès
        }

        // Si le formulaire a été soumis mais n'est pas valide
        else {
            // Ajouter un message flash d'erreur
            $this->addFlash('error', 'Une erreur est survenue lors de la validation de la commande.');
        }

        return $this->render('commande/index.html.twig', [
            'commandeform' => $commandeform->createView(),
            'adresse' => $adresse,
            'user' => $this->getUser(),
        ]);
    }

    #[Route('/commande/success/{id}', name: 'app_commande_success')]
    public function commandeSuccess(Commande $commande): Response
    {
        // Récupérer l'utilisateur connecté
        $user = $this->getUser();

        // Initialiser l'adresse à null
        $adresse = null;
        
        // Vérifier si l'utilisateur est connecté et s'il a une adresse associée
        if ($user && $user->getLesAdresseUsers()->count() > 0) {
            // Supposons que l'adresse à utiliser est la première adresse associée à l'utilisateur
            $adresse = $user->getLesAdresseUsers()->first()->getLeAdresse();
        }


        return $this->render('commande/success.html.twig', [
            'commande' => $commande,
            'adresse' => $adresse,
            'message' => 'Commande validée !',
        ]);
    }

}
