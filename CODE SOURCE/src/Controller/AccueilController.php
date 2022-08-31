<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CommentaireRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Repository\UtilisateurRepository;

class AccueilController extends AbstractController
{
    #[Route('/', name: 'Accueil')]
    public function index(CommentaireRepository $commentaireRepository): Response
    {
        $date=new \DateTime('@'.strtotime('now'));
        return $this->render('accueil/Accueil.html.twig', [
            'temoignages'=>$commentaireRepository->findAllTemoignages(),
            'controller_name' => 'AccueilController',
            'DateActuelle' =>  $date,
        ]);
    }

    #[Route('/SouscriptionANotreNewsletter', name: 'Newsletter')]
    public function SouscriptionAlaNewsletter(Request $request,UserInterface $user,UtilisateurRepository $utilisateurRepository): Response
    {
        $email=$request->request->get('email');

        if($utilisateurRepository->findOneBy(["Email"=>$email])){
            $user=$utilisateurRepository->findOneBy(["Email"=>$email]);
            $user->setNewsletter(True);
            $utilisateurRepository->add($user,true);
            $this->addFlash('Succes', "Souscription Réussie,Vous Recevrez des Mails a chaque fois qu'il y aura quelconque informations a Transmettre");
        }else{
            $this->addFlash('Error', 'Créez Un Compte et Réessayez');
        }

        return $this->redirectToRoute('Accueil', [], Response::HTTP_SEE_OTHER);
    }


    #[Route("/ControlDuTypeDUtilisateur", name: 'ControlRole')]
    public function UserSpace(Request $request,UserInterface $user,UtilisateurRepository $utilisateurRepository): Response
    {
        $userMail=$user->getUserIdentifier();
        $user=$utilisateurRepository->findOneBy(["Email"=>$userMail]);
        if($user->isActive()){
            if( $this->container->get('security.authorization_checker')->isgranted('IS_AUTHENTICATED_FULLY')){
                if ($this->container->get('security.authorization_checker')->isGranted('ROLE_SUPERADMIN') or $this->container->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
                    return $this->redirectToRoute('AdminsDashboard', [], Response::HTTP_SEE_OTHER);
                }else if($this->container->get('security.authorization_checker')->isGranted('ROLE_TECHNICIEN') or $this->container->get('security.authorization_checker')->isGranted('ROLE_PERSONNEL')){
                    return $this->redirectToRoute('EmployesDashboard', [], Response::HTTP_SEE_OTHER);
                }else if($this->container->get('security.authorization_checker')->isGranted('ROLE_CLIENT')){
                    return $this->redirectToRoute('ClientsDashboard', [], Response::HTTP_SEE_OTHER);
                }
            }
        }else{
            $this->addFlash('ErrorLogin', 'Votre Compte est Inactif');
            return $this->redirectToRoute('Login', [], Response::HTTP_SEE_OTHER);
        }
       
        return $this->redirectToRoute('Accueil', [], Response::HTTP_SEE_OTHER);
    }
}
