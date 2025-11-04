<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function home(ProductRepository $productRepository): Response
    {
        $homePageProducts = $productRepository->findTheLast9();
        return $this->render('home/index.html.twig', [
            'controller_name'   =>  'HomeController',
            'products'          =>  $homePageProducts,
        ]);
    }
    #[Route('/terms', name: 'terms')]
    public function terms(): Response
    {
        return $this->render('home/terms.html.twig', [
            'controller_name'   =>  'HomeController',
        ]);
    }
}
