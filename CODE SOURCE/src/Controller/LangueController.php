<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class LangueController extends AbstractController
{
    #[Route('/langue{locale}', name: 'ChangerLangue')]
    public function ChangerLangue($locale,Request $request): Response
    {

        //On change la langue demandée dans la session

        $request->getSession()->set('_locale',$locale);
       
        //
        return $this->redirect($request->headers->get('referer'));
    }
}
