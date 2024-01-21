<?php

namespace App\Controller;

use App\Entity\Country;
use App\Entity\UserApp;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Serializer\SerializerInterface;


class FrontEndController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(SerializerInterface $serializer, #[CurrentUser] UserApp $user = null): Response
    {
        return $this->render('front_end/index.html.twig', [
            'error' => null,
            'userData' => $user ? $serializer->serialize($user, 'jsonld', [
                'groups' => ['user:read']
            ]) : null
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

    #[Route('/country/{countryId}', name: 'app_country_info')]
    public function countryInfo(Country $countryId, #[CurrentUser] UserApp $user = null, SerializerInterface $serializer): Response
    {
        if(!$user) {
            return $this->redirectToRoute('app_login_panel');
        }

        return $this->render('front_end/countryInfo.html.twig', [
            'error' => null,
            'countryData' => $countryId,
            'userData' => $serializer->serialize($user, 'jsonld', [
                'groups' => ['user:read']
            ])
        ]);
    }

}
