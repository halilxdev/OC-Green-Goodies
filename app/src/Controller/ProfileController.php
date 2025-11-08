<?php

namespace App\Controller;

use App\Entity\Invoice;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'getProfile')]
    #[IsGranted('ROLE_USER')]
    public function getProfile(
        #[CurrentUser()] ?User $user,
    ): Response
    {
        $apiAccess = $user->hasApiAccess();
        return $this->render('profile/index.html.twig', [
            'controller_name'   =>  'ProfileController',
            'apiAccess'         =>  $apiAccess,
        ]);
    }

    #[Route('/delete-profile', name: 'deleteProfile')]
    #[IsGranted('ROLE_USER')]
    public function deleteProfile(
        #[CurrentUser()] ?User $user,
        EntityManagerInterface $entityManager,
        Security $security,
    ): Response
    {
        $order = $user->getOrderclass();
        if ($order) {
            // Supprimer les factures liées à cet order
            $invoiceRepository = $entityManager->getRepository(Invoice::class);
            $invoices = $invoiceRepository->createQueryBuilder('i')
                ->where('i.orderClass = :order')
                ->setParameter('order', $order)
                ->getQuery()
                ->getResult();
            foreach ($invoices as $invoice) {
                $entityManager->remove($invoice);
            }
            // Supprimer tous les items
            foreach ($order->getItems() as $item) {
                $entityManager->remove($item);
            }
            $entityManager->remove($order);
        }
        $entityManager->remove($user);
        $entityManager->flush();
        // Déconnecter l'utilisateur avant la redirection
        $security->logout(false);

        return $this->redirectToRoute('login');
    }

    #[Route('/toggle-api', name: 'toggleApi')]
    #[IsGranted('ROLE_USER')]
    public function toggleApi(
        #[CurrentUser()] ?User $user,
        EntityManagerInterface $entityManager,
    ): Response
    {
        $bool = $user->hasApiAccess();
        if($bool === true)
        {
            $user->setHasApiAccess(0);
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('getProfile');
        }else{
            $user->setHasApiAccess(1);
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('getProfile');
        }
    }
}