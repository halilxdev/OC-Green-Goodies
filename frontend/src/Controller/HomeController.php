<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function home(Request $request, HttpClientInterface $httpClient): Response
    {
        try {
            $response = $httpClient->request(
                'GET',
                sprintf('http://backend:8000/api/products')
            );
            $arrayProducts = $response->toArray();
            return $this->render('home/index.html.twig', [
                'controller_name'   =>  'HomeController',
                'products'          =>  $arrayProducts,
            ]);
        } catch (\Exception $e) {
            return new JsonResponse([
                'error' => 'Erreur lors de l\'appel à l\'API',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    #[Route('/terms', name: 'terms')]
    public function terms(): Response
    {
        return $this->render('home/terms.html.twig', [
            'controller_name'   =>  'HomeController',
        ]);
    }
}
