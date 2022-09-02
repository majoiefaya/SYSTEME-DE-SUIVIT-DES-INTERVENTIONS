<?php

namespace App\Controller;

use App\Entity\Personnel;
use App\Form\PersonnelType;
use App\Repository\PersonnelRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[Route('/personnel')]
class PersonnelController extends AbstractController
{

    private $params;

    public function __construct(ParameterBagInterface $params)
    {
        $this->params=$params;
    }

    #[Route('/', name: 'app_personnel_index', methods: ['GET'])]
    public function index(PersonnelRepository $personnelRepository): Response
    {
        return $this->render('personnel/index.html.twig', [
            'personnels' => $personnelRepository->findAll(),
        ]);
    }

    #[Route('/AjouterUnPersonnel', name: 'AjouterPersonnel', methods: ['GET', 'POST'])]
    public function new(Request $request, PersonnelRepository $personnelRepository,UserPasswordHasherInterface $passwordhash): Response
    {
        $personnel=new Personnel();
        $form = $this->createForm(PersonnelType::class,$personnel);
        $form->handleRequest($request);
        $user = $this->getUser();
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
            $chemin=$webpath.$_FILES['personnel']["name"]["Image"];
            $destination=move_uploaded_file($_FILES['personnel']['tmp_name']['Image'],$chemin);
            $personnel->setimage($_FILES['personnel']['name']['Image']);

            ///Insertion des Données A set en BackEnd
            $personnel->setCreerPar($username);
            $personnel->setCode($Uuid);
            $personnel->setCreerLe($dateCreation);
            $personnel->setActive(True);
            $personnel->setEnable(True);
            $personnel->setRoles(["ROLE_PERSONNEL"]);

            ///Ajout de L instance créer dans la base de données
            $personnelRepository->add($personnel, true);

            return $this->redirectToRoute('ListeUtilisateurs', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('employes_dashboard/personnel/AjouterUnPersonnel.html.twig', [
            'personnel' =>$personnel,
            'form' => $form,
        ]);
    }

    #[Route('/InformationsDuPersonnelN/{id}', name: 'InfosPersonnel', methods: ['GET'])]
    public function show(Personnel $personnel): Response
    {
        return $this->render('personnel/show.html.twig', [
            'personnel' => $personnel,
        ]);
    }

    #[Route('/ModifierLePersonnelN/{id}', name: 'ModifierPersonnel', methods: ['GET', 'POST'])]
    public function edit(Request $request, Personnel $personnel, PersonnelRepository $personnelRepository,UserPasswordHasherInterface $passwordhash): Response
    {
        $form = $this->createForm(PersonnelType::class,$personnel);
        $form->handleRequest($request);
        $user = $this->getUser();
        if($user!=null){
            $username=$user->getUserIdentifier();
        }
        else{
            $username="Personnel";
        }
        $dateCreation=new \DateTime('@'.strtotime('now'));

        if ($form->isSubmitted() && $form->isValid()) {
            ///Hash Du Mot De Passe
            $MotDePasseCripte=$passwordhash->hashPassword($personnel,$personnel->getPassword());
            $personnel->setpassword($MotDePasseCripte);

            ///insertion de l image dans la base de donées et dans Le Dossier PhotosDeProfil
            $webpath=$this->params->get("kernel.project_dir").'/public/Employes/Personnel/PhotosDeProfil/';
            $chemin=$webpath.$_FILES['personnel']["name"]["Image"];
            $destination=move_uploaded_file($_FILES['personnel']['tmp_name']['Image'],$chemin);
            $personnel->setimage($_FILES['personnel']['name']['Image']);

            ///Insertion des Données A set en BackEnd
            $personnel->setModifierPar($username);
            $personnel->setModifierLe($dateCreation);
            $personnel->setEnable(True);
            $personnel->setRoles(["ROLE_PERSONNEL"]);

            ///Ajout de L instance créer dans la base de données
            $personnelRepository->add($personnel, true);

            return $this->redirectToRoute('ListeUtilisateurs', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('employes_dashboard/personnel/ModifierUnPersonnel.html.twig', [
            'personnel' => $personnel,
            'form' => $form,
        ]);
    }

    #[Route('/SupprimerLePersonnelN/{id}', name: 'SupprimerPersonnel', methods: ['POST','GET'])]
    public function delete(Request $request, Personnel $personnel, PersonnelRepository $personnelRepository): Response
    { 
        $user = $this->getUser();
        $personnelRepository->remove($personnel, true);
        
        if ($user->getRoles()==['ROLE_CLIENT']){
            $this->container->get('security.token_storage')->setToken(null);
            return $this->redirectToRoute('Login', [], Response::HTTP_SEE_OTHER);
        }else{
            return $this->redirectToRoute('ListeUtilisateurs', [], Response::HTTP_SEE_OTHER);
        }
        
    }
}
