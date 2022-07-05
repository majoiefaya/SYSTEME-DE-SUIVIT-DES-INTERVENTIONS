<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminsDashboardController extends AbstractController
{
    #[Route('/DashboardAdmin', name: 'AdminsDashboard')]
    public function index(): Response
    {
        return $this->render('admins_dashboard/index.html.twig', [
            'controller_name' => 'AdminsDashboardController',
        ]);
    }
}
