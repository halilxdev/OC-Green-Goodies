<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Order;
use App\Entity\Item;
use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class OrderController extends AbstractController
{

    public function __construct(
        private OrderRepository $orderRepository,
    )
    {}

    #[Route('/cart', name: 'app_getCart')]
    #[IsGranted('ROLE_USER')]
    public function getCart(
        #[CurrentUser] ?User $user,
    ): Response
    {
        $items = [];
        $totalPrice = 0;

        $orderClass = $this->orderRepository->findOneBy( ['UserClass' => $user->getId()], ['id' => 'DESC'] );

        if($user && ($orderClass != null))
        {
            $order = $orderClass->getItems();
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
            $totalPrice = $orderClass->getTotalPriceNoVAT();
        }

        return $this->render('order/index.html.twig', [
            'controller_name'   =>  'HomeController',
            'items'             =>  $items,
            'totalPrice'        =>  $totalPrice,
        ]);

    }

    #[Route('/clear-cart', name: 'app_clearCart')]
    #[IsGranted('ROLE_USER')]
    public function clearCart(
        #[CurrentUser] ?User $user,
        EntityManagerInterface $entityManager,
    ): Response
    {
        $order = $this->orderRepository->findOneBy( ['UserClass' => $user->getId()], ['id' => 'DESC'] );
        if ($order) {
            // Supprimer tous les items d'abord
            foreach ($order->getItems() as $item) {
                $entityManager->remove($item);
            }
            $user->removeOrderclass($order);
            $entityManager->remove($order);
            $entityManager->persist($user);
        }
        $entityManager->flush();
        $this->addFlash('info', 'Le panier a bien été vidé.');
        return $this->redirectToRoute('app_getCart');
    }

    #[Route('/cart/add/{id}', name: 'app_addToCart')]
    #[IsGranted('ROLE_USER')]
    public function addToCart(
        #[CurrentUser] ?User $user,
        int $id,
        ProductRepository $productReposity,
        EntityManagerInterface $entityManager,
        OrderRepository $orderRepository,
    ): Response
    {
        // Récupération du produit
        $product = $productReposity->find($id);

        // Récupération d'une commande ou création d'une nouvelle
        $order = $orderRepository->findOneBy(['UserClass' => $user->getId()], ['id' => 'DESC']);
        if( !isset($order) )
        {
            $order = new Order();
            $order->setUserClass($user);
            $order->setTotalPriceNoVAT(0);
            $entityManager->persist($order);
            $entityManager->flush();
        }

        // Vérification d'un item existant
        $existingItem = null;
        foreach ($order->getItems() as $item) {
            if ($item->getProduct()->getId() === $product->getId()) {
                $existingItem = $item;
                break;
            }
        }

        if ($existingItem) {
            // Augmenter la quantité
            $existingItem->setQuantity($existingItem->getQuantity() + 1);
            $entityManager->persist($existingItem);
        } else {
            // Créer un nouvel item
            $item = new Item();
            $item->setOrderClass($order);
            $item->setProduct($product);
            $item->setQuantity(1);
            $entityManager->persist($item);
        }

        $entityManager->flush(); // Flush pour créer les items en base
        $entityManager->refresh($order); // Refresh pour recharger la collection d'items

        // Recalcul automatique du prix total
        $price = 0;
        foreach($order->getItems() as $i)
        {
            $price += $i->getProduct()->getPrice() * $i->getQuantity();
        }
        $order->setTotalPriceNoVAT($price);
        $entityManager->persist($order);

        $entityManager->flush(); // Flush final

        // Redirection vers la page initiale
        $this->addFlash('success', 'Produit ajouté dans votre panier !');
        return $this->redirectToRoute('app_getProduct', [
            'id'                =>  $id,
        ]);

    }
}
