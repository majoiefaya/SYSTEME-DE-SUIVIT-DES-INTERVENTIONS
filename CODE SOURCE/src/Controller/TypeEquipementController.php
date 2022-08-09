<?php

namespace App\Controller;

use App\Entity\TypeEquipement;
use App\Form\TypeEquipementType;
use App\Repository\TypeEquipementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/TypeEquipement')]
class TypeEquipementController extends AbstractController
{
    #[Route('/', name: 'TypeEquipement', methods: ['GET'])]
    public function index(TypeEquipementRepository $typeEquipementRepository): Response
    {
        return $this->render('GestionDesRessourcesMateriels/type_equipement/ListeTypeEquipement.html.twig', [
            'type_equipements' => $typeEquipementRepository->findAll(),
        ]);
    }

    #[Route('/AjouterunTypeEquipement', name: 'AjouterTypeEquipement', methods: ['GET', 'POST'])]
    public function new(Request $request, TypeEquipementRepository $typeEquipementRepository): Response
    {
        $typeEquipement = new TypeEquipement();
        $form = $this->createForm(TypeEquipementType::class, $typeEquipement);
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

            $typeEquipement->setCreerPar($username);
            $typeEquipement->setCreerLe($dateCreation);
            $typeEquipement->setEnable(True);
            $typeEquipement->setQuantiteTypeEquipement(0);

            $typeEquipementRepository->add($typeEquipement, true);

            return $this->redirectToRoute('TypeEquipement', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('GestionDesRessourcesMateriels/type_equipement/AjouterTypeEquipement.html.twig', [
            'type_equipements' => $typeEquipementRepository->findAll(),
            'type_equipement' => $typeEquipement,
            'form' => $form,
        ]);
    }

    #[Route('InfoDuTypeEquipement/{id}', name: 'InfoTypeEquipement', methods: ['GET'])]
    public function show(TypeEquipement $typeEquipement): Response
    {
        return $this->render('GestionDesRessourcesMateriels/type_equipement/show.html.twig', [
            'type_equipement' => $typeEquipement,
        ]);
    }

    #[Route('/{id}/edit', name: 'ModifierTypeEquipement', methods: ['GET', 'POST'])]
    public function edit(Request $request, TypeEquipement $typeEquipement, TypeEquipementRepository $typeEquipementRepository): Response
    {
        $form = $this->createForm(TypeEquipementType::class, $typeEquipement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $typeEquipementRepository->add($typeEquipement, true);

            return $this->redirectToRoute('TypeEquipement', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('GestionDesRessourcesMateriels/type_equipement/ModifierTypeEquipement.html.twig', [
            'type_equipement' => $typeEquipement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_type_equipement_delete', methods: ['POST'])]
    public function delete(Request $request, TypeEquipement $typeEquipement, TypeEquipementRepository $typeEquipementRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$typeEquipement->getId(), $request->request->get('_token'))) {
            $typeEquipementRepository->remove($typeEquipement, true);
        }

        return $this->redirectToRoute('TypeEquipement', [], Response::HTTP_SEE_OTHER);
    }
}
