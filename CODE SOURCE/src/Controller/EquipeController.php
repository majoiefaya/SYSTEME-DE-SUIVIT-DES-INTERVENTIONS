<?php

namespace App\Controller;

use App\Entity\Equipe;
use App\Form\EquipeType;
use App\Repository\TechnicienRepository;
use App\Repository\EquipeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/equipe')]
class EquipeController extends AbstractController
{
    #[Route('/', name: 'equipe', methods: ['GET'])]
    public function index(EquipeRepository $equipeRepository): Response
    {
        return $this->render('GestionDesInterventions/equipe/ListeEquipes.html.twig', [
            'equipes' => $equipeRepository->findAll(),
        ]);
    }

    #[Route('/AjouterUneEquipe', name: 'AjouterEquipe', methods: ['GET', 'POST'])]
    public function new(Request $request, EquipeRepository $equipeRepository): Response
    {
        $equipe = new Equipe();
        $form = $this->createForm(EquipeType::class, $equipe);
        $form->handleRequest($request);
       
        $user = $this->getUser();
        if($user!=null){
            $username=$user->getUserIdentifier();
        }
        else{
            $username="Admin";
        }

        $dateCreation=new \DateTime('@'.strtotime('now'));
        if ($form->isSubmitted() && $form->isValid()) {
            $equipe->setCreerPar($username);
            $equipe->setCreerLe($dateCreation);
            $equipe->setEnable(True);
            $equipe->setAdmin($user);
            $equipeRepository->add($equipe, true);

            return $this->redirectToRoute('ListeUtilisateurs', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('GestionDesInterventions/equipe/AjouterUneEquipe.html.twig', [
            'equipe' => $equipe,
            'form' => $form,
        ]);
    }

    #[Route('/InfosDeLEquipeN/{id}', name: 'InfosEquipe', methods: ['GET'])]
    public function show(Equipe $equipe): Response
    {
        return $this->render('GestionDesInterventions/equipe/InfosEquipe.html.twig', [
            'equipe' => $equipe,
            'NombreMembre'=>count($equipe->getTechnicien())
        ]);
    }


    #[Route('/AjouterMembreAEquipeN/{id}', name: 'AjouterMembre', methods: ['GET','POST'])]
    public function AjoutMembre(Request $request, Equipe $equipe, EquipeRepository $equipeRepository,TechnicienRepository $technicienRepository): Response
    {
        $NomTechnicien=$request->request->get('param');
        if($NomTechnicien!=null){
            if($technicienRepository->findOneBy(["Nom"=>$NomTechnicien])){
                $Technicien=$technicienRepository->findOneBy(["Nom"=>$NomTechnicien]);
                $equipe->addTechnicien($Technicien);
                $equipeRepository->add($equipe, true);
                return $this->redirectToRoute('ModifierEquipe', [
                    'id'=>$equipe->getId()
                ], Response::HTTP_SEE_OTHER);
            }else{
                return $this->renderForm('GestionDesInterventions/equipe/AjouterUnMembre.html.twig',[
                    "error"=>"Est deja Dans L'Equipe"
                ]);;
            }
        }
        return $this->renderForm('GestionDesInterventions/equipe/AjouterUnMembre.html.twig', [
            'equipe' => $equipe,
            'techniciens'=>$technicienRepository->findAll()
        ]);

    }

    #[Route('/ModifierLEquipeN/{id}', name: 'ModifierEquipe', methods: ['GET', 'POST'])]
    public function edit(Request $request, Equipe $equipe, EquipeRepository $equipeRepository,TechnicienRepository $technicienRepository): Response
    {
        $form = $this->createForm(EquipeType::class, $equipe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $equipeRepository->add($equipe, true);

            return $this->redirectToRoute('equipe', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('GestionDesInterventions/equipe/ModifierUneEquipe.html.twig', [
            'equipe' => $equipe,
            'form' => $form,
            'NombreMembre'=>count($equipe->getTechnicien()),
            'techniciens'=>$technicienRepository->findAll(),
            'EquipeMembres'=>$equipe->getTechnicien()
        ]);
    }

    #[Route('/SupprimerLEquipeN/{id}', name: 'SupprimerEquipe', methods: ['POST'])]
    public function delete(Request $request, Equipe $equipe, EquipeRepository $equipeRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$equipe->getId(), $request->request->get('_token'))) {
            $equipeRepository->remove($equipe, true);
        }

        return $this->redirectToRoute('equipe', [], Response::HTTP_SEE_OTHER);
    }
}
