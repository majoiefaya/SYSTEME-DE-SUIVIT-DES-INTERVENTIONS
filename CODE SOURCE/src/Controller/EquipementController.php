<?php

namespace App\Controller;

use App\Entity\Equipement;
use App\Form\EquipementType;
use App\Repository\EquipementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;


#[Route('/equipement')]
class EquipementController extends AbstractController
{
    private $params;

    public function __construct(ParameterBagInterface $params)
    {
        $this->params=$params;
    }


    #[Route('/', name: 'equipement', methods: ['GET'])]
    public function index(EquipementRepository $equipementRepository): Response
    {
        return $this->render('equipement/ListeEquipements.html.twig', [
            'equipements' => $equipementRepository->findAll(),
        ]);
    }

    #[Route('/AjouterUnEquipement', name:'AjouterEquipement', methods: ['GET', 'POST'])]
    public function new(Request $request, EquipementRepository $equipementRepository): Response
    {
        $equipement = new Equipement();
        $form = $this->createForm(EquipementType::class, $equipement);
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

            ///insertion de l image dans la base de donées et dans Le Dossier PhotosDeProfil
            $webpath=$this->params->get("kernel.project_dir").'/public/Admins/Admin/PhotosDeProfil/';
            $chemin=$webpath.$_FILES['admin']["name"]["Image"];
            $destination=move_uploaded_file($_FILES['admin']['tmp_name']['Image'],$chemin);
            $equipement->setimage($_FILES['admin']['name']['Image']);

            ///Insertion des Données A set en BackEnd
            $equipement->setCreerPar($username);
            $equipement->setCreerLe($dateCreation);
            $equipement->setEnable(True);
  
            $equipementRepository->add($equipement, true);

            return $this->redirectToRoute('equipement', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('equipement/AjouterUnEquipement.html.twig', [
            'equipement' => $equipement,
            'form' => $form,
        ]);
    }

    #[Route('/InfosDeLEquipementN/{id}', name: 'InfosEquipement', methods: ['GET'])]
    public function show(Equipement $equipement): Response
    {
        return $this->render('equipement/Infos.html.twig', [
            'equipement' => $equipement,
        ]);
    }

    #[Route('/ModifierLEquipementN/{id}', name: 'ModifierEquipement', methods: ['GET', 'POST'])]
    public function edit(Request $request, Equipement $equipement, EquipementRepository $equipementRepository): Response
    {
        $form = $this->createForm(EquipementType::class, $equipement);
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

            ///insertion de l image dans la base de donées et dans Le Dossier PhotosDeProfil
            $webpath=$this->params->get("kernel.project_dir").'/public/Admins/Admin/PhotosDeProfil/';
            $chemin=$webpath.$_FILES['admin']["name"]["Image"];
            $destination=move_uploaded_file($_FILES['admin']['tmp_name']['Image'],$chemin);
            $equipement->setimage($_FILES['admin']['name']['Image']);

            ///Insertion des Données A set en BackEnd
            $equipement->setCreerPar($username);
            $equipement->setCreerLe($dateCreation);
            $equipement->setEnable(True);
  
            $equipementRepository->add($equipement, true);

            return $this->redirectToRoute('equipement', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('equipement/ModifierUnEquipement.html.twig', [
            'equipement' => $equipement,
            'form' => $form,
        ]);
    }

    #[Route('/SupprimerLEquipementN/{id}', name: 'SupprimerEquipement', methods: ['POST','GET'])]
    public function delete(Request $request, Equipement $equipement, EquipementRepository $equipementRepository): Response
    {
        $user = $this->getUser();
        $equipementRepository->remove($equipement, true);
        
        if ($user->getRoles()==['ROLE_CLIENT']){
            $this->container->get('security.token_storage')->setToken(null);
            return $this->redirectToRoute('Login', [], Response::HTTP_SEE_OTHER);
        }else{
            return $this->redirectToRoute('ListeUtilisateurs', [], Response::HTTP_SEE_OTHER);
        }
        return $this->redirectToRoute('equipement', [], Response::HTTP_SEE_OTHER);
    }
}
