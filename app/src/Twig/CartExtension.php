<?php

namespace App\Twig;

    use App\Entity\User;
    use App\Entity\Order;
    use App\Repository\OrderRepository;
    use Twig\Extension\AbstractExtension;
    use Twig\Extension\GlobalsInterface;
    use Symfony\Bundle\SecurityBundle\Security;

class CartExtension extends AbstractExtension implements GlobalsInterface
{
    public function __construct(
        private Security $security,
        public OrderRepository $orderRepository,
    ) {
    }

    public function getGlobals(): array
    {
        $user = $this->security->getUser();
        $productInCart = 0;
        if($user instanceof User)
        {
            $productInCart = $this->calculateProductsInCart($user);
        }
        return [
            'productInCart' => $productInCart,
        ];
    }

    private function calculateProductsInCart(
        $user
    ): int
    {
        $order = $user->getOrderClass();

        $totalProducts = 0;

        $order = $this->orderRepository->findOneBy(['id' => $user->getId()]);
        if ($order === null) {
            return 0;
        }
        $items = $order->getItems();


        foreach ($items as $item) {
            $totalProducts += $item->getQuantity();
        }

        return $totalProducts;
    }
}