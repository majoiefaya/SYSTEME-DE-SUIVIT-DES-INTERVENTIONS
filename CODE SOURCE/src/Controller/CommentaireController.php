<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Form\CommentaireType;
use App\Repository\CommentaireRepository;
use App\Repository\InterventionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/commentaire')]
class CommentaireController extends AbstractController
{
    #[Route('/', name: 'commentaire', methods: ['GET'])]
    public function index(CommentaireRepository $commentaireRepository): Response
    {
        return $this->render('commentaire/ListeCommentaire.html.twig', [
            'commentaires' => $commentaireRepository->findAll(),
            'NombreCommentaire' => count($commentaireRepository->findAll()),
        ]);
    }


    #[Route('/ListeDesTemoignagesEtCommentairesDesClients', name: 'ListeDesTemoignagesEtCommentairesClients', methods: ['GET'])]
    public function ListeDesTemoignagesClients(CommentaireRepository $commentaireRepository,InterventionRepository $interventionRepository): Response
    {
        return $this->render('commentaire/ListeDesTemoignagesEtCommentairesClients.html.twig', [
            'temoignages' => $commentaireRepository->findAllTemoignages(),
            'commentaires'=>$commentaireRepository->findAllCommentaires()
        ]);
    }
    
    #[Route('/Faire Un Commentaire', name: 'FaireCommentaire', methods: ['GET', 'POST'])]
    public function FaireUnCommentaire(Request $request, CommentaireRepository $commentaireRepository): Response
    {
        $commentaire = new Commentaire();
        $Contenu=$request->request->get('ContenuCommentaire');
        $dateActuelle=new \DateTime('@'.strtotime('now'));
        if(isset($Contenu) and $Contenu!=null){
            $commentaire->setContenu($Contenu);
            $commentaire->setDateEnvoi($dateActuelle);
            $commentaireRepository->add($commentaire,true); $this->addFlash('Success', "Commentaire Soumis avec Succes");
        }
        else{
            $this->addFlash('Error', "Redigez Un Commentaire");
            return $this->redirectToRoute('commentaire', [], Response::HTTP_SEE_OTHER);
        }
      

        return $this->redirectToRoute('commentaire', [], Response::HTTP_SEE_OTHER);
    }
    
    #[Route('/ModiferLeTemoignageN/{id}', name: 'ModifierTemoignage', methods: ['GET', 'POST'])]
    public function ModiferUnTemoignage(Request $request, CommentaireRepository $commentaireRepository,Commentaire $commentaire): Response
    {
        $Contenu=$request->request->get('ContenuModifié');
        if($Contenu!=null){
            $commentaire->setContenu($Contenu);
            $commentaireRepository->add($commentaire,true);
            $this->addFlash('Success', "Commentaire Modifié avec succes");
        }else{
            $this->addFlash('Error', "Le contenu a Modifier est vide ");
            return $this->redirectToRoute('commentaire', [], Response::HTTP_SEE_OTHER);
        }

        return $this->redirectToRoute('commentaire', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/AjouterUnCommentaire', name: 'AjouterCommentaire', methods: ['GET', 'POST'])]
    public function new(Request $request, CommentaireRepository $commentaireRepository): Response
    {
        $commentaire = new Commentaire();
        $form = $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);
        $dateActuelle=new \DateTime('@'.strtotime('now'));
       
        if ($form->isSubmitted() && $form->isValid()) {
            $commentaire->setDateEnvoi($dateActuelle);
            $commentaireRepository->add($commentaire, true);

            return $this->redirectToRoute('commentaire', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('commentaire/AjouterCommentaire.html.twig', [
            'commentaire' => $commentaire,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'InfosCommentaire', methods: ['GET'])]
    public function show(Commentaire $commentaire): Response
    {
        return $this->render('commentaire/InfoCommentaire.html.twig', [
            'commentaire' => $commentaire,
        ]);
    }

    #[Route('/ModifierUnCommentaire/{id}', name: 'ModifierCommentaire', methods: ['GET', 'POST'])]
    public function edit(Request $request, Commentaire $commentaire, CommentaireRepository $commentaireRepository): Response
    {
        $form = $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $commentaireRepository->add($commentaire, true);

            return $this->redirectToRoute('commentaire', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('commentaire/ModifierCommentaire.html.twig', [
            'commentaire' => $commentaire,
            'form' => $form,
        ]);
    }

    #[Route('/SupprimerUnCommentaire/{id}', name: 'SupprimerCommentaire', methods: ['POST'])]
    public function delete(Request $request, Commentaire $commentaire, CommentaireRepository $commentaireRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$commentaire->getId(), $request->request->get('_token'))) {
            $commentaireRepository->remove($commentaire, true);
        }

        return $this->redirectToRoute('commentaire', [], Response::HTTP_SEE_OTHER);
    }
}
