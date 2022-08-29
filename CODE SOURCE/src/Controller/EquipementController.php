<?php

namespace App\Controller;

use App\Entity\Equipement;
use App\Form\EquipementType;
use App\Repository\EquipementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\TypeEquipementRepository;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;


#[Route('/equipement')]
class EquipementController extends AbstractController
{
    private $params;

    public function __construct(ParameterBagInterface $params)
    {
        $this->params=$params;
    }


    #[Route('/', name: 'equipement', methods: ['GET'])]
    public function index(EquipementRepository $equipementRepository,TypeEquipementRepository $typeEquipementRepository): Response
    {
        return $this->render('GestionDesRessourcesMateriels/equipement/ListeEquipements.html.twig', [
            'equipements' => $equipementRepository->findAll(),
            'TypesEquipements'=>$typeEquipementRepository->findAll(),
            'NombreEquipements'=>count($equipementRepository->findAll())
        ]);
    }

    #[Route('/AjouterUnEquipement', name:'AjouterEquipement', methods: ['GET', 'POST'])]
    public function new(Request $request, EquipementRepository $equipementRepository,TypeEquipementRepository $typeEquipementRepository): Response
    {
        $equipement = new Equipement();
        $form = $this->createForm(EquipementType::class, $equipement);
        $form->handleRequest($request);

        $user = $this->getUser();
        if($user!=null){
            $username=$user->getUserIdentifier();
        }
        else{
            $username="Développeur";
        }
        $dateCreation=new \DateTime('@'.strtotime('now'));


        if ($form->isSubmitted() && $form->isValid()) {

            ///insertion de l image dans la base de donées et dans Le Dossier PhotosDeProfil
            $webpath=$this->params->get("kernel.project_dir").'/public/Interventions/Equipements/Images/';
            $chemin=$webpath.$_FILES['equipement']["name"]["Image"];
            $destination=move_uploaded_file($_FILES['equipement']['tmp_name']['Image'],$chemin);
            $equipement->setimage($_FILES['equipement']['name']['Image']);

            ///Insertion des Données A set en BackEnd
            $equipement->setCreerPar($username);
            $equipement->setCreerLe($dateCreation);
            $equipement->setEnable(True);

            $equipement->setDisponibilite('Disponible');
            $equipement->setNombreUtilisation(0);

            if($equipement->getTypeEquipement()){
                $TypeEquipement=$equipement->getTypeEquipement();
                $QuantiteTypeEquipement=$TypeEquipement->getQuantiteTypeEquipement();
                $QuantiteTypeEquipement=$QuantiteTypeEquipement+=1;
                $TypeEquipement->setQuantiteTypeEquipement( $QuantiteTypeEquipement);
                $typeEquipementRepository->add($TypeEquipement,true);
            }
  
            $equipementRepository->add($equipement, true);

            return $this->redirectToRoute('equipement', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('GestionDesRessourcesMateriels/equipement/AjouterUnEquipement.html.twig', [
            'equipement' => $equipement,
            'equipements' => $equipementRepository->findAll(),
            'TypesEquipements'=>$typeEquipementRepository->findAll(),
            'NombreEquipements'=>count($equipementRepository->findAll()),
            'form' => $form,
        ]);
    }

    #[Route('/InfosDeLEquipementN/{id}', name: 'InfosEquipement', methods: ['GET'])]
    public function show(Equipement $equipement): Response
    {
        return $this->render('GestionDesRessourcesMateriels/equipement/InfosEquipement.html.twig', [
            'equipement' => $equipement,
        ]);
    }

    #[Route('/ModifierLEquipementN/{id}', name: 'ModifierEquipement', methods: ['GET', 'POST'])]
    public function edit(Request $request, EquipementRepository $equipementRepository,Equipement $equipement,TypeEquipementRepository $typeEquipementRepository): Response
    {
        $form = $this->createForm(EquipementType::class, $equipement);
        $form->handleRequest($request);

        $user = $this->getUser();
        if($user!=null){
            $username=$user->getUserIdentifier();
        }
        else{
            $username="Développeur";
        }
        $dateCreation=new \DateTime('@'.strtotime('now'));


        if ($form->isSubmitted() && $form->isValid()) {

            ///insertion de l image dans la base de donées et dans Le Dossier PhotosDeProfil
            $webpath=$this->params->get("kernel.project_dir").'/public/Interventions/Equipements/Images/';
            $chemin=$webpath.$_FILES['equipement']["name"]["Image"];
            $destination=move_uploaded_file($_FILES['equipement']['tmp_name']['Image'],$chemin);
            $equipement->setimage($_FILES['equipement']['name']['Image']);

            ///Insertion des Données A set en BackEnd
            $equipement->setCreerPar($username);
            $equipement->setCreerLe($dateCreation);
            $equipement->setEnable(True);
            
            $equipementRepository->add($equipement, true);

            return $this->redirectToRoute('equipement', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('GestionDesRessourcesMateriels/equipement/ModifierUnEquipement.html.twig', [
            'equipement' => $equipement,
            'equipements' => $equipementRepository->findAll(),
            'TypesEquipements'=>$typeEquipementRepository->findAll(),
            'NombreEquipements'=>count($equipementRepository->findAll()),
            'form' => $form,
        ]);
    }

    #[Route('/SupprimerLEquipementN/{id}', name: 'SupprimerEquipement', methods: ['POST','GET'])]
    public function delete(Request $request, Equipement $equipement, EquipementRepository $equipementRepository): Response
    {
        $equipementRepository->remove($equipement, true);
        return $this->redirectToRoute('equipement', [], Response::HTTP_SEE_OTHER);
    
    }
}
