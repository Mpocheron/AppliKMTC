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

            /*
            $numero = $commandeForm.get('numero').getData();
            $nom = $commandeForm.get('nom').getData();
            $codePostal = $commandeForm.get('codePostal').getData();
            $ville = $commandeForm.get('ville').getData();

            // Créer une nouvelle adresse avec les parties récupérées
            $adresse = new Adresse();
            $adresse.setNumero($numero);
            $adresse.setNom($nom);
            $adresse.setCodePostal($codePostal);
            $adresse.setVille($ville);

            // Persister l'adresse
            $entityManager->persist($adresse);
            $entityManager->flush();

            // Lier la nouvelle adresse à la commande
            $commande->setAdresseDestination($adresse);
            */

            // Sauvegarder les données de commande
            $entityManager->persist($commande);
            $entityManager->flush();  

            // Ajouter un message flash de succès
            $this->addFlash('success', 'La commande a été validée avec succès.');

            return $this->redirectToRoute('app_commande_success'); // Redirection après succès
        }

        // Si le formulaire a été soumis mais n'est pas valide
        else {
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

}
