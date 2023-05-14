<?php

namespace App\Controller;

use ApiPlatform\Api\IriConverterInterface;
use App\Entity\User;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Twig\Environment;

class RenderHtmlController extends AbstractController
{

    private IriConverterInterface $iriConverter;
    private Environment $twig;

    public function __construct(IriConverterInterface $iriConverter, Environment $twig)
    {
        $this->iriConverter = $iriConverter;
        $this->twig = $twig;
    }

    #[Route('/country-list', name: 'app_country_list', methods: ['POST'])]
    public function countryList(Request $request, LoggerInterface $logger, #[CurrentUser] User $user = null) :Response
    {
        $apiData = $request->request->all();

        $data = $request->getContent();
        $data = json_decode($data);
        $parents = $data->list;


        $htmlContent = $this->twig->render('render_html/countryList.html.twig', [
            'data' => $parents,
            'userCurrent' => $user ? $this->iriConverter->getIriFromResource($user) : null
        ]);


        return new Response($htmlContent);
    }
}
