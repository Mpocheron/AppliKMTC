<?php

namespace App\Controller;

use App\Entity\Relais;
use App\Repository\RelaisRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RelaisController extends AbstractController
{
    #[Route('/relais', name: 'app_relais')]
    public function index(): Response
    {
        // Ici tu peux implémenter une action pour afficher tous les relais si nécessaire
    }

    #[Route('/relais/{id}', name: 'app_relais_details')]
    public function details(int $id, RelaisRepository $relaisRepository): Response
    {
        // Récupère le relais depuis le repository
        $relais = $relaisRepository->find($id);

        // Vérifie si le relais existe
        if (!$relais) {
            throw $this->createNotFoundException('Relais non trouvé');
        }

        // Rend le template Twig avec les informations du relais
        return $this->render('relais/details.html.twig', [
            'relais' => $relais,
        ]);
    }
}
