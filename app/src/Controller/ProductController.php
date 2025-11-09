<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\Product;
use App\Entity\User;
use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class ProductController extends AbstractController
{
    #[Route('/products', name: 'app_getProducts')]
    public function getProducts(ProductRepository $productRepository): Response
    {
        $products = $productRepository->findAll();
        return $this->render('product/index.html.twig', [
            'controller_name'   =>  'ProductController',
            'products'           =>  $products,
        ]);
    }

    #[Route('/product/{id}', name: 'app_getProduct', requirements: ['id' => '\d+'])]
    public function getProduct(
        int $id,
        #[CurrentUser()] ?User $user,
        ProductRepository $productRepository,
        OrderRepository $orderRepository,
        EntityManagerInterface $entityManager,
    ): Response
    {
        // Chercher le produit
        $product = $productRepository->find($id);
        $existingItem = null;
        // Check si utilisateur connecté
        if($user)
        {
        // Check si le produit est déjà présent dans la commande en cours

            // Chercher la commande en cours
            $order = $orderRepository->findOneBy(['UserClass' => $user->getId()], ['id' => 'DESC']);
            // Si elle n'existe pas, nous la créons
            if($order === null)
            {
                $order = new Order();
                $order->setTotalPriceNoVAT(0);
                $order->setUserClass($user);
                $entityManager->persist($order);
                $entityManager->flush();
                $entityManager->refresh($order);
            }

            // Vérifier si le produit existe dans la commande en cours
            $existingItem = null;
            foreach($order->getItems() as $i)
            {
                $cartProd = $i->getProduct();
                $cartProdId = $cartProd->getId();
                $actualProdId = $product->getId();
                if($cartProdId === $actualProdId)
                {
                    $existingItem = $i;
                }
            }
        }

        return $this->render('product/detail.html.twig', [
            'controller_name'   =>  'ProductController',
            'product'           =>  $product,
            'existing'          =>  $existingItem,
        ]);
    }
}
