<?php

namespace App\Twig;

    use App\Entity\User;
    use App\Entity\Order;
    use App\Repository\OrderRepository;
    use Symfony\Component\Security\Http\Attribute\CurrentUser;
    use Twig\Extension\AbstractExtension;
    use Twig\Extension\GlobalsInterface;
    use Symfony\Bundle\SecurityBundle\Security;

class CartExtension extends AbstractExtension implements GlobalsInterface
{
    public function __construct(
        private Security $security,
        private OrderRepository $orderRepository,
    ) {
    }

    public function getGlobals(): array
    {
        $user = $this->security->getUser();
        $productInCart = 0;
        if(!empty($user))
        {
            $productInCart = $this->calculateProductsInCart();
        }
        return [
            'productInCart' => $productInCart,
        ];
    }

    private function calculateProductsInCart(): int
    {
        $user = $this->security->getUser();
        $totalProducts = 0;
        $order = $this->orderRepository->findOneBy( ['UserClass' => $user], ['id' => 'DESC'] );
        if($order)
        {
            $items = $order->getItems();
            foreach ($items as $item) {
                $totalProducts += $item->getQuantity();
            }
        }
        return $totalProducts;
    }
}