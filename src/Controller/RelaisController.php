<?php

namespace App\Controller;

use App\Entity\Adresse;
use App\Entity\Casier;
use App\Entity\Modele;
use App\Entity\Relais;
use App\Form\CreateRelaisType;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManager;
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
        $formData = [];
        $adresse = new Adresse();
        $relais = new Relais();

        $form = $this->createForm(CreateRelaisType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $adresse->setNumero($form->get('numeroAdresse')->getData());
            $adresse->setNom($form->get('nomRue')->getData());
            $adresse->setCodePostal($form->get('codePostal')->getData());
            $adresse->setVille($form->get('ville')->getData());

            $relais->setNom($form->get('nomRelais')->getData());
            $relais->setLeAdresse($adresse);

            $nbGrandCasier = $form->get('nombreCasierGrand')->getData();
            $nbMoyenCasier = $form->get('nombreCasierMoyen')->getData();
            $nbPetitCasier = $form->get('nombreCasierPetit')->getData();

            $entityManager->persist($adresse);
            $entityManager->persist($relais);
            $entityManager->flush();
            
            $this->createCasiers($nbGrandCasier, $nbMoyenCasier, $nbPetitCasier, $relais, $entityManager);

            return $this->redirectToRoute('admin');
        }

        return $this->render('relais/create.html.twig', [
            'form' => $form,
        ]);
    }

    public function createCasiers(int $nbGrandCasier, int $nbMoyenCasier, int $nbPetitCasier, Relais $relais, EntityManagerInterface $entityManager)
    {
        $casierCollection = new ArrayCollection();
        $repository = $entityManager->getRepository(Modele::class);

        $lesModeles = $repository->findAll();

        for ($nbGrandCasier; $nbGrandCasier > 0; $nbGrandCasier--) {
            $casier = new Casier;
            $casier->setleModele($lesModeles[0]);
            $relais->addLesCasier($casier);

            $entityManager->persist($casier);
            $entityManager->flush();
        }
        
        for ($nbMoyenCasier; $nbMoyenCasier > 0; $nbMoyenCasier--) {
            $casier = new Casier;
            $casier->setleModele($lesModeles[1]);
            $relais->addLesCasier($casier);

            $entityManager->persist($casier);
            $entityManager->flush();
        }
        
        for ($nbPetitCasier; $nbPetitCasier > 0; $nbPetitCasier--) {
            $casier = new Casier;
            $casier->setleModele($lesModeles[2]);
            $relais->addLesCasier($casier);

            $entityManager->persist($casier);
            $entityManager->flush();
        }
    }
}
