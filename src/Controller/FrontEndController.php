<?php

namespace App\Controller;

use App\Entity\Country;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Serializer\SerializerInterface;


class FrontEndController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(SerializerInterface $serializer, #[CurrentUser] User $user = null): Response
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

    #[Route('/country/{country_id}', name: 'app_country_info')]
    public function countryInfo(Country $country_id, #[CurrentUser] User $user = null, SerializerInterface $serializer): Response
    {
        if(!$user) {
            return $this->redirectToRoute('app_login_panel');
        }
        //dd($country_id);
        return $this->render('front_end/countryInfo.html.twig', [
            'error' => null,
            'countryData' => $country_id,
            'userData' => $serializer->serialize($user, 'jsonld', [
                'groups' => ['user:read']
            ])
        ]);
    }

}
