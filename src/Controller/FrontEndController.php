<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

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

    #[Route('/login', name: 'app_login')]
    public function login(): Response
    {
        return $this->render('front_end/login.html.twig', [
            'error' => null,
            'user' => null//$serializer->serialize($this->getUser(), 'jsonld')
        ]);
    }
    #[Route('/sign-up', name: 'app_sign_up')]
    public function singUp(): Response
    {
        return $this->render('front_end/login.html.twig', [
            'error' => null,
            'user' => null//$serializer->serialize($this->getUser(), 'jsonld')
        ]);
    }
}
