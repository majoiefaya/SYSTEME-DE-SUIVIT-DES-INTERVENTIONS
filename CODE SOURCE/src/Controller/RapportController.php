<?php

namespace App\Controller;

use App\Entity\Rapport;
use App\Entity\Intervention;
use App\Form\RapportType;
use App\Entity\Employe;
use App\Repository\RapportRepository;
use App\Repository\AdminRepository;
use App\Repository\UtilisateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

#[Route('/rapport')]
class RapportController extends AbstractController
{

    
    private $params;

    public function __construct(ParameterBagInterface $params)
    {
        $this->params=$params;
    }

    #[Route('/', name: 'rapport', methods: ['GET'])]
    public function index(RapportRepository $rapportRepository): Response
    {
        return $this->render('rapport/ListeRapports.html.twig', [
            'rapports' => $rapportRepository->ListeRapportsNonSupprimés(),
            'NombreTotalRapports'=>count($rapportRepository->ListeRapportsNonSupprimés()),
            'NombreLu'=>count($rapportRepository->ListeRapportsLue()),
            'NombreNonLu'=>count($rapportRepository->ListeRapportsNonLue()),
            'NombreSupprimé'=>count($rapportRepository->ListeRapportsSupprimés())
        ]);
    }

    #[Route('/ListeDesRapportsLus', name: 'RapportsLus', methods: ['GET'])]
    public function RapportsLus(RapportRepository $rapportRepository): Response
    {
        return $this->render('rapport/ListeDesRapportsLus.html.twig', [
            'rapports' => $rapportRepository->ListeRapportsLue(),
            'NombreTotalRapports'=>count($rapportRepository->ListeRapportsNonSupprimés()),
            'NombreLu'=>count($rapportRepository->ListeRapportsLue()),
            'NombreNonLu'=>count($rapportRepository->ListeRapportsNonLue()),
            'NombreSupprimé'=>count($rapportRepository->ListeRapportsSupprimés())
        ]);
    }


    #[Route('/ListeDesRapportsLusEmployeN/{id}', name: 'RapportsLusEmploye', methods: ['GET'])]
    public function RapportsLusEmploye(RapportRepository $rapportRepository,Employe $employe,AdminRepository $adminRepository): Response
    {
        $id=$employe->getId();
        $rapports=$employe->getRapport();
        return $this->render('rapport/ListeDesRapportsLusEmploye.html.twig', [
            'rapports' => $rapportRepository->ListeRapportsLueEmploye($id),
            'NombreTotalRapports'=>count($rapports),
            'NombreLu'=>count($rapportRepository->ListeRapportsLueEmploye($id)),
            'NombreNonLu'=>count($rapportRepository->ListeRapportsNonLueEmploye($id)),
            'NombreSupprimé'=>count($rapportRepository->ListeRapportsNonSupprimésEmploye($id)),
            'admins'=>$adminRepository->findAll()
        ]);
    }


    #[Route('/ListeDesRapportsNonLus', name: 'RapportsNonLus', methods: ['GET'])]
    public function RapportsNonLus(RapportRepository $rapportRepository): Response
    {
        return $this->render('rapport/ListeDesRapportsNonLus.html.twig', [
            'rapports' => $rapportRepository->ListeRapportsNonLue(),
            'NombreTotalRapports'=>count($rapportRepository->ListeRapportsNonSupprimés()),
            'NombreLu'=>count($rapportRepository->ListeRapportsLue()),
            'NombreNonLu'=>count($rapportRepository->ListeRapportsNonLue()),
            'NombreSupprimé'=>count($rapportRepository->ListeRapportsSupprimés())
        ]);
    }

    #[Route('/ListeDesRapportsNonLusDeLEmployeN/{id}', name: 'RapportsNonLusEmploye', methods: ['GET'])]
    public function RapportsNonLusEmploye(RapportRepository $rapportRepository,Employe $employe,AdminRepository $adminRepository): Response
    {
        $id=$employe->getId();
        $rapports=$employe->getRapport();
        return $this->render('rapport/ListeRapportsNonLusEmploye.html.twig', [
            'rapports' => $rapportRepository->ListeRapportsNonLueEmploye($id),
            'NombreTotalRapports'=>count($rapports),
            'NombreLu'=>count($rapportRepository->ListeRapportsLueEmploye($id)),
            'NombreNonLu'=>count($rapportRepository->ListeRapportsNonLueEmploye($id)),
            'NombreSupprimé'=>count($rapportRepository->ListeRapportsSupprimésEmploye($id)),
            'admins'=>$adminRepository->findAll()
        ]);
    }
    


