<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AuthController extends AbstractController
{
    #[Route('/register', name: 'register')]
    public function register(): Response
    {
        $error = null;
        return $this->render('security/register.html.twig', [
            'controller_name'   => 'AuthController',
            'error'             =>  $error
        ]);
    }

    #[Route('/login', name: 'login')]
    public function login(): Response
    {
        $error = null;
        return $this->render('security/login.html.twig', [
            'controller_name'   =>  'AuthController',
            'error'             =>  $error
        ]);
    }
}
