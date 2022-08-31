<?php

namespace App\Controller;

use App\Entity\Equipe;
use App\Entity\Intervention;
use App\Form\ActiverInterventionType;
use App\Form\InterventionType;
use App\Form\InterventionType2;
use App\Repository\CalendarRepository;
use App\Repository\EquipementRepository;
use App\Repository\EquipeRepository;
use App\Repository\InterventionRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/intervention')]
class InterventionController extends AbstractController
{
    #[Route('/', name: 'intervention', methods: ['GET'])]
    public function index(InterventionRepository $interventionRepository): Response
    {
        return $this->render('GestionDesInterventions/intervention/ListeInterventions.html.twig', [
            'interventions' => $interventionRepository->findAll(),
            'NombreInterventions'=>count($interventionRepository->findAll())
        ]);
    }

    #[Route('/GenererUnCodeQrN/{id}', name: 'GenererCodeQr', methods: ['GET', 'POST'])]
    public function GenererUnCodeQr(Request $request, InterventionRepository $interventionRepository,Intervention $intervention): Response
    {
        
        return $this->render('GestionDesInterventions/intervention/GenererUnCodeQr.html.twig', [
            'intervention' => $intervention
        ]);
    }

    #[Route('/CréerUneIntervention', name: 'CreerIntervention', methods: ['GET', 'POST'])]
    public function new(Request $request, InterventionRepository $interventionRepository): Response
    {
        $intervention = new Intervention();
        $form = $this->createForm(InterventionType2::class, $intervention);
        $form->handleRequest($request);
        $user = $this->getUser();
        $Latitude=$request->request->get('lat');
        $Longitude=$request->request->get('lon');
        if($Latitude==null or $Longitude==null){
            $this->addFlash('Error',"Renseignez L'endroit ou nous devrons operer L'Intervention");
        }
        if($user!=null){
            $username=$user->getUserIdentifier();
        }
        else{
            $username="Développeur";
        }
        $dateCreation=new \DateTime('@'.strtotime('now'));

        if ($form->isSubmitted() && $form->isValid()) {
            $intervention->setCreerPar($username);
            $intervention->setCreerLe($dateCreation);
            $intervention->setActive(False);
            $intervention->setEnable(True);
            $intervention->setClient($user);
            $intervention->setLatitude($Latitude);
            $intervention->setLongitude($Longitude);
            $interventionRepository->add($intervention, true);

            return $this->redirectToRoute('ClientsDashboard', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('GestionDesInterventions/intervention/AjouterUneInterventionClient.html.twig', [
            'intervention' => $intervention,
            'form' => $form,
        ]);
    }

    #[Route('/AjouterUneIntervention', name: 'AjouterInterventionAdmin', methods: ['GET', 'POST'])]
    public function AjouterInterventionAdmin(Request $request, InterventionRepository $interventionRepository,MailerInterface $mailer): Response
    {
        $intervention = new Intervention();
        $form = $this->createForm(InterventionType::class, $intervention);
        $form->handleRequest($request);
        $user = $this->getUser();
        $Latitude=$request->request->get('lat');
        $Longitude=$request->request->get('lon');
        if($user!=null){
            $username=$user->getUserIdentifier();
        }
        else{
            $username="Développeur";
        }
        $dateCreation=new \DateTime('@'.strtotime('now'));

        if ($form->isSubmitted() && $form->isValid()) {
            $intervention->setCreerPar($username);
            $intervention->setCreerLe($dateCreation);
            $intervention->setEnable(True);
            $intervention->setLatitude($Latitude);
            $intervention->setLongitude($Longitude);
            $intervention->setAdmin($user);
            $interventionRepository->add($intervention, true);
            return $this->redirectToRoute('ListeInterventionsAdmin', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('GestionDesInterventions/intervention/AjouterInterventionAdmin.html.twig', [
            'intervention' => $intervention,
            'form' => $form,
        ]);
    }

    #[Route('/AdminInformationsDeLInterventionN/{id}', name: 'InfosInterventionAdmin', methods: ['GET'])]
    public function InformationsInterventionAdmin(EquipementRepository $equipementRepository,Intervention $intervention, InterventionRepository $interventionRepository,EquipeRepository $equipeRepository): Response
    {
        $dateActuelle=new \DateTime('@'.strtotime('now'));

        if($intervention->getDateFinIntervention()!=null)
        {
            $DateFinIntervention=$intervention->getDateFinIntervention();
            if($DateFinIntervention>$dateActuelle){
                $diff = $DateFinIntervention->diff($dateActuelle);
                $NbreHeuresActuelle = $diff->h;
                $NbreHeuresActuelle = $NbreHeuresActuelle + ($diff->days*24); 
    
                $NbreHeuresTotal=$intervention->getDureeIntervention();
    
                $pourcentageIntervention=($NbreHeuresActuelle*100)/$NbreHeuresTotal;
                $pourcentageIntervention=100-$pourcentageIntervention;
            }else{
                $pourcentageIntervention=100;
            }

                
        }else{
            $pourcentageIntervention=0;
        };
        
        /////////////////////////////////////////////////////
       

        $equipes=$intervention->getEquipes();
        return $this->render('GestionDesInterventions/intervention/InfosInterventionAdmin.html.twig', [
            'intervention' => $intervention,
            'NombreInterventions'=>count($interventionRepository->findAll()),
            'equipesIntervention'=>$intervention->getEquipes(),
            'equipes'=>$equipeRepository->findAll(),
            'equipements'=>$equipementRepository->findAll(),
            'NombreEquipe'=>count($equipes),
            'equipementsIntervention'=>$intervention->getEquipement(),
            'pourcentageIntervention'=>$pourcentageIntervention,
            'dateActu'=>$dateActuelle
        ]);
    }


    #[Route('/TehnicienInformationsDeLInterventionN/{id}', name: 'InfosInterventionTechnicien', methods: ['GET'])]
    public function InformationsInterventionTechnicien(EquipementRepository $equipementRepository,Intervention $intervention, InterventionRepository $interventionRepository,EquipeRepository $equipeRepository): Response
    {
        $dateActuelle=new \DateTime('@'.strtotime('now'));

        if($intervention->getDateFinIntervention()!=null)
        {
            $DateFinIntervention=$intervention->getDateFinIntervention();
            if($DateFinIntervention>$dateActuelle){
                $diff = $DateFinIntervention->diff($dateActuelle);
                $NbreHeuresActuelle = $diff->h;
                $NbreHeuresActuelle = $NbreHeuresActuelle + ($diff->days*24); 
    
                $NbreHeuresTotal=$intervention->getDureeIntervention();
    
                $pourcentageIntervention=($NbreHeuresActuelle*100)/$NbreHeuresTotal;
                $pourcentageIntervention=100-$pourcentageIntervention;
            }else{
                $pourcentageIntervention=100;
            }

                
        }else{
            $pourcentageIntervention=0;
        };
        
        /////////////////////////////////////////////////////
       

        $equipes=$intervention->getEquipes();
        return $this->render('GestionDesInterventions/intervention/InfosInterventionTechnicien.html.twig', [
            'intervention' => $intervention,
            'NombreInterventions'=>count($interventionRepository->findAll()),
            'equipesIntervention'=>$intervention->getEquipes(),
            'equipes'=>$equipeRepository->findAll(),
            'equipements'=>$equipementRepository->findAll(),
            'NombreEquipe'=>count($equipes),
            'equipementsIntervention'=>$intervention->getEquipement(),
            'pourcentageIntervention'=>$pourcentageIntervention,
            'dateActu'=>$dateActuelle
        ]);
    }

    #[Route('/ClientInformationsDeLInterventionN/{id}', name: 'InfosInterventionClient', methods: ['GET'])]
    public function InformationsInterventionClient(EquipementRepository $equipementRepository,Intervention $intervention, InterventionRepository $interventionRepository,EquipeRepository $equipeRepository): Response
    {
        $dateActuelle=new \DateTime('@'.strtotime('now'));

        if($intervention->getDateFinIntervention()!=null)
        {
            $DateFinIntervention=$intervention->getDateFinIntervention();
            if($DateFinIntervention>$dateActuelle){
                $diff = $DateFinIntervention->diff($dateActuelle);
                $NbreHeuresActuelle = $diff->h;
                $NbreHeuresActuelle = $NbreHeuresActuelle + ($diff->days*24); 
    
                $NbreHeuresTotal=$intervention->getDureeIntervention();
    
                $pourcentageIntervention=($NbreHeuresActuelle*100)/$NbreHeuresTotal;
                $pourcentageIntervention=100-$pourcentageIntervention;
            }else{
                $pourcentageIntervention=100;
            }

                
        }else{
            $pourcentageIntervention=0;
        };
        
        /////////////////////////////////////////////////////
       

        $equipes=$intervention->getEquipes();
        return $this->render('GestionDesInterventions/intervention/InfosInterventionClient.html.twig', [
            'intervention' => $intervention,
            'equipementsIntervention'=>$intervention->getEquipement(),
            'equipesIntervention'=>$intervention->getEquipes(),
            'pourcentageIntervention'=>$pourcentageIntervention,
        ]);
    }


    #[Route('/ActivationDeLInterventionN/{id}', name: 'ActiverIntervention', methods: ['GET','POST'])]
    public function ActiverIntervention(Request $request,EquipementRepository $equipementRepository,Intervention $intervention, InterventionRepository $interventionRepository,EquipeRepository $equipeRepository,MailerInterface $mailer): Response
    {
        $form = $this->createForm(ActiverInterventionType::class, $intervention);
        $form->handleRequest($request);
        $DateDebutIntervention=$request->request->get('DateDebutIntervention');

        if ($form->isSubmitted() && $form->isValid()) {

            ///Calcul de La Durrée de L'Intervention
            $diff = $intervention->getDateFinIntervention()->diff($intervention->getDateDebutIntervention());
            $NbreHeures = $diff->h;
            $NbreHeures = $NbreHeures + ($diff->days*24); 
            $intervention->setDureeIntervention($NbreHeures);
            //////////////////////////////////////////////

            ///Envoie du Mail De Traitement au Client
            $client=$intervention->getClient();
            $email = (new TemplatedEmail())
            ->from('majoiefaya@gmail.com')
            ->to($client->getEmail())
            ->subject("Traitement de La Demande d'Intervention")
            ->text('votre Demande a été Traitées Par Nos Services')
            ->htmlTemplate('emails/TraitementDemandeDInterventionClient.html.twig')
            ->context([
                'Nom' => $client->getNom(),
                'Prenom'=> $client->getPrenom(),
                'equipes'=>$intervention->getEquipes(),
                'DateDebutIntervention'=>$intervention->getDateDebutIntervention(),
            ]);

            $mailer->send($email);
            /////Fin


            $interventionRepository->add($intervention,true);
            return $this->redirectToRoute('ListeInterventionsAdmin', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('GestionDesInterventions/intervention/ActiverUneIntervention.html.twig', [
            'intervention' => $intervention,
            'form' => $form,
        ]);
    }

    #[Route('/AffecterUneEquipeALInterventionN/{id}', name: 'AffecterEquipe', methods: ['GET','POST'])]
    public function AjoutEquipe(Request $request,Intervention $intervention, EquipeRepository $equipeRepository,InterventionRepository $interventionRepository): Response
    {
        $NomEquipe=$request->request->get('param');
        if($NomEquipe!=null){
            if ($equipeRepository->findOneBy(["NomEquipe"=>$NomEquipe])) {
                $Equipe=$equipeRepository->findOneBy(["NomEquipe"=>$NomEquipe]);
                if($intervention->getEquipes()->contains($Equipe)){
                    $this->addFlash('Error', "Cette Equipe a deja été Affectée a cette Intervention");
                    return $this->redirectToRoute('InfosInterventionAdmin', [
                        'id'=>$intervention->getId(),
                        'intervention'=>$intervention
                    ], Response::HTTP_SEE_OTHER);
                }else{
                    $intervention->addEquipe($Equipe);
                    $interventionRepository->add($intervention, true);
                    $this->addFlash('Success', "Equipe Ajoutée a l'Intervention Avec Succes");
                    return $this->redirectToRoute('InfosInterventionAdmin', [
                        'id'=>$intervention->getId(),
                        'intervention'=>$intervention
                    ], Response::HTTP_SEE_OTHER);
                }  
            }
        }
        return $this->renderForm('GestionDesInterventions/equipe/AffecterUneEquipe.html.twig', [
            'intervention' => $intervention,
            'equipes'=>$equipeRepository->findAll()
        ]);

    }


    #[Route('/AffecterUnEquimentALInterventionN/{id}', name: 'AffecterEquipement', methods: ['GET','POST'])]
    public function AffecterUnEquipement(Request $request,Intervention $intervention, EquipementRepository $equipementRepository,InterventionRepository $interventionRepository): Response
    {
        $NomEquipement=$request->request->get('param');
        if($NomEquipement!=null){
            if ($equipementRepository->findOneBy(["Libelle"=>$NomEquipement])) {
                $Equipement=$equipementRepository->findOneBy(["Libelle"=>$NomEquipement]);
                if($Equipement->getQuantiteEquipement()>0){
                    if($intervention->getEquipement()->contains($Equipement)){
                        $this->addFlash('Error', "Cet Equipement a deja été Affectée a cette Intervention");
                        return $this->redirectToRoute('InfosInterventionAdmin', [
                            'id'=>$intervention->getId()
                        ], Response::HTTP_SEE_OTHER);
                    }else{
                        $NombreUtilisation=$Equipement->getNombreUtilisation();
                        $NombreUtilisation=$NombreUtilisation+=1;
                        $Equipement->setNombreUtilisation($NombreUtilisation);
                        $QuantiteEquipement=$Equipement->getQuantiteEquipement();
                        $QuantiteEquipement=$QuantiteEquipement-1;
                        $Equipement->setQuantiteEquipement($QuantiteEquipement);
                        $equipementRepository->add($Equipement,true);
                        $intervention->addEquipement($Equipement);
                        $interventionRepository->add($intervention, true);
                        $this->addFlash('Success', "Equipement Affecté avec succes");
                        return $this->redirectToRoute('InfosInterventionAdmin', [
                            'id'=>$intervention->getId()
                        ], Response::HTTP_SEE_OTHER);
                    }  
                }else{
                    $this->addFlash('Error', "Stock Epuisé");
                    return $this->redirectToRoute('InfosInterventionAdmin', [
                        'id'=>$intervention->getId()
                    ], Response::HTTP_SEE_OTHER);
                }
               
            }
        }
        return $this->renderForm('GestionDesInterventions/intervention/AffecterUnEquipement.html.twig', [
            'intervention' => $intervention,
            'equipements'=>$equipementRepository->findAll()
        ]);

    }


    #[Route("/RetirerUneEquipeD'UneLInterventionN/{idEquipe}/{idIntervention}", name: 'RetirerEquipe', methods: ['GET','POST'])]
    public function RetirerEquipe(Request $request,InterventionRepository $interventionRepository,EquipeRepository $equipeRepository,$idEquipe,$idIntervention): Response
    {
        $equipe=$equipeRepository->findOneBy(["id"=>$idEquipe]);
        $intervention=$interventionRepository->findOneBy(["id"=>$idIntervention]);
        $intervention->removeEquipe($equipe);
        $interventionRepository->add($intervention,true);

        $this->addFlash('Success', "Equipe Retirée avec Succes");
        
        return $this->redirectToRoute('InfosInterventionAdmin', [
            'id'=>$intervention->getId()
        ], Response::HTTP_SEE_OTHER);
       
    }

    #[Route("/AccederAuPlanificateurDIntervention", name: 'PlanificateurIntervention', methods: ['GET','POST'])]
    public function PlanificateurIntervention(CalendarRepository $calendar): Response
    {
        $events = $calendar->findAll();

        $rdvs = [];

        foreach($events as $event){
            $rdvs[] = [
                'id' => $event->getId(),
                'start' => $event->getStart()->format('Y-m-d H:i:s'),
                'end' => $event->getEnd()->format('Y-m-d H:i:s'),
                'title' => $event->getTitle(),
                'description' => $event->getDescription(),
                'backgroundColor' => $event->getBackgroundColor(),
                'borderColor' => $event->getBorderColor(),
                'textColor' => $event->getTextColor(),
                'allDay' => $event->isAllDay(),
            ];
        }

        $data = json_encode($rdvs);

        return $this->render('GestionDesInterventions/intervention/PlanificateurDIntervention.html.twig', compact('data'));
       
    }
    

    #[Route('/RechercherUnItinerairePourLInterventionN/{id}', name: 'RechercherItineraire', methods: ['GET'])]
    public function RechercherItineraireDUneIntervention(InterventionRepository $interventionRepository,Intervention $intervention,): Response
    {
        return $this->render('GestionDesInterventions/intervention/RechercherItineraireDUneIntervention.html.twig', [
            'intervention'=>$intervention
        ]);
    }


    #[Route('/LocaliserLInterventionN/{id}', name: 'LocaliserIntervention', methods: ['GET'])]
    public function LocaliserIntervention(Intervention $intervention, InterventionRepository $interventionRepository): Response
    {
        return $this->render('GestionDesInterventions/intervention/LocaliserIntervention.html.twig', [
            'intervention' => $intervention,
            'NombreInterventions'=>count($interventionRepository->findAll())
        ]);
    }

    #[Route('/TechnicienLocaliserLInterventionN/{id}', name: 'LocaliserInterventionTechnicien', methods: ['GET'])]
    public function LocaliserInterventionTechnicien(Intervention $intervention, InterventionRepository $interventionRepository): Response
    {
        return $this->render('GestionDesInterventions/intervention/LocaliserInterventionTechnicien.html.twig', [
            'intervention' => $intervention,
            'NombreInterventions'=>count($interventionRepository->findAll())
        ]);
    }

    #[Route('/ModifierLInterventionN/{id}', name: 'ModifierIntervention', methods: ['GET', 'POST'])]
    public function edit(Request $request, Intervention $intervention, InterventionRepository $interventionRepository,EquipeRepository $equipeRepository): Response
    {
        $form = $this->createForm(InterventionType::class, $intervention);
        $equipes=$intervention->getEquipes();
        $form->handleRequest($request);
        $user = $this->getUser();
        if($user!=null){
            $username=$user->getUserIdentifier();
        }
        else{
            $username="Développeur";
        }
        $dateModification=new \DateTime('@'.strtotime('now'));

        if ($form->isSubmitted() && $form->isValid()) {
            $intervention->setCreerPar($username);
            $intervention->setCreerLe($dateModification);
            $interventionRepository->add($intervention, true);

            return $this->redirectToRoute('InfosIntervention', [
                'id'=>$intervention->getId()
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('GestionDesInterventions/intervention/ModifierUneIntervention.html.twig', [
            'form' => $form,
            'intervention' => $intervention,
            'NombreInterventions'=>count($interventionRepository->findAll()),
            'equipes'=>$intervention->getEquipes(),
            'Equipes'=>$equipeRepository->findAll(),
            'NombreEquipe'=>count($equipes)
        ]);
    }

    #[Route('/SupprimerLInterventionN/{id}', name: 'SupprimerIntervention', methods: ['POST','GET'])]
    public function delete(Request $request, Intervention $intervention, InterventionRepository $interventionRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$intervention->getId(), $request->request->get('_token'))) {
            $interventionRepository->remove($intervention, true);
        }

        return $this->redirectToRoute('ListeInterventionsAdmin', [], Response::HTTP_SEE_OTHER);
    }
}