    #[Route('/ListeDesRapportsSupprimés', name: 'RapportsSupprimés', methods: ['GET'])]
    public function RapportsSupprimés(RapportRepository $rapportRepository): Response
    {
        return $this->render('rapport/ListeDesRapportsSupprimés.html.twig', [
            'rapports' => $rapportRepository->ListeRapportsSupprimés(),
            'NombreTotalRapports'=>count($rapportRepository->ListeRapportsNonSupprimés()),
            'NombreLu'=>count($rapportRepository->ListeRapportsLue()),
            'NombreNonLu'=>count($rapportRepository->ListeRapportsNonLue()),
            'NombreSupprimé'=>count($rapportRepository->ListeRapportsSupprimés())
        ]);
    }


    #[Route('/ListeDesRapportsSupprimésDeLEmployeN/{id}', name: 'RapportsSupprimésEmployé', methods: ['GET'])]
    public function RapportsSupprimésTechnicien(AdminRepository $adminRepository,RapportRepository $rapportRepository,Employe $employe): Response
    {
        $id=$employe->getId();
        $rapports=$employe->getRapport();
        return $this->render('rapport/ListeDesRapportsSupprimésEmploye.html.twig', [
            'rapports' => $rapportRepository->ListeRapportsSupprimésEmploye($id),
            'NombreTotalRapports'=>count($rapports),
            'NombreLu'=>count($rapportRepository->ListeRapportsLueEmploye($id)),
            'NombreNonLu'=>count($rapportRepository->ListeRapportsNonLueEmploye($id)),
            'NombreSupprimé'=>count($rapportRepository->ListeRapportsSupprimésEmploye($id)),
            'admins'=>$adminRepository->findAll()
        ]);
    }





    #[Route('/MarquerLueLeRapportN/{id}', name: 'MarquerRapport', methods: ['GET', 'POST'])]
    public function MarquerRapport(Request $request, RapportRepository $rapportRepository, Rapport $rapport): Response
    {
        $rapport->setStatutRapport("Lu");
        $rapportRepository->add($rapport, true);
        return $this->redirectToRoute('rapport', [], Response::HTTP_SEE_OTHER);
    }
        
