<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClientsDashboardController extends AbstractController
{
    #[Route('/DashboardClients', name: 'ClientsDashboard')]
    public function index(): Response
    {
        return $this->render('clients_dashboard/AccueilClients.html.twig', [
            'controller_name' => 'ClientsDashboardController',
        ]);
    }
}
