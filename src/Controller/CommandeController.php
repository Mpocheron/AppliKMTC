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
        //Creation d'une nouvelle commande/=instance
        $commande = new Commande();
        //Creation du formulaire avec l'instance commande
        $commandeform = $this->createForm(CommandeFormType::class, $commande);
        $commandeform->handleRequest($request);

        if ($commandeform->isSubmitted() && $commandeform->isValid()) {
            $commande = $commandeform->getData();
            $entityManager->persist($commande);
            $entityManager->flush();  

            //Ajout d'un flash message en cas de commande validée
            $session->getFlashBag()->add('success', 'La commande a été validée avec succès.');
        }
        else {
        // Ajout d'un message flash en cas d'erreur
        $session->getFlashBag()->add('error', 'Une erreur est survenue lors de la validation de la commande.');
        }

        return $this->render('commande/index.html.twig', [ 
            'user' => $this->getUser(),
            'commandeform' => $commandeform->createView(),
        ]);
    }


}
