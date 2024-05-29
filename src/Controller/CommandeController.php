<?php

namespace App\Controller;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils; // Importez la classe AuthenticationUtils
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Form\CommandeFormType;
use App\Entity\Commande;
use App\Entity\Adresse;
use App\Entity\AdresseUser;
use App\Entity\User;
use App\Entity\Casier;
use App\Entity\Relais;


class CommandeController extends AbstractController
{
    private $authenticationUtils;

    public function __construct(AuthenticationUtils $authenticationUtils) // Injectez le service AuthenticationUtils dans le constructeur
    {
        $this->authenticationUtils = $authenticationUtils;
    }

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

        // l'adresse du user connecté est récupéré
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

        // -------------    SI LE FORMULAIRE EST VALIDE ----------- \\
        // Vérifiez si le formulaire est soumis et valide
        if ($commandeform->isSubmitted() && $commandeform->isValid()) {

            // Définir la date de commande à la date actuelle
            $commande->setDateCommande(new \DateTime());
            
            // Récupérer le relais sélectionné (si nécessaire)
            //$relais = $commandeform->get('relais')->getData();
            // Récupérez l'ID du relais sélectionné dans le formulaire de commande
            $relaisId = $commandeform->get('relais')->getData();

            // Vérifiez si un relais a été sélectionné
            if ($relaisId) {
                // Récupérez l'entité Relais correspondante
                $relais = $entityManager->getRepository(Relais::class)->find($relaisId);

                // Vérifiez si le relais existe
                if ($relais) {
                    // Récupérez tous les casiers associés au relais sélectionné
                    $casiers = $entityManager->getRepository(Casier::class)->findBy([
                        'leRelais' => $relais,
                        'utilise' => 0 // Assurez-vous que le casier n'est pas déjà utilisé
                    ]);

                    // Vérifiez si des casiers ont été trouvés
                    if (!empty($casiers)) {
                        // Parcourez tous les casiers pour trouver celui qui est libre
                        foreach ($casiers as $casier) {
                            if (!$casier->isUtilise()) {
                                // Si un casier est libre, associe le casier à la commande
                                $commande->setLeCasier($casier);
                                // Marque le casier comme utilisé
                                $casier->setUtilise(true);
                                $entityManager->persist($casier);
                                // Sort de la boucle une fois qu'un casier a été trouvé
                                break;
                            }
                        }

                        // Si aucun casier libre n'a été trouvé
                        if (!$commande->getLeCasier()) {
                            // Gérez le cas où aucun casier disponible n'est trouvé pour ce relais
                            $this->addFlash('echec', 'Pas de casier disponible');
                        }
                    } else {
                        // Gérez le cas où aucun casier n'est associé au relais sélectionné
                        $this->addFlash('echec', 'Pas de casier pour ce relais');
                    }
                } else {
                    // Gérez le cas où le relais n'existe pas (peut-être une erreur?)
                    $this->addFlash('echec', 'Pas de relais, certainement une erreur');
                }
            }

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
                // Associe ce relais à la commande
                $commande->setLeRelais($relais);

            }

            // Sauvegarder les données de commande
            $entityManager->persist($commande);
            $entityManager->flush();  

            // Ajouter un message flash de succès
            $this->addFlash('success', 'La commande a été validée avec succès.');

            return $this->redirectToRoute('app_commande_success', ['id' => $commande->getId()]); // Redirection après succès
        }

        // ------------- si erreur ----------- \\
        // Si le formulaire a été soumis mais n'est pas valide
        else {
            // Ajouter un message flash d'erreur
            $this->addFlash('error', 'Une erreur est survenue lors de la validation de la commande.');
        }


        // ------------------- RENVOIS -------------- \\
        return $this->render('commande/index.html.twig', [
            'commandeform' => $commandeform->createView(),
            'adresse' => $adresse,
            'user' => $this->getUser(),
        ]);
    }

    #[Route('/commande/success/{id}', name: 'app_commande_success')]
    public function commandeSuccess(Commande $commande): Response
    {   
        // récupère le user, l'adresse expedition, destination, relais la date de la commande
        $user = $this->getUser(); 
        $adresseExpedition = $commande->getAdresseExpedition();
        $adresseDestination = $commande->getAdresseDestination();
        $relais = $commande->getLeRelais();
        $dateCommande = $commande->getDateCommande();

        return $this->render('commande/success.html.twig', [
            'commande' => $commande,
            'user' => $user,
            'adresseExpedition' => $adresseExpedition,
            'adresseDestination' => $adresseDestination,
            'relais' => $relais,
            'dateCommande' => $dateCommande,
            'message' => 'Commande réussie!',
        ]);
    }

}
