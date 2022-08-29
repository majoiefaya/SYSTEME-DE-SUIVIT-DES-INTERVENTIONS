<?php

namespace App\Controller;

use App\Entity\Calendar;
use App\Form\CalendarType;
use App\Repository\CalendarRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/calendrier')]
class CalendarController extends AbstractController
{

    #[Route('/', name: 'ListeDesEvenementsCalendrier', methods: ['GET'])]
    public function Liste(CalendarRepository $calendarRepository,CalendarRepository $calendar): Response
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

    #[Route('/CreerUnEvenementCalendrier', name: 'CreerEvenementCalendrier', methods: ['GET','POST'])]
    public function AjoutEvenement(Request $request,CalendarRepository $calendarRepository): Response
    {
        $calendar = new Calendar();
        $form = $this->createForm(CalendarType::class, $calendar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $calendarRepository->add($calendar,true);
            return $this->redirectToRoute('PlanificateurIntervention');
        }

        return $this->render('GestionDesInterventions/calendar/CreerUnEvenementCalendrier.html.twig', [
            'calendar' => $calendar,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/InformationDeLEvenementCalendrierN/{id}', name: 'InfosEvenementCalendrier', methods: ['GET'])]
    public function InformationsEvenement(Calendar $calendar): Response
    {
        return $this->render('calendar/show.html.twig', [
            'calendar' => $calendar,
        ]);
    }

    #[Route('/ModifierLEvenementCalendrierN/{id}', name: 'ModifierEvenementCalendrier', methods: ['GET','POST'])]
    public function Modifer(Request $request, Calendar $calendar,CalendarRepository $calendarRepository): Response
    {
        $form = $this->createForm(CalendarType::class, $calendar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $calendarRepository->add($calendar,true);
            return $this->redirectToRoute('ListeDesEvenementsCalendrier');
        }

        return $this->render('calendar/edit.html.twig', [
            'calendar' => $calendar,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/SupprimerLEvenementCalendrierN/{id}', name: 'SupprimerEvenementCalendrier', methods: ['GET','POST'])]
    public function Supprimer(Request $request, Calendar $calendar,CalendarRepository $calendarRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$calendar->getId(), $request->request->get('_token'))) {
            $calendarRepository->remove($calendar);
        }

        return $this->redirectToRoute('ListeDesEvenementsCalendrier');
    }
}
