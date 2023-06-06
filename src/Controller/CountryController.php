<?php

namespace App\Controller;

use App\Entity\Country;
use App\Entity\UserApp;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Serializer\SerializerInterface;

class CountryController extends AbstractController
{
    #[Route('/country/{country}', name: 'app_country_info')]
    public function countryInfo(Country $country, #[CurrentUser] UserApp $user = null, SerializerInterface $serializer): Response
    {
        if(!$user) {
            return $this->redirectToRoute('app_login_panel');
        }

        return $this->render('country/countryInfo.html.twig', [
            'error' => null,
            'countryData' => $country,
            'userData' => $serializer->serialize($user, 'jsonld', [
                'groups' => ['user:read']
            ])
        ]);
    }
}
