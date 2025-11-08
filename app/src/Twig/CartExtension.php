<?php

namespace App\Twig;

    use App\Entity\User;
    use Twig\Extension\AbstractExtension;
    use Twig\Extension\GlobalsInterface;
    use Symfony\Bundle\SecurityBundle\Security;

class CartExtension extends AbstractExtension implements GlobalsInterface
{
    public function __construct(
        private Security $security
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
        $user,
    ): int
    {
        $order = $user->getOrderClass();
        if ($order === null) {
            return 0;
        }

        $totalProducts = 0;
        foreach ($order->getItems() as $item) {
            $totalProducts += $item->getQuantity();
        }

        return $totalProducts;
    }
}