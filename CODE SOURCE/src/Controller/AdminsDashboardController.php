<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\AdminRepository;
use App\Repository\ClientRepository;
use App\Repository\CommentaireRepository;
use App\Repository\EmployeRepository;
use App\Repository\UtilisateurRepository;
use App\Repository\PersonnelRepository;
use App\Repository\TechnicienRepository;
use App\Repository\EquipementRepository;
use App\Repository\EquipeRepository;
use App\Repository\InterventionRepository;
use App\Repository\TypeEquipementRepository;
use App\Repository\RapportRepository;
use App\Repository\TacheRepository;

class AdminsDashboardController extends AbstractController
{
    #[Route('/DashboardAdmin', name: 'AdminsDashboard')]
    public function index(AdminRepository $adminRepository,ClientRepository $clientRepository,
    TacheRepository $tacheRepository,RapportRepository $rapportRepository,
    UtilisateurRepository $utilisateursRepository,EquipeRepository $equipeRepository,
    CommentaireRepository $commentaireRepository,
    EmployeRepository $employeRepository,
    TechnicienRepository $technicienRepository,
    InterventionRepository $interventionRepository): Response
    {
        $dateActuelle=new \DateTime('@'.strtotime('now'));
        $Interventions=$interventionRepository->findAll();
        $NombreTotalInterventions=count($Interventions);
        $NbreInterventionsTerminées=0;
        $NbreInterventionsEnCours=0;
        $DatesInterventions=[];
        foreach($Interventions as $intervention){
            if($intervention->getDateFinIntervention()< $dateActuelle){
                $NbreInterventionsTerminées+=1;
            }
        }

        foreach($Interventions as $intervention){
            if($dateActuelle<$intervention->getDateFinIntervention() and $dateActuelle>$intervention->getDateDebutIntervention()){
                $NbreInterventionsEnCours+=1;
            }
        }
        foreach($Interventions as $intervention){
            $DateIntervention = $intervention->getDateDebutIntervention();
            $DateIntervention = $DateIntervention->format('Y-m-d H:i:s');
            $DatesInterventions[]=$DateIntervention;
        }

        if($NombreTotalInterventions<=0){
            $PourcentageDeTouteLesInterventions=0;
        }else{
            $PourcentageDeTouteLesInterventions=($NbreInterventionsTerminées*100)/$NombreTotalInterventions;
        }
      
        $NbreInterventionsNonDebutées=$NombreTotalInterventions-( $NbreInterventionsTerminées+$NbreInterventionsEnCours);
        return $this->render('admins_dashboard/AccueilAdmins.html.twig', [
            'controller_name' => 'AdminsDashboardController',
            'admins' => $adminRepository->findAll(),
            'clients'=> $clientRepository->findAll(),
            'NombreUtilisateurs'=>count($utilisateursRepository->findAll()),
            'NewEmployesAccountInvalidate'=>$employeRepository->findAllEmployesInactive(),
            'PourcentageDeTouteLesInterventions'=>$PourcentageDeTouteLesInterventions,
            'Equipes'=>$equipeRepository->findAll(),
            'Interventions'=>$interventionRepository->findAll(),
            'Rapports'=>$rapportRepository->findAll(),
            'NbreInterventionsTerminées'=>$NbreInterventionsTerminées,
            'NbreInterventionsEnCours'=>$NbreInterventionsEnCours,
            'NbreInterventionsNonDebutées'=> $NbreInterventionsNonDebutées,
            'DatesInterventions'=>json_encode($DatesInterventions),
            'tachesRecentes'=>$tacheRepository->TachesRecentes(),
            'temoignagesRecents'=>$commentaireRepository->TemoignagesRecents(),
            'techniciens'=> $technicienRepository->findAll()

        ]);
    }

    #[Route('/ListeDesUtilisateurs', name: 'ListeUtilisateurs')]
    public function ListeUser(AdminRepository $adminRepository,ClientRepository 
    $clientRepository,UtilisateurRepository $utilisateursRepository,EmployeRepository
    $employeRepository,PersonnelRepository $personnelRepository,TechnicienRepository $technicienRepository,
    EquipeRepository $equipeRepository): Response
    {
        return $this->render('admins_dashboard/ListeUtilisateurs.html.twig', [
            'admins' => $adminRepository->findBy([],['Nom'=>'ASC']),
            'employes'=>$employeRepository->findBy([],['Nom'=>'ASC']),
            'personnels' => $personnelRepository->findBy([],['Nom'=>'ASC']),
            'techniciens' => $technicienRepository->findBy([],['Nom'=>'ASC']),
            'clients'=> $clientRepository->findBy([],['Nom'=>'ASC']),
            'equipes' => $equipeRepository->findBy([],['NomEquipe'=>'ASC']),
            
            'NombreUtilisateurs'=>count($utilisateursRepository->findAll()),
            
        ]);
    }

    #[Route('/ListeDesEquipements', name: 'ListeEquipements')]
    public function ListeTools(TypeEquipementRepository $typeEquipementRepository,EquipementRepository $equipementRepository, UtilisateurRepository $utilisateursRepository): Response
    {
        return $this->render('GestionDesRessourcesMateriels/equipement/ListeEquipements.html.twig', [
            'equipements' => $equipementRepository->findAll(),
            'TypesEquipements'=>$typeEquipementRepository->findAll(),
            'NombreEquipements'=>count($equipementRepository->findAll())
        ]);
    }

    #[Route('/ListeDesInterventionsAdmin', name: 'ListeInterventionsAdmin')]
    public function ListeInterventions(InterventionRepository $interventionRepository,EquipementRepository $equipementRepository): Response
    {
        return $this->render('GestionDesInterventions/intervention/ListeInterventionsAdmin.html.twig', [
            'equipements' => $equipementRepository->findAll(),
            'interventions' => $interventionRepository->findAll(),
            'NombreInterventions'=>count($interventionRepository->findAll())
        ]);
    }

    #[Route('/DesactiverSignUpEmploye', name: 'DesactiverSignUpEmploye')]
    public function DesactiverSignUpEmploye(): Response
    {
        return $this->redirectToRoute('AdminsDashboard',[]);
    }

    
}
