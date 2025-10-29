<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Routing\Attribute\Route;

final class ProductController extends AbstractController
{
    /**
     * Cette méthode permet de récupérer tous les produits
     *
     */
    #[Route('/api/products', name: 'getAllProducts', methods: ['GET'])]
    public function getAllProducts(ProductRepository $productRepository, SerializerInterface $serializer): JsonResponse
    {
        $productList = $productRepository->findAll();
        $jsonProductList = $serializer->serialize($productList, 'json');
        return new JsonResponse($jsonProductList, Response::HTTP_OK, [], true);

        // Intégrer une vérification d'une clé API
        // IF(USER -> ACTIVÉ L'ACCÈS API DEPUIS SON PROFIL)
    }
    
    /**
     * Cette méthode permet de récupérer un produit
     *
     */
    #[Route('/api/product/{id}', name: 'getProduct', methods: ['GET'], requirements: ['id' => '\d+'])]
    public function getProduct(ProductRepository $productRepository, SerializerInterface $serializer, $id): JsonResponse
    {
        $product = $productRepository->find($id);
        $jsonProduct = $serializer->serialize($product, 'json');
        return new JsonResponse($jsonProduct, Response::HTTP_OK, [], true);
    }
}