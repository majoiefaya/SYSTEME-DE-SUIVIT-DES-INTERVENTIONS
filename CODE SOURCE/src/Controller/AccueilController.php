<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;

class AccueilController extends AbstractController
{
    #[Route('/', name: 'Accueil')]
    public function index(): Response
    {
        $dateCreation=new \DateTime('@'.strtotime('now'));
        return $this->render('accueil/Accueil.html.twig', [
            'controller_name' => 'AccueilController',
            'DateInscription' =>  $dateCreation,
        ]);
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

    #[Route("/ControlDuTypeDUtilisateur", name: 'ControlRole')]
    public function UserSpace(Request $request,UserInterface $user): Response
    {
        if ($this->container->get('security.authorization_checker')->isGranted('ROLE_SUPERADMIN')) {
            return $this->redirectToRoute('AdminsDashboard', [], Response::HTTP_SEE_OTHER);
        }else if($this->container->get('security.authorization_checker')->isGranted('ROLE_ADMIN')){
            return $this->redirectToRoute('AdminsDashboard', [], Response::HTTP_SEE_OTHER);
        }else if($this->container->get('security.authorization_checker')->isGranted('ROLE_CLIENT')){
            return $this->redirectToRoute('ClientsDashboard', [], Response::HTTP_SEE_OTHER);
        }else if($this->container->get('security.authorization_checker')->isGranted('ROLE_TECHNICIEN')){
            return $this->redirectToRoute('EmployesDashboard', [], Response::HTTP_SEE_OTHER);
        }else if($this->container->get('security.authorization_checker')->isGranted('ROLE_PERSONNEL')){
            return $this->redirectToRoute('EmployesDashboard', [], Response::HTTP_SEE_OTHER);
        }
        

        return $this->redirectToRoute('Accueil', [], Response::HTTP_SEE_OTHER);
    }
}
