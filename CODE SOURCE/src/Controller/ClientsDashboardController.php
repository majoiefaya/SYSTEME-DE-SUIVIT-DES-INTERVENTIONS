<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Client;
use App\Repository\ClientRepository;

class ClientsDashboardController extends AbstractController
{
    #[Route('/DashboardClients', name: 'ClientsDashboard')]
    public function index(): Response
    {
        return $this->render('clients_dashboard/AccueilClients.html.twig', [
            'controller_name' => 'ClientsDashboardController',
        ]);
    }

    #[Route('/ListeDesInterventionsDuClientN/{id}', name: 'ListeInterventionsClient')]
    public function ListeDesInterventionsClients(Client $client,ClientRepository $clientRepository): Response
    {
        $interventionsDuClient=$client->getIntervention();
        return $this->render('GestionDesInterventions/Intervention/ListeInterventionsClient.html.twig', [
            'controller_name' => 'ClientsDashboardController',
            'interventionsClient'=>$interventionsDuClient,
        ]);
    }
}
