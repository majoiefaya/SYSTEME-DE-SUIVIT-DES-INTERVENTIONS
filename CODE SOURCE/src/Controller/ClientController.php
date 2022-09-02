<?php

namespace App\Controller;

use App\Entity\Client;
use App\Form\ClientType;
use App\Repository\ClientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[Route('/client')]
class ClientController extends AbstractController
{
        
    private $params;

    public function __construct(ParameterBagInterface $params)
    {
        $this->params=$params;
    }


    #[Route('/', name: 'client', methods: ['GET'])]
    public function index(ClientRepository $clientRepository): Response
    {
        return $this->render('client/index.html.twig', [
            'clients' => $clientRepository->findAll(),
        ]);
    }

    #[Route('/AjouterUnClient', name: 'AjouterClient', methods: ['GET', 'POST'])]
    public function new(Request $request, ClientRepository $clientRepository,UserPasswordHasherInterface $passwordhash): Response
    {
        $client = new Client();
        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);

        $user = $this->getUser();
        if($user!=null){
            $username=$user->getUserIdentifier();
        }
        else{
            $username="Le Client";
        }
        $bytes = random_bytes(2);
        $Uuid=bin2hex($bytes);

        $dateCreation=new \DateTime('@'.strtotime('now'));
        if ($form->isSubmitted() && $form->isValid()) {

            ///Hash Du Mot De Passe
            $MotDePasseCripte=$passwordhash->hashPassword($client,$client->getPassword());
            $client->setpassword($MotDePasseCripte);

            ///insertion de l image dans la base de donées et dans Le Dossier PhotosDeProfil
            $webpath=$this->params->get("kernel.project_dir").'/public/Clients/PhotosDeProfil/';
            $chemin=$webpath.$_FILES['client']["name"]["Image"];
            $destination=move_uploaded_file($_FILES['client']['tmp_name']['Image'],$chemin);
            $client->setimage($_FILES['client']['name']['Image']);

            ///Insertion des Données A set en BackEnd
            $client->setCreerPar($username);
            $client->setCode($Uuid);
            $client->setCreerLe($dateCreation);
            $client->setActive(True);
            $client->setEnable(True);
            $client->setRoles(["ROLE_CLIENT"]);


            $clientRepository->add($client, true);

            return $this->redirectToRoute('ListeUtilisateurs', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('clients_dashboard/client/AjouterUnClient.html.twig', [
            'client' => $client,
            'form' => $form,
        ]);
    }

    #[Route('/SauvegarderLesInfosDuClientN/{id}', name: 'SauvegardeInfos', methods: ['GET', 'POST'])]
    public function SauvegardeInformationsProfil(Request $request,Client $client,ClientRepository $clientRepository,UserPasswordHasherInterface $passwordhash): Response
    {
        $Nom=$request->request->get('nom');
        $prenom=$request->request->get('prenom');
        $Age=$request->request->get('age');
        $Sexe=$request->request->get('sexe');
        $Adresse=$request->request->get('address');
        $NumTel=$request->request->get('phone');
        $Email=$request->request->get('email');
        $dateModification=new \DateTime('@'.strtotime('now'));

        ///insertion de l image dans la base de donées et dans Le Dossier PhotosDeProfil
        $webpath=$this->params->get("kernel.project_dir").'/public/Clients/PhotosDeProfil/';
        $chemin=$webpath.$_FILES['client']["name"]["Image"];
        $destination=move_uploaded_file($_FILES['client']['tmp_name']['Image'],$chemin);
        $client->setimage($_FILES['client']['name']['Image']);
      
        $client->setModifierPar($client->getNom());
        $client->setModifierLe($dateModification);

        $clientRepository->add($client, true);

        return $this->redirectToRoute('InfosClient', [], Response::HTTP_SEE_OTHER);

    }
    #[Route('/ModifierLesInformationsDuClientN/{id}', name: 'ModifierInfosClient', methods: ['GET', 'POST'])]
    public function ModifierInfosClient(Request $request, Client $client, ClientRepository $clientRepository,UserPasswordHasherInterface $passwordhash): Response
    {
        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);

        $TelNumber=$request->request->get('phone');
        $dateModification=new \DateTime('@'.strtotime('now'));
        if ($form->isSubmitted() && $form->isValid()) {

            ///Hash Du Mot De Passe
            $MotDePasseCripte=$passwordhash->hashPassword($client,$client->getPassword());
            $client->setpassword($MotDePasseCripte);

            ///insertion de l image dans la base de donées et dans Le Dossier PhotosDeProfil
            $webpath=$this->params->get("kernel.project_dir").'/public/Clients/PhotosDeProfil/';
            $chemin=$webpath.$_FILES['client']["name"]["Image"];
            $destination=move_uploaded_file($_FILES['client']['tmp_name']['Image'],$chemin);
            $client->setimage($_FILES['client']['name']['Image']);

            ///Insertion des Données A set en BackEnd
            $client->setModifierPar($client->getNom());
            $client->setModifierLe($dateModification);

            $clientRepository->add($client, true);

            return $this->redirectToRoute('ModifierInfosClient', [
            'id'=>$client->getId(),
            'form'=>$form,
            'msg'=>"Modification Bien Enregistrées"],
             Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('clients_dashboard/client/InfosClient.html.twig', [
            'client' => $client,
            'form' => $form,
        ]);
        
    }
    #[Route('/AfficherLesInformationsDuClientN/{id}', name: 'InfosClient', methods: ['GET'])]
    public function InfosClient(Client $client): Response
    {
        return $this->render('clients_dashboard/client/InfosClient.html.twig', [
            'client' => $client,
        ]);
    }

    #[Route('/ModifierLeClientN/{id}', name: 'ModifierClient', methods: ['GET', 'POST'])]
    public function edit(Request $request, Client $client, ClientRepository $clientRepository,UserPasswordHasherInterface $passwordhash): Response
    {
        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);

        $user = $this->getUser();
        if($user!=null){
            $username=$user->getUserIdentifier();
        }
        else{
            $username="Le Client";
        }
        $bytes = random_bytes(2);
        $Uuid=bin2hex($bytes);

        $dateCreation=new \DateTime('@'.strtotime('now'));
        if ($form->isSubmitted() && $form->isValid()) {

            ///Hash Du Mot De Passe
            $MotDePasseCripte=$passwordhash->hashPassword($client,$client->getPassword());
            $client->setpassword($MotDePasseCripte);

            ///insertion de l image dans la base de donées et dans Le Dossier PhotosDeProfil
            $webpath=$this->params->get("kernel.project_dir").'/public/Clients/PhotosDeProfil/';
            $chemin=$webpath.$_FILES['client']["name"]["Image"];
            $destination=move_uploaded_file($_FILES['client']['tmp_name']['Image'],$chemin);
            $client->setimage($_FILES['client']['name']['Image']);

            ///Insertion des Données A set en BackEnd
            $client->setModifierPar($username);
            $client->setCode($Uuid);
            $client->setModifierLe($dateCreation);
            $client->setEnable(True);
            $client->setRoles(["ROLE_CLIENT"]);


            $clientRepository->add($client, true);

            return $this->redirectToRoute('ListeUtilisateurs', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('clients_dashboard/client/ModifierUnClient.html.twig', [
            'client' => $client,
            'form' => $form,
        ]);
    }

    #[Route('/SupprimerLeClientN/{id}', name: 'SupprimerClient', methods: ['GET'])]
    public function delete(Request $request, Client $client, ClientRepository $clientRepository): Response
    {
        $user = $this->getUser();
        $clientRepository->remove($client, true);
        
        if ($user->getRoles()==['ROLE_CLIENT']){
            $this->container->get('security.token_storage')->setToken(null);
            return $this->redirectToRoute('Login', [], Response::HTTP_SEE_OTHER);
        }else{
            return $this->redirectToRoute('ListeUtilisateurs', [], Response::HTTP_SEE_OTHER);
        }
        
    }

    #[Route('/ActivationDesactivationClientN/{id}', name: 'ADClient', methods: ['GET','POST'])]
    public function ActiverDesactiverClient(Request $request, Client $client, ClientRepository $clientRepository): Response
    {
        $Statut=$client->isEnable();
        if($Statut==True){
            $client->setEnable(False);
        }else if ($Statut==False){
            $client->setEnable(True);
        }
        
        return $this->redirectToRoute('ListeUtilisateurs', [], Response::HTTP_SEE_OTHER);
        
        
    }
}
