<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class ProductController extends AbstractController
{
    #[Route('/products', name: 'getProducts')]
    public function getProducts(ProductRepository $productRepository): Response
    {
        $products = $productRepository->findAll();
        return $this->render('product/index.html.twig', [
            'controller_name'   =>  'ProductController',
            'products'           =>  $products,
        ]);
    }

    #[Route('/product/{id}', name: 'getProduct', requirements: ['id' => '\d+'])]
    public function getProduct(ProductRepository $productRepository, int $id): Response
    {
        $product = $productRepository->find($id);
        return $this->render('product/detail.html.twig', [
            'controller_name'   =>  'ProductController',
            'product'           =>  $product,
        ]);
    }
}
