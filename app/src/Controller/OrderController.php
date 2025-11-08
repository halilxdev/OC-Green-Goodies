<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Order;
use App\Entity\Item;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

final class OrderController extends AbstractController
{
    #[Route('/cart', name: 'getCart')]
    public function getCart(
        #[CurrentUser] ?User $user,
        ProductRepository $productRepository,
        EntityManagerInterface $entityManager,
    ): Response
    {
        return $this->render('order/index.html.twig', [
            'controller_name'   =>  'HomeController',
        ]);

    }

    #[Route('/cart/add/{id}', name: 'addToCart')]
    public function addToCart(
        #[CurrentUser] ?User $user,
        int $id,
        ProductRepository $productReposity,
        EntityManagerInterface $entityManager,
    ): Response
    {
        // Vérification de l'utilisateur, si non connecté : On l'envoi sur la page de login
        if(!$user)
        {
            $this->addFlash('error', 'Vous devez être connecté'); // Pas utilisable
            return $this->redirectToRoute(route: 'login');
        }

        // Récupération du produit
        $product = $productReposity->find($id);

        // Vérification d'une commande existante
        if(empty($user->getOrderclass()))
        {
            $order = new Order();
            $order->setUser($user);
            $order->setTotalPriceNoVAT(0);
            $entityManager->persist($order);
        }else{
            $order = $user->getOrderclass();
            $entityManager->persist($order);
        }

        // Vérification d'un item existant
        $existingItem = null;
        if ($user->getOrderclass()) {
            foreach ($user->getOrderclass()->getItems() as $item) {
                if ($item->getProduct()->getId() === $product->getId()) {
                    $existingItem = $item;
                    break;
                }
            }
        }

        if ($existingItem) {
        // Augmenter la quantité
        $existingItem->setQuantity($existingItem->getQuantity() + 1);
        } else {
            // Créer un nouvel item
            $item = new Item();
            $item->setOrderClass($order);
            $item->setProduct($product);
            $item->setQuantity(1);
            $entityManager->persist($item);
        }

        // Recalcul automatique du prix total sans TVA
        $price = 0;
        foreach($user->getOrderclass()->getItems() as $i)
        {
            $price += $i->getProduct()->getPrice() * $i->getQuantity();
        }
        $order->setTotalPriceNoVAT($price);

        $entityManager->flush();

        // Redirection vers la page initiale
        return $this->redirectToRoute('getProduct', [
            'id'                =>  $id,
            'productInCart'     =>  4,
        ]);

    }
}
