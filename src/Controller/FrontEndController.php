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

    #[Route('/country-list', name: 'app_country_list', methods: ['POST'])]
    public function countryList(Environment $twig, Request $request, LoggerInterface $logger) :Response
    {
        $apiData = $request->request->all();

        $data = $request->getContent();
        $data = json_decode($data);
        $parents = $data->list;


        $htmlContent = $twig->render('renderHTML/countryList.html.twig', ['data' => $parents]);


        return new Response($htmlContent);
    }
}
