<?php

namespace App\Controller;

use App\Entity\Tache;
use App\Form\TacheType;
use App\Repository\TacheRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/tache')]
class TacheController extends AbstractController
{
    #[Route('/', name: 'tache', methods: ['GET'])]
    public function ListeTache(TacheRepository $tacheRepository): Response
    {
        return $this->render('tache/index.html.twig', [
            'taches' => $tacheRepository->findAll(),
        ]);
    }

    #[Route('/AjouterUneTache', name: 'AjouterTache', methods: ['GET', 'POST'])]
    public function Ajouter(Request $request, TacheRepository $tacheRepository): Response
    {
        $tache = new Tache();
        $form = $this->createForm(TacheType::class, $tache);
        $form->handleRequest($request);
        $user = $this->getUser();
        if($user!=null){
            $username=$user->getUserIdentifier();
        }
        else{
            $username="NonIdentifié";
        }

        $dateCreation=new \DateTime('@'.strtotime('now'));

        if ($form->isSubmitted() && $form->isValid()) {
             ///insertion du fichier dans la base de donées et dans Le Dossier Fichier
             $webpath=$this->params->get("kernel.project_dir").'/public/Rapports/Fichiers/';
             $chemin=$webpath.$_FILES['rapport']["name"]["fichier"];
             $destination=move_uploaded_file($_FILES['rapport']['tmp_name']['fichier'],$chemin);
             $tache->setFichier($_FILES['rapport']['name']['fichier']);
             $tacheRepository->add($tache, true);

            ///Insertion des Données A set en BackEnd
            $tache->setCreerPar($username);
            $tache->setCreerLe($dateCreation);
            $tache->setEnable(True);
            $tache->setStatut("NonEffectué");
            return $this->redirectToRoute('tache', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('tache/AjouterUneTache.html.twig', [
            'tache' => $tache,
            'form' => $form,
        ]);
    }

    #[Route('/InformationsDeLaTahceN/{id}', name: 'InfosTache', methods: ['GET'])]
    public function Infos(Tache $tache): Response
    {
        return $this->render('tache/InfosTache.html.twig', [
            'tache' => $tache,
        ]);
    }

    #[Route('/ModifierLaTacheN/{id}', name: 'app_tache_edit', methods: ['GET', 'POST'])]
    public function Modifier(Request $request, Tache $tache, TacheRepository $tacheRepository): Response
    {
        $form = $this->createForm(TacheType::class, $tache);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tacheRepository->add($tache, true);

            return $this->redirectToRoute('tache', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('tache/ModifierUneTache.html.twig', [
            'tache' => $tache,
            'form' => $form,
        ]);
    }

    #[Route('/SupprimerLaTacheN/{id}', name: 'SupprimerTache', methods: ['POST'])]
    public function Supprimer(Request $request, Tache $tache, TacheRepository $tacheRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tache->getId(), $request->request->get('_token'))) {
            $tacheRepository->remove($tache, true);
        }

        return $this->redirectToRoute('tache', [], Response::HTTP_SEE_OTHER);
    }
}
