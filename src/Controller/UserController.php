<?php

namespace App\Controller;

use App\Entity\Country;
use App\Entity\UserApp;
use App\Repository\UserAppRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Serializer\SerializerInterface;

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
            $user->addCountriesVisited($country);
            $message = 'Kraj '.$country->getName().' dodany do listy odwiedzonych';
        }
        elseif ($action === 'remove') {
            $user->removeCountriesVisited($country);
            $message = 'Kraj '.$country->getName().' usunięty z listy odwiedzonych';
        }

        $this->entityManager->flush();

        return $this->json(['action' => $action ,'message' => $message]);
    }

    #[Route('/users-list', name: 'app_users_list')]
    public function usersList(SerializerInterface $serializer, #[CurrentUser] UserApp $user = null, UserAppRepository $userAppRepository) : Response
    {
        $usersApp = $userAppRepository->findAll();

        return $this->render('user/usersList.html.twig', [
            'error' => null,
            'usersList' => $usersApp,
            'userData' => $serializer->serialize($user, 'jsonld', [
                'groups' => ['user:read']
            ])
        ]);
    }

    #[Route('/user-profile/{username}', name: 'app_user_profile')]
    public function userProfile(SerializerInterface $serializer, #[CurrentUser] UserApp $user = null, UserApp $userApp) : Response
    {
        if ($user === $userApp) {
            return $this->redirectToRoute('app_my_profile');
        }

        return $this->render('user/userProfile.html.twig', [
            'error' => null,
            'user' => $userApp,
            'userData' => $serializer->serialize($user, 'jsonld', [
                'groups' => ['user:read']
            ])
        ]);
    }

    #[Route('/my-profile', name: 'app_my_profile')]
    public function myProfile(SerializerInterface $serializer, #[CurrentUser] UserApp $user = null) : Response
    {

        return $this->render('user/myProfile.html.twig', [
            'error' => null,
            'userData' => $serializer->serialize($user, 'jsonld', [
                'groups' => ['user:read']
            ])
        ]);
    }
}
