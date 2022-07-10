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

class AdminsDashboardController extends AbstractController
{
    #[Route('/DashboardAdmin', name: 'AdminsDashboard')]
    public function index(AdminRepository $adminRepository,ClientRepository $clientRepository,UtilisateurRepository $utilisateursRepository): Response
    {
        return $this->render('admins_dashboard/index.html.twig', [
            'controller_name' => 'AdminsDashboardController',
            'admins' => $adminRepository->findAll(),
            'clients'=> $clientRepository->findAll(),
            'NombreUtilisateurs'=>count($utilisateursRepository->findAll())
        ]);
    }

    #[Route('/ListeDesUtilisateurs', name: 'ListeUtilisateurs')]
    public function ListeUser(AdminRepository $adminRepository,ClientRepository $clientRepository,UtilisateurRepository $utilisateursRepository,EmployeRepository $employeRepository,PersonnelRepository $personnelRepository,TechnicienRepository $technicienRepository): Response
    {
        return $this->render('admins_dashboard/ListeUtilisateurs.html.twig', [
            'admins' => $adminRepository->findAll(),
            'employes'=>$employeRepository->findAll(),
            'personnels' => $personnelRepository->findAll(),
            'techniciens' => $technicienRepository->findAll(),
            'clients'=> $clientRepository->findAll(),
            'NombreUtilisateurs'=>count($utilisateursRepository->findAll()),
            
        ]);
    }
    
}
