<?php

namespace App\Controller;

use App\Entity\Adresse;
use App\Entity\Casier;
use App\Entity\Relais;
use App\Form\RelaisType;
use App\Form\CasierType;
use App\Form\CreateRelaisType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RelaisController extends AbstractController
{
    #[Route('admin/create/relais', name: 'create_relais')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $relais = new Relais();

        $form = $this->createForm(RelaisType::class, $relais);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $relais = $form->getData();

            $entityManager->persist($relais);
            $entityManager->flush();

            return $this->redirectToRoute('admin');
        }

        return $this->render('relais/create.html.twig', [
            'form' => $form,
        ]);
    }
}
