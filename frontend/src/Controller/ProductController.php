<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class ProductController extends AbstractController
{
    #[Route('/product/{id}', name: 'getProduct', requirements: ['id' => '\d+'])]
    public function getProduct(Request $request, HttpClientInterface $httpClient, int $id): Response
    {
        try {
            $response = $httpClient->request(
                'GET',
                sprintf('http://backend:8000/api/product/'.$id)
            );
            $product = $response->toArray();
            return $this->render('product/index.html.twig', [
                'controller_name'   =>  'ProductController',
                'product'           =>  $product,
            ]);
        } catch (\Exception $e) {
            return new JsonResponse([
                'error' => 'Erreur lors de l\'appel à l\'API',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
