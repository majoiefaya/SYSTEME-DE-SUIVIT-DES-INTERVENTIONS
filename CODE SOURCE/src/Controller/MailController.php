<?php

namespace App\Controller;

use App\Repository\UtilisateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use App\Entity\Utilisateur;

#[Route('/Mail')]

class MailController extends AbstractController
{
    #[Route('/EnvoyerUnMailAUnUtilisateurN/{id}', name: 'EnvoyerMail', methods: ['GET','POST'])]
    public function EnvoyerUnMail(Request $request,MailerInterface $mailer,Utilisateur $user): Response
    {
        $donnees = json_decode($request->getContent());
        $message=$donnees->message;
        $IdIntervention=$donnees->idRapport;
        $code = 200;
        $email = (new TemplatedEmail())
        ->from('majoiefaya@gmail.com')
        ->to($user->getEmail())
        ->subject("Mail d'Informations")
        ->htmlTemplate('emails/EnvoieDeNewsletters.html.twig')
        ->context([
            'Nom' => $user->getNom(),
            'Prenom'=> $user->getPrenom(),
            'Contenu'=>$message,
        ]);
        $mailer->send($email);
        return new Response('Ok', $code);
    }

    #[Route('/CréerUneNewsletter', name: 'CreerNewsletter', methods: ['GET'])]
    public function index(UtilisateurRepository $utilisateurRepository,MailerInterface $mailer): Response
    {
        $users=$utilisateurRepository->findAll();
        foreach($users as $user){
            if($user->isNewsletter()==True){
                $email = (new TemplatedEmail())
                ->from('majoiefaya@gmail.com')
                ->to($user)
                ->subject("Informations de La Part de SDI")
                ->htmlTemplate('emails/EnvoieDeNewsletters.html.twig')
                ->context([
                    'Nom' => $user->getNom(),
                    'Prenom'=> $user->getPrenom(),
                    'Contenu'=>'Ceci est une Newsletter',
                   
                ]);
    
                $mailer->send($email);
            }
        }
        $this->addFlash('Succes', "Les Informations ont été Envoyés aux Utilisateurs");
        return $this->redirectToRoute('Accueil',[]);
    }


    #[Route('/ComfirmationDeMail', name: 'ComfirmationDeMail')]
    public function ComfirmationDeMail(Request $request,UtilisateurRepository $utilisateurRepository): Response
    {
        $Code=$request->request->get('code');
        if(isset($Code)){
            if($utilisateurRepository->findOneBy(["Code"=>$Code])){
                $user=$utilisateurRepository->findOneBy(["Code"=>$Code]);
                $user->setEnable(True);
                $user->setActive(True);
                $utilisateurRepository->add($user);
                return $this->redirectToRoute('Login', [], Response::HTTP_SEE_OTHER);
            }else{
                return $this->renderForm('auth/CodeDeComfirmation.html.twig',[
                    "error"=>"Le code que vous avez entrer est incorrecte"
                ]);;
            }
        }

        return $this->renderForm('auth/CodeDeComfirmation.html.twig',[
        ]);;
    }

    

    #[Route('/EnvoieDeMailDeSuggestion', name: 'MailDeSuggestion')]
    public function EnvoieDeMail(MailerInterface $mailer,Request $request): Response
    {
        $Nom=$request->request->get('nom');
        $Email=$request->request->get('email');
        $Message=$request->request->get('message');
        if(!($Nom and $Email and $Message)==null){
            $email = (new TemplatedEmail())
            ->from($Email)
            ->to('majoiefaya@gmail.com')
            ->subject("Suggestion de ".$Nom." Pour SDI")
            ->htmlTemplate('emails/MailDeSuggestion.html.twig')
            ->context([
                'nom' => $Nom,
                'message'=>$Message
            ])
            ;
            $mailer->send($email);
        }

        return $this->redirectToRoute('Accueil', [], Response::HTTP_SEE_OTHER);
    }

}