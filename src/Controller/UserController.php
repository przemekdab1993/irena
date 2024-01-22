<?php

namespace App\Controller;

use App\Entity\Country;
use App\Entity\UserApp;
use App\Entity\UserAppVisitedCountry;
use App\Repository\UserAppVisitedCountryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class UserController extends AbstractController
{
    public function __construct(private EntityManagerInterface $entityManager) {

    }

    #[Route('/set-country-visited/{country}/{action}', name: 'app_user_set_visited', methods: ['GET'])]
    public function addCountryToVisited(#[CurrentUser] UserApp $user = null, Country $country, $action = null): Response
    {
        if (!$user) {
            return new RedirectResponse('app_login_panel');
        }
        $message = 'Nieprawidłowa operacja';

        if ($action === 'add') {
            $visited = new UserAppVisitedCountry();
            $visited->setCountry($country);
            $user->addUserAppVisitedCountry($visited);
            $message = 'Kraj '.$country->getName().' dodany do listy odwiedzonych';
        }
        elseif ($action === 'remove') {

            /**
             * @var UserAppVisitedCountryRepository $userAppVisitedCountry
             */
            $userAppVisitedCountryRepository = $this->entityManager->getRepository(UserAppVisitedCountry::class);
            $userAppVisitedCountry = $userAppVisitedCountryRepository->findOneBy(['userApp' => $user, 'country' => $country]);

            if ($userAppVisitedCountry) {
                $user->removeUserAppVisitedCountry($userAppVisitedCountry);

                $message = 'Kraj '.$country->getName().' usunięty z listy odwiedzonych';
            }

        }

        $this->entityManager->flush();

        return $this->json(['action' => $action ,'message' => $message]);
    }
}