    #[Route('/AjouterUnRapport', name: 'AjouterRapport', methods: ['GET', 'POST'])]
    public function new(Request $request, RapportRepository $rapportRepository): Response
    {
        $rapport = new Rapport();
        $form = $this->createForm(RapportType::class, $rapport);
        $form->handleRequest($request);

        $ContenuRapport=$request->request->get('contenu');
        $SujetRapport=$request->request->get('sujet');
        $user = $this->getUser();
        if($user!=null){
            $username=$user->getUserIdentifier();
        }
        else{
            $username="NonIdentifié";
        }

        $Date=new \DateTime('@'.strtotime('now'));

        if ($form->isSubmitted() && $form->isValid()) {
             ///insertion du fichier dans la base de donées et dans Le Dossier Fichier
             $webpath=$this->params->get("kernel.project_dir").'/public/Rapports/Fichiers/';
             $chemin=$webpath.$_FILES['rapport']["name"]["fichier"];
             $destination=move_uploaded_file($_FILES['rapport']['tmp_name']['fichier'],$chemin);
             $rapport->setFichier($_FILES['rapport']['name']['fichier']);
 
             ///Insertion des Données A set en BackEnd
             $rapport->setContenu($ContenuRapport);
             $rapport->setSujetRapport($SujetRapport);
             $rapport->setCreerPar($username);
             $rapport->setCreerLe($Date);
             $rapport->setDateEnvoi($Date);
             $rapport->setEmploye($user);
             $rapport->setStatutRapport("NonLu");
             $rapport->setEnable(True);

            $rapportRepository->add($rapport, true);

            return $this->redirectToRoute('EmployesDashboard', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('rapport/AjouterUnRapport.html.twig', [
            'rapport' => $rapport,
            'form' => $form,
        ]);
    }

    #[Route('/AjouterUnRapportALInterventionN/{id}', name: 'AjouterRapportIntervention', methods: ['GET', 'POST'])]
    public function AjouterRapportIntervention(Request $request, RapportRepository $rapportRepository,Intervention $intervention): Response
    {
        $rapport = new Rapport();
        $form = $this->createForm(RapportType::class, $rapport);
        $form->handleRequest($request);

        $ContenuRapport=$request->request->get('contenu');
        $SujetRapport=$request->request->get('sujet');
        $user = $this->getUser();
        if($user!=null){
            $username=$user->getUserIdentifier();
        }
        else{
            $username="NonIdentifié";
        }

        $Date=new \DateTime('@'.strtotime('now'));

        if ($form->isSubmitted() && $form->isValid()) {
             ///insertion du fichier dans la base de donées et dans Le Dossier Fichier
             $webpath=$this->params->get("kernel.project_dir").'/public/Rapports/Fichiers/';
             $chemin=$webpath.$_FILES['rapport']["name"]["fichier"];
             $destination=move_uploaded_file($_FILES['rapport']['tmp_name']['fichier'],$chemin);
             $rapport->setFichier($_FILES['rapport']['name']['fichier']);
 
             ///Insertion des Données A set en BackEnd
             $rapport->setContenu($ContenuRapport);
             $rapport->setSujetRapport($SujetRapport);
             $rapport->setCreerPar($username);
             $rapport->setCreerLe($Date);
             $rapport->setDateEnvoi($Date);
             $rapport->setEmploye($user);
             $rapport->setIntervention($intervention);
             $rapport->setStatutRapport("NonLu");
             $rapport->setEnable(True);

            $rapportRepository->add($rapport, true);

            return $this->redirectToRoute('EmployesDashboard', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('rapport/AjouterUnRapport.html.twig', [
            'rapport' => $rapport,
            'form' => $form,
        ]);
    }


    #[Route('/InfosDuRapportN/{id}', name: 'InfosRapport', methods: ['GET'])]
    public function show(Rapport $rapport, RapportRepository $rapportRepository): Response
    {
        $DateEnvoieRapport=$rapport->getDateEnvoi();
        $dateActuelle=new \DateTime('@'.strtotime('now'));
        $diff = $dateActuelle->diff($DateEnvoieRapport);
        $NbreHeuresActuelle = $diff->h;
        $NbreHeuresActuelle = $NbreHeuresActuelle + ($diff->days*24);
        
        $NbSecondes=$NbreHeuresActuelle*60;
        $dtF = new \DateTime('@0');
        $dtT = new \DateTime("@$NbSecondes");
        $Durrée=$dtF->diff($dtT)->format('%a days, %h hours, %i minutes and %s seconds');
        if($rapport->getEmploye()->isActive()){
            $Disponibilité=1;
        }else{
            $Disponibilité=0;
        }
        return $this->render('rapport/InfosRapport.html.twig', [
            'rapport' => $rapport,
            'rapports' => $rapportRepository->ListeRapportsNonLue(),
            'NombreTotalRapports'=>count($rapportRepository->ListeRapportsNonSupprimés()),
            'NombreLu'=>count($rapportRepository->ListeRapportsLue()),
            'NombreNonLu'=>count($rapportRepository->ListeRapportsNonLue()),
            'NombreSupprimé'=>count($rapportRepository->ListeRapportsSupprimés()),
            'Durrée'=> $Durrée,
            'Disponibilité'=>$Disponibilité,
            'dateActu'=>$dateActuelle
        ]);
    }


    
    #[Route('/EmployeInfosDuRapportN/{id}', name: 'InfosRapportEmploye', methods: ['GET'])]
    public function InfosRapportEmploye(Rapport $rapport, RapportRepository $rapportRepository): Response
    {
        $DateEnvoieRapport=$rapport->getDateEnvoi();
        $dateActuelle=new \DateTime('@'.strtotime('now'));
        $diff = $dateActuelle->diff($DateEnvoieRapport);
        $NbreHeuresActuelle = $diff->h;
        $NbreHeuresActuelle = $NbreHeuresActuelle + ($diff->days*24);
        return $this->render('rapport/InfosRapportEmploye.html.twig', [
            'rapport' => $rapport,
            'rapports' => $rapportRepository->ListeRapportsNonLue(),
            'NombreTotalRapports'=>count($rapportRepository->ListeRapportsNonSupprimés()),
            'NombreLu'=>count($rapportRepository->ListeRapportsLue()),
            'NombreNonLu'=>count($rapportRepository->ListeRapportsNonLue()),
            'NombreSupprimé'=>count($rapportRepository->ListeRapportsSupprimés()),
            'Durrée'=>$NbreHeuresActuelle
        ]);
    }

    #[Route('/ModifierLeRapportN/{id}', name: 'ModifierRapport', methods: ['GET', 'POST'])]
    public function edit(Request $request, Rapport $rapport, RapportRepository $rapportRepository): Response
    {
        $form = $this->createForm(RapportType::class, $rapport);
        $form->handleRequest($request);

        $user = $this->getUser();
        if($user!=null){
            $username=$user->getUserIdentifier();
        }
        else{
            $username="NonIdentifié";
        }

        $dateCreation=new \DateTime('@'.strtotime('now'));

        if ($form->isSubmitted() && $form->isValid()) {
             ///insertion du fichier dans la base de donées et dans Le Dossier Fichier
             $webpath=$this->params->get("kernel.project_dir").'/public/Rapports/Fichiers/';
             $chemin=$webpath.$_FILES['rapport']["name"]["fichier"];
             $destination=move_uploaded_file($_FILES['rapport']['tmp_name']['fichier'],$chemin);
             $rapport->setFichier($_FILES['rapport']['name']['fichier']);
 
             ///Insertion des Données A set en BackEnd
             $rapport->setCreerPar($username);
             $rapport->setCreerLe($dateCreation);
             $rapport->setEnable(True);

            $rapportRepository->add($rapport, true);

            return $this->redirectToRoute('rapport', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('rapport/ModifierUnRapport.html.twig', [
            'rapport' => $rapport,
            'form' => $form,
        ]);
    }

    
    #[Route('/EnvoyerUnRapportParMailEmployeN/{id}', name: 'EnvoyerRapportMail', methods: ['POST','GET'])]
    public function RapportMail(Employe $employe,MailerInterface $mailer,Request $request,UtilisateurRepository $utilisateurRepository,AdminRepository $adminRepository): Response
    {
        $NomAdmin=$request->request->get('param');
        $ContenuRapport=$request->request->get('contenu');
        $SujetRapport=$request->request->get('sujet');
        $DateEnvoie=new \DateTime('@'.strtotime('now'));
        if (isset($NomAdmin)) {
            if ($utilisateurRepository->findOneBy(["Nom"=>$NomAdmin])) {
                $admin=$utilisateurRepository->findOneBy(["Nom"=>$NomAdmin]);
                $email = (new TemplatedEmail())
                ->from($employe->getEmail())
                ->to($admin->getEmail())
                ->subject($SujetRapport)
                ->text('Rapport')
                ->htmlTemplate('emails/EnvoieDUnRapportParMail.html.twig')
                ->context([
                    'Nom' =>$employe->getNom(),
                    'Prenom'=>$employe->getPrenom(),
                    'contenu'=>$ContenuRapport,
                    'DateEnvoieRapport'=>$DateEnvoie,
                ]);
    
                $mailer->send($email);
                
            }
        }
        

        return $this->redirectToRoute('rapport', [], Response::HTTP_SEE_OTHER);
    }


    #[Route('/SupprimerLeRapportN/{id}', name: 'SupprimerRapport', methods: ['POST','GET'])]
    public function delete(Request $request, Rapport $rapport, RapportRepository $rapportRepository): Response
    {
        $user = $this->getUser();
        $rapport->setEnable(False);
        $rapportRepository->add($rapport,true);
        if ($user->getRoles()==['ROLE_ADMIN']) {
            return $this->redirectToRoute('rapport', [], Response::HTTP_SEE_OTHER);
        }else{
            return $this->redirectToRoute('EmployesDashboard', [], Response::HTTP_SEE_OTHER);
        }
    }

    #[Route('/RecupererLeRapportN/{id}', name: 'RecupererRapport', methods: ['POST','GET'])]
    public function RecupererRapport(Request $request, Rapport $rapport, RapportRepository $rapportRepository): Response
    {
        $user = $this->getUser();
        $rapport->setEnable(True);
        $rapportRepository->add($rapport,true);
        if ($user->getRoles()==['ROLE_ADMIN']) {
            return $this->redirectToRoute('rapport', [], Response::HTTP_SEE_OTHER);
        }else{
            return $this->redirectToRoute('EmployesDashboard', [], Response::HTTP_SEE_OTHER);
        }
    }

    #[Route('/SupprimerDefinitivementLeRapportN/{id}', name: 'SupprimerDefRapport', methods: ['POST','GET'])]
    public function SupprimerDef(Request $request, Rapport $rapport, RapportRepository $rapportRepository): Response
    {
       
        $user = $this->getUser();
        $rapportRepository->remove($rapport, true);
        
        if ($user->getRoles()==['ROLE_ADMIN']){
            return $this->redirectToRoute('RapportsSupprimés', [], Response::HTTP_SEE_OTHER);
        }else{
            return $this->redirectToRoute('EmployesDashboard', [], Response::HTTP_SEE_OTHER);
        }
    }
}
