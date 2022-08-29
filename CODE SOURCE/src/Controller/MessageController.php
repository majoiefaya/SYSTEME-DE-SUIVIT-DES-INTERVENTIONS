<?php

namespace App\Controller;

use App\Entity\Message;
use App\Entity\Utilisateur;
use App\Form\MessageType;
use App\Entity\Employe;
use App\Repository\EmployeRepository;
use App\Repository\MessageRepository;
use App\Repository\UtilisateurRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/message')]
class MessageController extends AbstractController
{
    #[Route('/ListeDesMessagesDeLEmployeN/{id}', name: 'ListeMessages', methods: ['GET'])]
    public function index(MessageRepository $messageRepository,EmployeRepository $employeRepository,Employe $employe): Response
    {

        $messages=$employe->getMessage();
        return $this->render('message/ListeContactsEmploye.html.twig', [
            'Sender'=>$employe,
            'utilisateurs'=>$employeRepository->findAll()
        ]);
    }
    #[Route('/AccederALaConversationAvecLEmployeN/Sender{Sender}/Receiver{Receiver}', name: 'AccesConversation', methods: ['GET','POST'])]
    public function AccesConversation($Sender,$Receiver,MessageRepository $messageRepository,EmployeRepository $employeRepository,Request $request,UtilisateurRepository $utilisateurRepository): Response
    {
        $MessageSender=$utilisateurRepository->findOneBy(["id"=>$Sender]);
        $MessageReceiver=$utilisateurRepository->findOneBy(["id"=>$Receiver]);
        return $this->render('message/Conversation.html.twig', [
            'utilisateurs'=>$employeRepository->findAll(),
            'Sender'=>$MessageSender,
            'Receiver'=>$MessageReceiver,
            'MessagesEntrant'=>$messageRepository->MessagesEntrant($Sender,$Receiver),
            'MessagesSortant'=>$messageRepository->MessagesSortant($Sender,$Receiver),
            'Messages'=>$messageRepository->findAll()
        ]);
    }
    

    #[Route('/EnvoyerUnMessageALUtilisateurN/{Sender}/{Receiver}', name: 'EnvoyerMessage', methods: ['GET','POST'])]
    public function SendMessage(Request $request,$Sender,$Receiver,MessageRepository $messageRepository,UtilisateurRepository $utilisateurRepository): Response
    {
         // On récupère les données
         $donnees = json_decode($request->getContent());

         if(
             isset($donnees->message) && !empty($donnees->message)
         ){
             // Les données sont complètes
             // On initialise un code
             $code = 200;
             $message=new Message();
             // On vérifie si l'id existe
             if(!$message){
                 // On instancie un Evenement
                 // On change le code
                 $code = 201;
             }
 
             // on set Les données
            
                $dateActuelle=new \DateTime();
                $Sender=$utilisateurRepository->findOneBy(["id"=>$Sender]);
                $Receiver=$utilisateurRepository->findOneBy(["id"=>$Receiver]);
                $Message=$request->request->get('msg');
                $message=new Message();

                $message->setMessageSender($Sender);
                $message->setMessageReceiver($Receiver);
                $message->setContenu($donnees->message);
                $message->setDateEnvoi($dateActuelle);
                $messageRepository->add($message,true);
        
             // On retourne le code
             return new Response('Ok', $code);
         }else{
             // Les données sont incomplètes
             return new Response('Données incomplètes', 404);
         }

        return $this->redirectToRoute('AccesConversation', [
            "Sender"=>$Sender->getId(),
            "Receiver"=>$Receiver->getId()
        ], Response::HTTP_SEE_OTHER);
       
    }


    #[Route('/new', name: 'app_message_new', methods: ['GET', 'POST'])]
    public function new(Request $request, MessageRepository $messageRepository): Response
    {
        $message = new Message();
        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $messageRepository->add($message, true);

            return $this->redirectToRoute('app_message_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('message/new.html.twig', [
            'message' => $message,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_message_show', methods: ['GET'])]
    public function show(Message $message): Response
    {
        return $this->render('message/show.html.twig', [
            'message' => $message,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_message_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Message $message, MessageRepository $messageRepository): Response
    {
        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $messageRepository->add($message, true);

            return $this->redirectToRoute('app_message_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('message/edit.html.twig', [
            'message' => $message,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_message_delete', methods: ['POST'])]
    public function delete(Request $request, Message $message, MessageRepository $messageRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$message->getId(), $request->request->get('_token'))) {
            $messageRepository->remove($message, true);
        }

        return $this->redirectToRoute('app_message_index', [], Response::HTTP_SEE_OTHER);
    }
}
