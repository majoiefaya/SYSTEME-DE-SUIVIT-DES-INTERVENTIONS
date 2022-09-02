<?php

namespace App\Controller;

use App\Entity\Tache;
use App\Form\TacheType;
use App\Repository\TacheRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

#[Route('/tache')]
class TacheController extends AbstractController
{
    private $params;

    public function __construct(ParameterBagInterface $params)
    {
        $this->params = $params;
    }

    #[Route('/', name: 'TacheAdmin', methods: ['GET'])]
    public function ListeTache(TacheRepository $tacheRepository): Response
    {
        return $this->render('GestionDesRessourcesHumaines/tache/ListeTache.html.twig', [
            'taches' => $tacheRepository->findAll(),
        ]);
    }

    #[Route('/AjouterUneTache', name: 'AjouterTache', methods: ['GET', 'POST'])]
    public function Ajouter(Request $request, TacheRepository $tacheRepository): Response
    {
        $ContenuTache = $request->request->get('Contenu');
        $TitreTache = $request->request->get('TitreTache');
        $tache = new Tache();
        $form = $this->createForm(TacheType::class, $tache);
        $form->handleRequest($request);
        $user = $this->getUser();
        if ($user != null) {
            $username = $user->getUserIdentifier();
        } else {
            $username = "NonIdentifié";
        }

        $dateCreation = new \DateTime('@' . strtotime('now'));

        if ($form->isSubmitted() && $form->isValid()) {
            ///insertion du fichier dans la base de donées et dans Le Dossier Fichier
            $webpath = $this->params->get("kernel.project_dir") . '/public/RessourcesHumaines/Taches/Fichiers/';
            $chemin = $webpath . $_FILES['tache']["name"]["Fichier"];
            $destination = move_uploaded_file($_FILES['tache']['tmp_name']['Fichier'], $chemin);
            $tache->setFichier($_FILES['tache']['name']['Fichier']);


            ///Insertion des Données A set en BackEnd
            $tache->setTitreTache($TitreTache);
            $tache->setContenu($ContenuTache);
            $tache->setCreerPar($username);
            $tache->setCreerLe($dateCreation);
            $tache->setEnable(True);
            $tache->setActive(True);
            $tache->setStatut("NonFait");
            $tacheRepository->add($tache, true);
            return $this->redirectToRoute('TacheAdmin', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('GestionDesRessourcesHumaines/tache/AjouterUneTache.html.twig', [
            'tache' => $tache,
            'form' => $form,
        ]);
    }

    #[Route('/InformationsDeLaTahceN/{id}', name: 'InfosTache', methods: ['GET'])]
    public function Infos(Tache $tache): Response
    {
        return $this->render('GestionDesRessourcesHumaines/tache/InfosTache.html.twig', [
            'tache' => $tache,
        ]);
    }

    #[Route('/ModifierLaTacheN/{id}', name: 'ModifierTache', methods: ['GET', 'POST'])]
    public function Modifier(Request $request, Tache $tache, TacheRepository $tacheRepository): Response
    {
        $ContenuTache = $request->request->get('Contenu');
        $TitreTache = $request->request->get('TitreTache');
        $form = $this->createForm(TacheType::class, $tache);
        $form->handleRequest($request);
        $user = $this->getUser();
        if ($user != null){
            $username = $user->getUserIdentifier();
        } else{
            $username = "NonIdentifié";
        }

        $dateCreation = new \DateTime('@' . strtotime('now'));

        if ($form->isSubmitted() && $form->isValid()) {
            ///insertion du fichier dans la base de donées et dans Le Dossier Fichier
            $webpath = $this->params->get("kernel.project_dir") . '/public/RessourcesHumaines/Taches/Fichiers/';
            $chemin = $webpath . $_FILES['tache']["name"]["Fichier"];
            $destination = move_uploaded_file($_FILES['tache']['tmp_name']['Fichier'], $chemin);
            $tache->setFichier($_FILES['tache']['name']['Fichier']);

            ///Insertion des Données A set en BackEnd
            $tache->setTitreTache($TitreTache);
            $tache->setContenu($ContenuTache);
            $tache->setCreerPar($username);
            $tache->setCreerLe($dateCreation);
            $tache->setEnable(True);
            $tache->setStatut("NonFait");

            ///Ajout de L instance créer dans la base de données
            $tacheRepository->add($tache, true);

            return $this->redirectToRoute('TacheAdmin', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('GestionDesRessourcesHumaines/tache/ModifierUneTache.html.twig', [
            'tache' => $tache,
            'form' => $form,
        ]);
    }

    #[Route('/SupprimerLaTacheN/{id}', name: 'SupprimerTache', methods: ['POST','GET'])]
    public function Supprimer(Request $request, Tache $tache, TacheRepository $tacheRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $tache->getId(), $request->request->get('_token'))) {
            $tacheRepository->remove($tache, true);
        }

        return $this->redirectToRoute('tache', [], Response::HTTP_SEE_OTHER);
    }
}
