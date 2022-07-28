<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EmployesDashboardController extends AbstractController
{
    #[Route('/DashboardEmployes', name: 'EmployesDashboard')]
    public function index(): Response
    {
        return $this->render('employes_dashboard/AccueilEmployes.html.twig', [
            'controller_name' => 'EmployesDashboardController',
        ]);
    }
}
