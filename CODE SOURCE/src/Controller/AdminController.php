<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Form\AdminType;
use App\Repository\AdminRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Doctrine\ORM\EntityManagerInterface;

#[Route('/admin')]
class AdminController extends AbstractController
{

    
    private $params;

    public function __construct(ParameterBagInterface $params)
    {
        $this->params=$params;
    }

    #[Route('/', name: 'admin', methods: ['GET'])]
    public function index(AdminRepository $adminRepository): Response
    {
        return $this->render('admins_dashboard/admin/ListeAdmins.html.twig', [
            'admins' => $adminRepository->findAll(),
        ]);
    }

    #[Route('/AjouterUnAdmin', name: 'AjouterAdmin', methods: ['GET', 'POST'])]
    public function new(Request $request, AdminRepository $adminRepository,UserPasswordHasherInterface $passwordhash): Response
    {
        $admin = new Admin();
        $form = $this->createForm(AdminType::class, $admin);
        $form->handleRequest($request);
        $user = $this->getUser();
        if($user!=null){
            $username=$user->getUserIdentifier();
        }
        else{
            $username="Développeur";
        }
        $dateCreation=new \DateTime('@'.strtotime('now'));

        if ($form->isSubmitted() && $form->isValid()) {
            ///Hash Du Mot De Passe
            $MotDePasseCripte=$passwordhash->hashPassword($admin,$admin->getPassword());
            $admin->setpassword($MotDePasseCripte);
       
            ///insertion de l image dans la base de donées et dans Le Dossier PhotosDeProfil
            $webpath=$this->params->get("kernel.project_dir").'/public/Admins/Admin/PhotosDeProfil/';
            $chemin=$webpath.$_FILES['admin']["name"]["Image"];
            $destination=move_uploaded_file($_FILES['admin']['tmp_name']['Image'],$chemin);
            $admin->setimage($_FILES['admin']['name']['Image']);

            ///Insertion des Données A set en BackEnd
            $admin->setCreerPar($username);
            $admin->setCreerLe($dateCreation);
            $admin->setEnable(True);
            $admin->setRoles(["ROLE_ADMIN"]);

            ///Ajout de L instance créer dans la base de données
            $adminRepository->add($admin, true);

            return $this->redirectToRoute('admin', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admins_dashboard/admin/AjouterUnAdmin.html.twig', [
            'admin' => $admin,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_show', methods: ['GET'])]
    public function show(Admin $admin): Response
    {
        return $this->render('admin/show.html.twig', [
            'admin' => $admin,
        ]);
    }

    #[Route('/ModifierLAdminN/{id}', name: 'ModifierAdmin', methods: ['GET', 'POST'])]
    public function edit(Request $request, Admin $admin, AdminRepository $adminRepository,UserPasswordHasherInterface $passwordhash): Response
    {
        $form = $this->createForm(AdminType::class, $admin);
        $form->handleRequest($request);
        $user = $this->getUser();
        if($user!=null){
            $username=$user->getUserIdentifier();
        }
        else{
            $username="Développeur";
        }
        $dateCreation=new \DateTime('@'.strtotime('now'));

        if ($form->isSubmitted() && $form->isValid()) {
            ///Hash Du Mot De Passe
            $MotDePasseCripte=$passwordhash->hashPassword($admin,$admin->getPassword());
            $admin->setpassword($MotDePasseCripte);
       
            ///insertion de l image dans la base de donées et dans Le Dossier PhotosDeProfil
            $webpath=$this->params->get("kernel.project_dir").'/public/Admins/Admin/PhotosDeProfil/';
            $chemin=$webpath.$_FILES['admin']["name"]["Image"];
            $destination=move_uploaded_file($_FILES['admin']['tmp_name']['Image'],$chemin);
            $admin->setimage($_FILES['admin']['name']['Image']);

            ///Insertion des Données A set en BackEnd
            $admin->setCreerPar($username);
            $admin->setCreerLe($dateCreation);
            $admin->setEnable(True);
            $admin->setRoles(["ROLE_ADMIN"]);

            ///Ajout de L instance créer dans la base de données
            $adminRepository->add($admin, true);

            return $this->redirectToRoute('ListeUtilisateurs', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admins_dashboard/admin/ModifierUnAdmin.html.twig', [
            'admin' => $admin,
            'form' => $form,
        ]);
    }

    #[Route('/SupprimerLAdminN/{id}', name: 'SupprimerAdmin', methods: ['POST','GET'])]
    public function delete(Request $request, Admin $admin, AdminRepository $adminRepository): Response
    {
        $user = $this->getUser();
        $adminRepository->remove($admin, true);
        
        if ($user->getRoles()==['ROLE_CLIENT']){
            $this->container->get('security.token_storage')->setToken(null);
            return $this->redirectToRoute('Login', [], Response::HTTP_SEE_OTHER);
        }else{
            return $this->redirectToRoute('ListeUtilisateurs', [], Response::HTTP_SEE_OTHER);
        }
    }
}
