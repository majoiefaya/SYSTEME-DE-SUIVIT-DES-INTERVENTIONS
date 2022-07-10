<?php

namespace App\Controller;

use App\Entity\Employe;
use App\Form\EmployeType;
use App\Repository\EmployeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[Route('/employe')]
class EmployeController extends AbstractController
{

    private $params;

    public function __construct(ParameterBagInterface $params)
    {
        $this->params=$params;
    }

    #[Route('/', name: 'employe', methods: ['GET'])]
    public function index(EmployeRepository $employeRepository): Response
    {
        return $this->render('employes_dashboard/employe/ListeEmployes.html.twig', [
            'employes' => $employeRepository->findAll(),
        ]);
    }

    #[Route('/AjouterUnEmploye', name: 'AjouterEmploye', methods: ['GET', 'POST'])]
    public function new(Request $request, EmployeRepository $employeRepository,UserPasswordHasherInterface $passwordhash): Response
    {   
        $employe = new Employe();
        $form = $this->createForm(EmployeType::class, $employe);
        $form->handleRequest($request);
        $user = $this->getUser();
        if($user!=null){
            $username=$user->getUserIdentifier();
        }
        else{
            $username="Employe";
        }
        $dateCreation=new \DateTime('@'.strtotime('now'));

        if ($form->isSubmitted() && $form->isValid()) {
            ///Hash Du Mot De Passe
            $MotDePasseCripte=$passwordhash->hashPassword($employe,$employe->getPassword());
            $employe->setpassword($MotDePasseCripte);
       
            ///insertion de l image dans la base de donées et dans Le Dossier PhotosDeProfil
            $webpath=$this->params->get("kernel.project_dir").'/public/Employes/';
            $chemin=$webpath.$_FILES['employe']["name"]["Image"];
            $destination=move_uploaded_file($_FILES['employe']['tmp_name']['Image'],$chemin);
            $employe->setimage($_FILES['employe']['name']['Image']);

            ///Insertion des Données A set en BackEnd
            $employe->setCreerPar($username);
            $employe->setCreerLe($dateCreation);
            $employe->setEnable(True);
            $employe->setRoles(["ROLE_employe"]);

            ///Ajout de L instance créer dans la base de données
            $employeRepository->add($employe, true);

            return $this->redirectToRoute('ListeUtilisateurs', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('employes_dashboard/employe/ModifierUnemploye.html.twig', [
            'employe' => $employe,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_employe_show', methods: ['GET'])]
    public function show(Employe $employe): Response
    {
        return $this->render('employe/show.html.twig', [
            'employe' => $employe,
        ]);
    }

    #[Route('/ModifierLEmployeN/{id}', name: 'ModifierEmployer', methods: ['GET', 'POST'])]
    public function edit(Request $request, Employe $employe, EmployeRepository $employeRepository): Response
    {
        $form = $this->createForm(EmployeType::class, $employe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $employeRepository->add($employe, true);

            return $this->redirectToRoute('ListeUtilisateurs', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('employe/edit.html.twig', [
            'employe' => $employe,
            'form' => $form,
        ]);
    }

    #[Route('/SupprimerLEmployeN/{id}', name: 'SupprimerEmployer', methods: ['POST'])]
    public function delete(Request $request, Employe $employe, EmployeRepository $employeRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$employe->getId(), $request->request->get('_token'))) {
            $employeRepository->remove($employe, true);
        }

        return $this->redirectToRoute('ListeUtilisateurs', [], Response::HTTP_SEE_OTHER);
    }
}
