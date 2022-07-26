<?php

namespace App\Controller;

use App\Entity\Technicien;
use App\Form\TechnicienType;
use App\Repository\TechnicienRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[Route('/technicien')]
class TechnicienController extends AbstractController
{

    private $params;

    public function __construct(ParameterBagInterface $params)
    {
        $this->params=$params;
    }

    #[Route('/', name: 'technicien', methods: ['GET'])]
    public function index(TechnicienRepository $technicienRepository): Response
    {
        return $this->render('technicien/index.html.twig', [
            'techniciens' => $technicienRepository->findAll(),
        ]);
    }

    #[Route('/AjouterUnTechnicien', name: 'AjouterTechnicien', methods: ['GET', 'POST'])]
    public function new(Request $request, TechnicienRepository $technicienRepository,UserPasswordHasherInterface $passwordhash): Response
    {
        
        $technicien = new Technicien();
        $form = $this->createForm(TechnicienType::class, $technicien);
        $form->handleRequest($request);
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
            $chemin=$webpath.$_FILES['technicien']["name"]["Image"];
            $destination=move_uploaded_file($_FILES['technicien']['tmp_name']['Image'],$chemin);
            $technicien->setimage($_FILES['technicien']['name']['Image']);

            ///Insertion des Données A set en BackEnd
            $technicien->setCreerPar($username);
            $technicien->setCode($Uuid);
            $technicien->setCreerLe($dateCreation);
            $technicien->setEnable(True);
            $technicien->setRoles(["ROLE_TECHNICIEN"]);

            ///Ajout de L instance créer dans la base de données
            $technicienRepository->add($technicien, true);

            return $this->redirectToRoute('ListeUtilisateurs', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('employes_dashboard/technicien/AjouterUnTechnicien.html.twig', [
            'technicien' => $technicien,
            'form' => $form,
        ]);
    }

    #[Route('/InfosDuTechnicienN/{id}', name: 'InfosTechnicien', methods: ['GET'])]
    public function show(Technicien $technicien): Response
    {
        return $this->render('technicien/show.html.twig', [
            'technicien' => $technicien,
        ]);
    }

    #[Route('/ModifierLeTechnicienN/{id}', name: 'ModifierTechnicien', methods: ['GET', 'POST'])]
    public function edit(Request $request, Technicien $technicien, TechnicienRepository $technicienRepository,UserPasswordHasherInterface $passwordhash): Response
    {
        $form = $this->createForm(TechnicienType::class, $technicien);
        $form->handleRequest($request);
        $user = $this->getUser();
        if($user!=null){
            $username=$user->getUserIdentifier();
        }
        else{
            $username="Technicien";
        }
        $dateCreation=new \DateTime('@'.strtotime('now'));

        if ($form->isSubmitted() && $form->isValid()) {
            ///Hash Du Mot De Passe
            $MotDePasseCripte=$passwordhash->hashPassword($technicien,$technicien->getPassword());
            $technicien->setpassword($MotDePasseCripte);
       
            ///insertion de l image dans la base de donées et dans Le Dossier PhotosDeProfil
            $webpath=$this->params->get("kernel.project_dir").'/public/Employes/Technicien/PhotosDeProfil/';
            $chemin=$webpath.$_FILES['technicien']["name"]["Image"];
            $destination=move_uploaded_file($_FILES['technicien']['tmp_name']['Image'],$chemin);
            $technicien->setimage($_FILES['technicien']['name']['Image']);

            ///Insertion des Données A set en BackEnd
            $technicien->setModifierPar($username);
            $technicien->setModifierLe($dateCreation);
            $technicien->setEnable(True);
            $technicien->setRoles(["ROLE_TECHNICIEN"]);

            ///Ajout de L instance créer dans la base de données
            $technicienRepository->add($technicien, true);

            return $this->redirectToRoute('ListeUtilisateurs', [], Response::HTTP_SEE_OTHER);
        }
    
            return $this->renderForm('employes_dashboard/technicien/ModifierUnTechnicien.html.twig', [
                'technicien' => $technicien,
                'form' => $form,
            ]);
    }

    #[Route('/SupprimerLeTechnicienN/{id}', name: 'SupprimerTechnicien', methods: ['POST'])]
    public function delete(Request $request, Technicien $technicien, TechnicienRepository $technicienRepository): Response
    {
        $user = $this->getUser();
        $technicienRepository->remove($technicien, true);
        
        if ($user->getRoles()==['ROLE_CLIENT']){
            $this->container->get('security.token_storage')->setToken(null);
            return $this->redirectToRoute('Login', [], Response::HTTP_SEE_OTHER);
        }else{
            return $this->redirectToRoute('ListeUtilisateurs', [], Response::HTTP_SEE_OTHER);
        }
        
    }
}
