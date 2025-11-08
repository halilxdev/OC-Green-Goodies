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
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class OrderController extends AbstractController
{
    #[Route('/cart', name: 'getCart')]
    #[IsGranted('ROLE_USER')]
    public function getCart(
        #[CurrentUser] ?User $user,
        ProductRepository $productRepository,
        EntityManagerInterface $entityManager,
    ): Response
    {
        $items = [];
        $totalPrice = 0;

        if($user && !empty($user->getOrderclass()))
        {
            $order = $user->getOrderClass()->getItems();
            foreach($order as $item)
            {
                $items[] = [
                    'id'        =>  $item->getProduct()->getId(),
                    'name'      =>  $item->getProduct()->getName(),
                    'price'     =>  $item->getProduct()->getPrice() * $item->getQuantity(),
                    'quantity'  =>  $item->getQuantity(),
                    'picture'   =>  $item->getProduct()->getPicture(),
                ];
            }
            $totalPrice = $user->getOrderclass()->getTotalPriceNoVAT();
        }

        return $this->render('order/index.html.twig', [
            'controller_name'   =>  'HomeController',
            'items'             =>  $items,
            'totalPrice'        =>  $totalPrice,
        ]);

    }

    #[Route('/clear-cart', name: 'clearCart')]
    #[IsGranted('ROLE_USER')]
    public function clearCart(
        #[CurrentUser] ?User $user,
        EntityManagerInterface $entityManager,
    ): Response
    {
        $order = $user->getOrderclass();
        if ($order) {
            // Supprimer tous les items d'abord
            foreach ($order->getItems() as $item) {
                $entityManager->remove($item);
            }
            $user->removeOrderclass();
            $entityManager->remove($order);
            $entityManager->persist($user);
        }
        $entityManager->flush();
        return $this->redirectToRoute('getCart');
    }

    #[Route('/cart/add/{id}', name: 'addToCart')]
    #[IsGranted('ROLE_USER')]
    public function addToCart(
        #[CurrentUser] ?User $user,
        int $id,
        ProductRepository $productReposity,
        EntityManagerInterface $entityManager,
    ): Response
    {
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
        foreach($order->getItems() as $i)
        {
            $price += $i->getProduct()->getPrice() * $i->getQuantity();
        }
        $order->setTotalPriceNoVAT($price);
        $entityManager->persist($order);

        $entityManager->flush();

        // Redirection vers la page initiale
        return $this->redirectToRoute('getProduct', [
            'id'                =>  $id,
            'productInCart'     =>  4,
        ]);

    }
}
