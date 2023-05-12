<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function login(): Response
    {
        return $this->render('front_end/login.html.twig', [
            'error' => null,
            'user' => null//$serializer->serialize($this->getUser(), 'jsonld')
        ]);
    }
}
