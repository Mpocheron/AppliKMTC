<?php

namespace App\Controller;

use App\Repository\AdresseRepository;
use App\Repository\CommandeRepository;
use App\Repository\RelaisRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\CommandeFormType;
use App\Entity\Commande;
use App\Form\SuiviCommandeType;
use Symfony\Component\Serializer\SerializerInterface;


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

    #[Route('user/suivi', name: 'app_suivi_commande')]

    public function suivi_commande(CommandeRepository $commandeRepository, RelaisRepository $relaisRepository, AdresseRepository $adresseRepository, SerializerInterface $serializer): Response
    {
        
            // Récupérer les données des relais depuis la base de données
        $relais = $relaisRepository->findAll();

        // Tableau pour stocker les coordonnées des relais
        $relaisCoordinates = [];

        // Pour chaque relais, récupérer les données de l'adresse associée
        foreach ($relais as $relai) {
            $adresseId = $relai->getLeAdresse();
            $adresse = $adresseRepository->find($adresseId);

            // Vérifier si l'adresse existe et a des coordonnées
            if ($adresse && $adresse->getLatitude() && $adresse->getLongitude()) {

                // Convertir les valeurs de latitude et de longitude en nombres (floats)
                $latitude = (float) $adresse->getLatitude();
                $longitude = (float) $adresse->getLongitude();

                $relaisCoordinates[] = [
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                    'nom' => $relai->getNom() // Ajoutez d'autres données du relai si nécessaire
                ];
            }
        }
        // Sérialiser les données des relais en JSON
        $relaisJson = $serializer->serialize($relaisCoordinates, 'json');

        // Récupérer les commandes depuis la base de données
        $listecommande = $commandeRepository->findAll();

        return $this->render('commande/suivi.html.twig', [
            'relaisJson' => $relaisJson,
            'listecommande' => $listecommande,
        ]);
    }
}
