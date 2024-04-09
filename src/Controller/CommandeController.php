<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
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
    #[Route('/commande', name: 'app_commande')]
    public function index(): Response
    {
        return $this->render('commande/index.html.twig', [
            'controller_name' => 'CommandeController',
        ]);
    }*/

    #[Route('/commande', name: 'app_commande')]
    public function commande(): Response
    {

        //Creation d'une nouvelle commande/=instance
        $commande = new Commande();

        //Creation du formulaire avec l'instance commande
        $commandeform = $this->createForm(CommandeFormType::class, $commande);


        return $this->render('commande/index.html.twig', [ 
            'commandeform' => $commandeform->createView(),
        ]);
    }


}
