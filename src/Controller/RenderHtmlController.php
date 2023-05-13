<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class RenderHtmlController extends AbstractController
{
    #[Route('/country-list', name: 'app_country_list', methods: ['POST'])]
    public function countryList(Environment $twig, Request $request, LoggerInterface $logger) :Response
    {
        $apiData = $request->request->all();

        $data = $request->getContent();
        $data = json_decode($data);
        $parents = $data->list;


        $htmlContent = $twig->render('render_html/countryList.html.twig', ['data' => $parents]);


        return new Response($htmlContent);
    }
}
