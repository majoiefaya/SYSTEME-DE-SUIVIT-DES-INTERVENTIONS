<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Technicien;
use App\Entity\Equipe;
use App\Entity\Employe;
use App\Entity\EmployeRepository;
use App\Repository\EquipeRepository;
use App\Repository\RapportRepository;
use App\Repository\TechnicienRepository;
use App\Repository\AdminRepository;

class EmployesDashboardController extends AbstractController
{
    #[Route('/DashboardEmployes', name: 'EmployesDashboard')]
    public function index(): Response
    {
        return $this->render('employes_dashboard/AccueilEmployes.html.twig', [
            'controller_name' => 'EmployesDashboardController',
        ]);
    }

    #[Route('/ListeDesInterventionsDuTechnicienN/{id}', name: 'ListeInterventionsTechnicien')]
    public function ListeDesInterventionsDuTechnicien(Equipe $Equipe,EquipeRepository $equipeRepository): Response
    {
        $interventions=$Equipe->getIntervention();
        return $this->render('GestionDesInterventions/Intervention/ListeInterventionsTechnicien.html.twig', [
            'controller_name' => 'TechTechniciensDashboardController',
            'interventions'=>$interventions
        ]);
    }

    #[Route('/ListeDesEquipesDuTechnicienN/{id}', name: 'ListeEquipesTechnicien')]
    public function ListeDesEquipesDuTechnicien(Technicien $technicien,TechnicienRepository $TechnicienRepository): Response
    {
        $EquipesDuTechTechnicien=$technicien->getEquipes();
        return $this->render('GestionDesInterventions/Intervention/ListeEquipesTechnicien.html.twig', [
            'Equipes'=> $EquipesDuTechTechnicien,
        ]);
    }

    #[Route('/RapportsDeLEmployeN/{id}', name: 'RapportsEmploye')]
    public function ListeDesRapportsDuTechniciens(Employe $employe,RapportRepository $rapportRepository,AdminRepository $adminRepository): Response
    {
        $rapports=$employe->getRapport();
        $id=$employe->getId();
        return $this->render('Rapport/ListeDesRapportsDeLEmploye.html.twig', [
            'rapports'=> $rapports,
            'NombreTotalRapports'=>count($rapports),
            'NombreLu'=>count($rapportRepository->ListeRapportsLueEmploye($id)),
            'NombreNonLu'=>count($rapportRepository->ListeRapportsNonLueEmploye($id)),
            'NombreSupprimé'=>count($rapportRepository->ListeRapportsNonSupprimésEmploye($id)),
            'admins'=>$adminRepository->findAll()
        ]);
    }
}
