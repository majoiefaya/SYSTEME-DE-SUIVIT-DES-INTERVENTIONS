<?php

namespace App\Controller;

use App\Entity\Client;
use App\Form\ClientType2;
use App\Repository\ClientRepository;
use App\Entity\Technicien;
use App\Entity\Employe;
use App\Repository\EmployeRepository;
use App\Form\TechnicienType2;
use App\Repository\TechnicienRepository;
use App\Entity\Personnel;
use App\Form\PersonnelType2;
use App\Repository\PersonnelRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Goxens\Goxens;

class AuthController extends AbstractController
{

    private $params;

    public function __construct(ParameterBagInterface $params)
    {
        $this->params=$params;
    }


    #[Route('/Connexion', name: 'Login')]
    public function Authentification(AuthenticationUtils $authenticationUtils): Response
    {
        $error=$authenticationUtils->getLastAuthenticationError();
        $LastUsername=$authenticationUtils->getLastUsername();
        return $this->render('auth/Authentification.html.twig',[
            'error'=>$error,
            'LastUsername'=>$LastUsername
        ]);
    }


    #[Route('/ChoixDuTypeDeCompte', name: 'ChoixTypeCompte')]
    public function ChoixTypeCompte(): Response
    {
        return $this->render('auth/ChoixDuTypeDeCompte.html.twig');
    }
 
 
    #[Route('/CreationDeCompteClient', name: 'InscriptionClient')]
    public function InscriptionClient(Request $request, ClientRepository $clientRepository,UserPasswordHasherInterface $passwordhash,MailerInterface $mailer): Response
    {
        $client = new Client();
        $form = $this->createForm(ClientType2::class, $client);
        $form->handleRequest($request);
        $TelNumber=$request->request->get('phone');

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
            $chemin=$webpath.$_FILES['client_type2']["name"]["Image"];
            $destination=move_uploaded_file($_FILES['client_type2']['tmp_name']['Image'],$chemin);
            $client->setimage($_FILES['client_type2']['name']['Image']);

            ///Insertion des Données A set en BackEnd
            $client->setCreerPar($username);
            $client->setCode($Uuid);
            $client->setCreerLe($dateCreation);

            ///Insertion des Données En BackEnd
            $client->setTelephone($TelNumber);
            $client->setEnable(False);
            $client->setActive(True);
            $client->setRoles(["ROLE_CLIENT"]);

            ///Envoie d'Un Mail de Comfirmation
            $email = (new TemplatedEmail())
            ->from('majoiefaya@gmail.com')
            ->to($client->getEmail())
            ->subject("Comfirmation d'Inscription")
            ->text('Veuillez Confirmer votre Inscription')
            ->htmlTemplate('emails/ConfirmationDInscription.html.twig')
            ->context([
                'Nom' => $client->getNom(),
                'Prenom'=> $client->getPrenom(),
                'NumTel'=>$client->getTelephone(),
                'Age'=>$client->getAge(),
                'Adresse'=>$client->getAdresse(),
                'Sexe'=>$client->getSexe(),
                'Code'=>$Uuid,
                'DateInscription' =>  $dateCreation,
                'mail'=>$client->getEmail()
            ]);

            $mailer->send($email);


            $clientRepository->add($client, true);

            return $this->redirectToRoute('ComfirmationDeMail', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('auth/InscriptionClient.html.twig', [
            'client' => $client,
            'form' => $form,
        ]);
    }

    #[Route('/CreationDeCompteTechnicien', name: 'InscriptionTechnicien')]
    public function InscriptionTechnicien(Request $request, TechnicienRepository $technicienRepository,UserPasswordHasherInterface $passwordhash,MailerInterface $mailer): Response
    {
        $technicien = new Technicien();
        $form = $this->createForm(TechnicienType2::class, $technicien);
        $form->handleRequest($request);
        $TelNumber=$request->request->get('phone');

        $user = $this->getUser();
        if($user!=null){
            $username=$user->getUserIdentifier();
        }
        else{
            $username="Technicien";
        }
        $dateCreation=new \DateTime('@'.strtotime('now'));
        $bytes = random_bytes(2);
        $Uuid=bin2hex($bytes);

        if ($form->isSubmitted() && $form->isValid()) {
            ///Hash Du Mot De Passe
            $MotDePasseCripte=$passwordhash->hashPassword($technicien,$technicien->getPassword());
            $technicien->setpassword($MotDePasseCripte);
       
            ///insertion de l image dans la base de donées et dans Le Dossier PhotosDeProfil
            $webpath=$this->params->get("kernel.project_dir").'/public/Employes/Technicien/PhotosDeProfil/';
            $chemin=$webpath.$_FILES['technicien_type2']["name"]["Image"];
            $destination=move_uploaded_file($_FILES['technicien_type2']['tmp_name']['Image'],$chemin);
            $technicien->setimage($_FILES['technicien_type2']['name']['Image']);

        
            ///Insertion des Données A set en BackEnd
            $technicien->setCreerPar($username);
            $technicien->setCode($Uuid);
            $technicien->setCreerLe($dateCreation);
            $technicien->setEnable(False);
            $technicien->setActive(False);
            $technicien->setRoles(["ROLE_TECHNICIEN"]);
            $technicien->setTelephone($TelNumber);
    
            ///Ajout de L instance créer dans la base de données
            $technicienRepository->add($technicien, true);
            $this->addFlash('SuccessSignUp', "Compte Créer avec success.Vous Recevrez une Confirmation de La part de votre Service.Veuillez Regulierement consulter vos Mails sur:".$technicien->getEmail());
            return $this->redirectToRoute('Login', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('auth/InscriptionTechnicien.html.twig', [
            'technicien' => $technicien,
            'form' => $form,
        ]);
    }

    #[Route('/ValiderLaCreationDeCompteDeLEmployeN/{id}', name: 'ValiderCreationCompte')]
    public function ValidationCreationCompteEmploye(Employe $employe,EmployeRepository $employeRepository,MailerInterface $mailer): Response
    {
         ///Envoie d'Un Mail de Comfirmation
         $email = (new TemplatedEmail())
         ->from('majoiefaya@gmail.com')
         ->to($employe->getEmail())
         ->subject("Comfirmation d'Inscription")
         ->text('Veuillez Confirmer votre Inscription')
         ->htmlTemplate('emails/ConfirmationDInscription.html.twig')
         ->context([
             'Nom' => $employe->getNom(),
             'Prenom'=> $employe->getPrenom(),
             'NumTel'=>$employe->getTelephone(),
             'Age'=>$employe->getAge(),
             'Adresse'=>$employe->getAdresse(),
             'Sexe'=>$employe->getSexe(),
             'Code'=>$employe->getCode(),
             'DateInscription' =>  $employe->getCreerLe(),
             'mail'=>$employe->getEmail()
         ]);
         $mailer->send($email);

        $employe->setEnable(True);
        $employe->setActive(True);
        $employeRepository->add($employe,true);
        return $this->redirectToRoute('AdminsDashboard', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/RefuserLaCreationDeCompteDeLEmployeN/{id}', name: 'RefuserCreationCompte')]
    public function RefuserCreationCompteEmploye(Employe $employe,EmployeRepository $employeRepository,MailerInterface $mailer): Response
    {
         ///Envoie d'Un Mail de Comfirmation
         $email = (new TemplatedEmail())
         ->from('majoiefaya@gmail.com')
         ->to($employe->getEmail())
         ->subject("Comfirmation d'Inscription")
         ->text('Veuillez Confirmer votre Inscription')
         ->htmlTemplate('emails/ConfirmationDInscription.html.twig')
         ->context([
             'Nom' => $employe->getNom(),
             'Prenom'=> $employe->getPrenom(),
             'NumTel'=>$employe->getTelephone(),
             'Age'=>$employe->getAge(),
             'Adresse'=>$employe->getAdresse(),
             'Sexe'=>$employe->getSexe(),
             'Code'=>$employe->getCode(),
             'DateInscription' =>  $employe->getCreerLe(),
             'mail'=>$employe->getEmail()
         ]);
         $mailer->send($email);

        return $this->redirectToRoute('AdminsDashboard', [], Response::HTTP_SEE_OTHER);
    }


    #[Route('/CreationDeComptePersonnel', name: 'InscriptionPersonnel')]
    public function InscriptionPersonnel(Request $request, PersonnelRepository $personnelRepository,UserPasswordHasherInterface $passwordhash,MailerInterface $mailer): Response
    {
        $personnel=new Personnel();
        $form = $this->createForm(PersonnelType2::class,$personnel);
        $form->handleRequest($request);
        $user = $this->getUser();
        $TelNumber=$request->request->get('phone');

        if($user!=null){
            $username=$user->getUserIdentifier();
        }
        else{
            $username="Personnel";
        }
        $dateCreation=new \DateTime('@'.strtotime('now'));
        $bytes = random_bytes(2);
        $Uuid=bin2hex($bytes);

        if ($form->isSubmitted() && $form->isValid()) {
            ///Hash Du Mot De Passe
            $MotDePasseCripte=$passwordhash->hashPassword($personnel,$personnel->getPassword());
            $personnel->setpassword($MotDePasseCripte);

            ///insertion de l image dans la base de donées et dans Le Dossier PhotosDeProfil
            $webpath=$this->params->get("kernel.project_dir").'/public/Employes/Personnel/PhotosDeProfil/';
            $chemin=$webpath.$_FILES['personnel_type2']["name"]["Image"];
            $destination=move_uploaded_file($_FILES['personnel_type2']['tmp_name']['Image'],$chemin);
            $personnel->setimage($_FILES['personnel_type2']['name']['Image']);


            ///Insertion des Données A set en BackEnd
            $personnel->setCreerPar($username);
            $personnel->setCode($Uuid);
            $personnel->setCreerLe($dateCreation);
            $personnel->setEnable(False);
            $personnel->setActive(False);
            $personnel->setRoles(["ROLE_PERSONNEL"]);
            $personnel->setTelephone($TelNumber);

            ///Ajout de L instance créer dans la base de données
            $personnelRepository->add($personnel, true);

            $this->addFlash('SuccessSignUp', "Compte Créer avec success.Vous Recevrez une Confirmation de La part de votre Service.Veuillez Regulierement consulter vos Mails sur:".$personnel->getEmail());
            return $this->redirectToRoute('Login', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('auth/InscriptionPersonnel.html.twig', [
            'personnel' =>$personnel,
            'form' => $form,
        ]);

    }


    #[Route('/EnvoideSmS', name: 'EnvoieDeSms')]
    public function EnvoideSmsDeComfirmation(RequestStack $requestStack): Response
    {
        $apiKey = 'ROD-U021YHJANX4PDF4BUYTGY82HP81E3FEPHMA';
        $userUid = 'RPILN9';
        $goxens =  new Goxens($apiKey, $userUid);
     
        $number="96329943";
        $sender="MajoieFaya";
        $message="Le Message";
        $send = $goxens->sendSms($apiKey,$userUid,$number,$sender,$message);
        return $this->json($send);
        return $this->redirectToRoute('Login',[]);
    }

    #[Route('/Deconnexion', name: 'Logout')]
    public function SecurityLogout(RequestStack $requestStack): Response
    {
        throw new \Exception('Désolée,Déconnexion échouée');
    }
}
