<?php

namespace App\Controller;

use App\Entity\Client;
use App\Form\ClientType2;
use App\Repository\ClientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;

class AuthController extends AbstractController
{

    private $params;

    public function __construct(ParameterBagInterface $params)
    {
        $this->params=$params;
    }


    #[Route('/', name: 'Login')]
    public function Authentification(AuthenticationUtils $authenticationUtils): Response
    {
        $error=$authenticationUtils->getLastAuthenticationError();
        $LastUsername=$authenticationUtils->getLastUsername();
        return $this->render('auth/Authentification.html.twig',[
            'error'=>$error,
            'LastUsername'=>$LastUsername
        ]);
    }
 
    #[Route('/CreationDeCompte', name: 'InscriptionClient')]
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

            ///Envoie d'Un Mail de Comfirmation
            $email = (new Email())
            ->from('majoiefaya@gmail.com')
            ->to($client->getEmail())
            ->subject("Comfirmation d'Inscription")
            ->text('Veuillez Confirmer votre Inscription')
            ->html('<p></p>');

            $mailer->send($email);

            $client->setTelephone($TelNumber);
            $client->setEnable(True);
            $client->setRoles(["ROLE_CLIENT"]);


            $clientRepository->add($client, true);

            return $this->redirectToRoute('Login', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('auth/InscriptionClient.html.twig', [
            'client' => $client,
            'form' => $form,
        ]);
    }

    #[Route('/Deconnexion', name: 'Logout')]
    public function SecurityLogout(RequestStack $requestStack): Response
    {
        throw new \Exception('Désolée,Déconnexion échouée');
    }
}
