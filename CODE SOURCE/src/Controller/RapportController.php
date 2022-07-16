<?php

namespace App\Controller;

use App\Entity\Rapport;
use App\Form\RapportType;
use App\Repository\RapportRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

#[Route('/rapport')]
class RapportController extends AbstractController
{

    
    private $params;

    public function __construct(ParameterBagInterface $params)
    {
        $this->params=$params;
    }

    #[Route('/', name: 'rapport', methods: ['GET'])]
    public function index(RapportRepository $rapportRepository): Response
    {
        return $this->render('rapport/ListeRapports.html.twig', [
            'rapports' => $rapportRepository->findAll(),
            'NombreTotalRapports'=>count($rapportRepository->findAll()),
            'NombreLu'=>count($rapportRepository->ListeRapportsLue()),
            'NombreNonLu'=>count($rapportRepository->ListeRapportsNonLue()),
            'NombreSupprimé'=>count($rapportRepository->ListeRapportsSupprimés())
        ]);
    }

    #[Route('/ListeDesRapportsLus', name: 'RapportsLus', methods: ['GET'])]
    public function RapportsLus(RapportRepository $rapportRepository): Response
    {
        return $this->render('rapport/ListeRapports.html.twig', [
            'rapports' => $rapportRepository->ListeRapportsLue(),
            'NombreTotalRapports'=>count($rapportRepository->findAll()),
            'NombreLu'=>count($rapportRepository->ListeRapportsLue()),
            'NombreNonLu'=>count($rapportRepository->ListeRapportsNonLue()),
            'NombreSupprimé'=>count($rapportRepository->ListeRapportsSupprimés())
        ]);
    }


    #[Route('/ListeDesRapportsNonLus', name: 'RapportsNonLus', methods: ['GET'])]
    public function RapportsNonLus(RapportRepository $rapportRepository): Response
    {
        return $this->render('rapport/ListeRapports.html.twig', [
            'rapports' => $rapportRepository->ListeRapportsNonLue(),
            'NombreTotalRapports'=>count($rapportRepository->findAll()),
            'NombreLu'=>count($rapportRepository->ListeRapportsLue()),
            'NombreNonLu'=>count($rapportRepository->ListeRapportsNonLue()),
            'NombreSupprimé'=>count($rapportRepository->ListeRapportsSupprimés())
        ]);
    }


    #[Route('/ListeDesRapportsSupprimés', name: 'RapportsSupprimés', methods: ['GET'])]
    public function RapportsSupprimés(RapportRepository $rapportRepository): Response
    {
        return $this->render('rapport/ListeRapports.html.twig', [
            'rapports' => $rapportRepository->ListeRapportsSupprimés(),
            'NombreTotalRapports'=>count($rapportRepository->findAll()),
            'NombreLu'=>count($rapportRepository->ListeRapportsLue()),
            'NombreNonLu'=>count($rapportRepository->ListeRapportsNonLue()),
            'NombreSupprimé'=>count($rapportRepository->ListeRapportsSupprimés())
        ]);
    }




    #[Route('/MarquerLueLeRapportN/{id}', name: 'MarquerRapport', methods: ['GET', 'POST'])]
    public function MarquerRapport(Request $request, RapportRepository $rapportRepository, Rapport $rapport): Response
    {
        $rapport->setStatutRapport("Lu");
        $rapportRepository->add($rapport, true);
        return $this->redirectToRoute('rapport', [], Response::HTTP_SEE_OTHER);
    }
        
    #[Route('/AjouterUnRapport', name: 'AjouterRapport', methods: ['GET', 'POST'])]
    public function new(Request $request, RapportRepository $rapportRepository): Response
    {
        $rapport = new Rapport();
        $form = $this->createForm(RapportType::class, $rapport);
        $form->handleRequest($request);

        $ContenuRapport=$request->request->get('contenu');
        $SujetRapport=$request->request->get('sujet');
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
             $rapport->setFichier($_FILES['rapport']['name']['fichier']);
 
             ///Insertion des Données A set en BackEnd
             $rapport->setContenu($ContenuRapport);
             $rapport->setSujetRapport($SujetRapport);
             $rapport->setCreerPar($username);
             $rapport->setCreerLe($dateCreation);
             $rapport->setEmploye($user);
             $rapport->setStatutRapport("NonLu");
             $rapport->setEnable(True);

            $rapportRepository->add($rapport, true);

            return $this->redirectToRoute('rapport', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('rapport/AjouterUnRapport.html.twig', [
            'rapport' => $rapport,
            'form' => $form,
        ]);
    }

    #[Route('/InfosDuRapportN/{id}', name: 'InfosRapport', methods: ['GET'])]
    public function show(Rapport $rapport, RapportRepository $rapportRepository): Response
    {
        return $this->render('rapport/InfosRapport.html.twig', [
            'rapport' => $rapport,
            'rapports' => $rapportRepository->ListeRapportsNonLue(),
            'NombreTotalRapports'=>count($rapportRepository->findAll()),
            'NombreLu'=>count($rapportRepository->ListeRapportsLue()),
            'NombreNonLu'=>count($rapportRepository->ListeRapportsNonLue()),
            'NombreSupprimé'=>count($rapportRepository->ListeRapportsSupprimés())
        ]);
    }

    #[Route('/ModifierLeRapportN/{id}', name: 'ModifierRapport', methods: ['GET', 'POST'])]
    public function edit(Request $request, Rapport $rapport, RapportRepository $rapportRepository): Response
    {
        $form = $this->createForm(RapportType::class, $rapport);
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
             $rapport->setFichier($_FILES['rapport']['name']['fichier']);
 
             ///Insertion des Données A set en BackEnd
             $rapport->setCreerPar($username);
             $rapport->setCreerLe($dateCreation);
             $rapport->setEnable(True);

            $rapportRepository->add($rapport, true);

            return $this->redirectToRoute('rapport', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('rapport/ModifierUnRapport.html.twig', [
            'rapport' => $rapport,
            'form' => $form,
        ]);
    }

    #[Route('/SupprimerLeRapportN/{id}', name: 'SupprimerRapport', methods: ['POST','GET'])]
    public function delete(Request $request, Rapport $rapport, RapportRepository $rapportRepository): Response
    {
       
        $rapport->setEnable(False);
        $rapportRepository->add($rapport);

        return $this->redirectToRoute('rapport', [], Response::HTTP_SEE_OTHER);
    }
}
