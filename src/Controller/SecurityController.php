<?php

namespace App\Controller;

use ApiPlatform\Api\IriConverterInterface;
use App\Entity\UserApp;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class SecurityController extends AbstractController
{
    #[Route('/login', name: 'app_login', methods: ['POST'])]
    public function login(IriConverterInterface $iriConverter, #[CurrentUser] UserApp $user = null): Response
    {
        if (!$user) {
            return $this->json([
                'error' => 'Invalid login request: check that the Content-Type header is "application/json".',

            ],
            401);
        }

        return new Response(null, 204, [
            'Location' => $iriConverter->getIriFromResource($user)
        ]);
    }

    #[Route('/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \Exception('Thos should never br reached');
    }

    #[Route('/sign-up', name: 'app_sign_up')]
    public function singUp(): Response
    {
        return $this->render('front_end/loginPanel.html.twig', [
            'error' => null,
            'user' => null//$serializer->serialize($this->getUser(), 'jsonld')
        ]);
    }
}
