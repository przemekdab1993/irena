<?php

namespace App\Controller;

use App\Entity\Country;
use App\Entity\UserApp;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class UserController extends AbstractController
{
    #[Route('/set-country-visited/{country}/{action}', name: 'app_user_set_visited')]
    public function addCountryToVisited(#[CurrentUser] UserApp $user = null, EntityManagerInterface $entityManager, Country $country, $action = null): Response
    {
        if (!$user) {
            return new RedirectResponse('app_login_panel');
        }
        $message = 'Nieprawidłowa operacja';

        if ($action === 'add') {
            $user->addCountriesVisited($country);
            $message = 'Kraj '.$country->getName().' dodany do listy odwiedzonych';
        }
        elseif ($action === 'remove') {
            $user->removeCountriesVisited($country);
            $message = 'Kraj '.$country->getName().' usunięty z listy odwiedzonych';
        }

        $entityManager->persist($user);
        $entityManager->flush();

        return $this->json(['action' => $action ,'message' => $message]);
    }
}
