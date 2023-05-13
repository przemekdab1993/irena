<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Twig\Environment;

class FrontEndController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(): Response
    {
        
        return $this->render('front_end/index.html.twig', [
            'error' => null,
            'user' => null//$serializer->serialize($this->getUser(), 'jsonld')
        ]);
    }

    #[Route('/login-panel', name: 'app_login_panel')]
    public function login(): Response
    {
        return $this->render('front_end/loginPanel.html.twig', [
            'error' => null,
            'user' => null//$serializer->serialize($this->getUser(), 'jsonld')
        ]);
    }

    #[Route('/sign-up', name: 'app_sign_up')]
    public function singUp(): Response
    {
        return $this->render('front_end/loginPanel.html.twig', [
            'error' => null,
            'user' => null//$serializer->serialize($this->getUser(), 'jsonld')
        ]);
    }

}
