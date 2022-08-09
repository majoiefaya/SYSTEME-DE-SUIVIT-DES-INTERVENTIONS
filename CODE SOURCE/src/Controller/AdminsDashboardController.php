<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\AdminRepository;
use App\Repository\ClientRepository;
use App\Repository\EmployeRepository;
use App\Repository\UtilisateurRepository;
use App\Repository\PersonnelRepository;
use App\Repository\TechnicienRepository;
use App\Repository\EquipementRepository;
use App\Repository\EquipeRepository;
use App\Repository\InterventionRepository;
use App\Repository\TypeEquipementRepository;

class AdminsDashboardController extends AbstractController
{
    #[Route('/DashboardAdmin', name: 'AdminsDashboard')]
    public function index(AdminRepository $adminRepository,ClientRepository $clientRepository,UtilisateurRepository $utilisateursRepository): Response
    {
        return $this->render('admins_dashboard/AccueilAdmins.html.twig', [
            'controller_name' => 'AdminsDashboardController',
            'admins' => $adminRepository->findAll(),
            'clients'=> $clientRepository->findAll(),
            'NombreUtilisateurs'=>count($utilisateursRepository->findAll())
        ]);
    }

    #[Route('/ListeDesUtilisateurs', name: 'ListeUtilisateurs')]
    public function ListeUser(AdminRepository $adminRepository,ClientRepository 
    $clientRepository,UtilisateurRepository $utilisateursRepository,EmployeRepository
    $employeRepository,PersonnelRepository $personnelRepository,TechnicienRepository $technicienRepository,
    EquipeRepository $equipeRepository): Response
    {
        return $this->render('admins_dashboard/ListeUtilisateurs.html.twig', [
            'admins' => $adminRepository->findAll(),
            'employes'=>$employeRepository->findAll(),
            'personnels' => $personnelRepository->findAll(),
            'techniciens' => $technicienRepository->findAll(),
            'clients'=> $clientRepository->findAll(),
            'equipes' => $equipeRepository->findAll(),
            
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
