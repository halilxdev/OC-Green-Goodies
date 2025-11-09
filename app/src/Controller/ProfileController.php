<?php

namespace App\Controller;

use App\Entity\Invoice;
use App\Entity\User;
use App\Repository\InvoiceRepository;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_getProfile')]
    #[IsGranted('ROLE_USER')]
    public function getProfile(
        #[CurrentUser()] ?User $user,
        OrderRepository $orderRepository,
        InvoiceRepository $invoiceRepository,
    ): Response
    {
        $apiAccess = $user->hasApiAccess();
        $orders = $orderRepository->findBy(['UserClass' => $user], ['id' => 'DESC']);
        $invoices = $invoiceRepository->findBy(['orderClass' => $orders], ['id' => 'DESC']);

        return $this->render('profile/index.html.twig', [
            'controller_name'   =>  'ProfileController',
            'apiAccess'         =>  $apiAccess,
            'invoices'          =>  $invoices,
        ]);
    }

    #[Route('/delete-profile', name: 'app_deleteProfile')]
    #[IsGranted('ROLE_USER')]
    public function deleteProfile(
        #[CurrentUser()] ?User $user,
        EntityManagerInterface $entityManager,
        OrderRepository $orderRepository,
        Security $security,
    ): Response
    {
        $orders = $orderRepository->findBy( ['UserClass'    =>  $user] );
        if ($orders) {
            // Supprimer les factures liées à cet order
            $invoiceRepository = $entityManager->getRepository(Invoice::class);
            $invoices = $invoiceRepository->findBy(['orderClass' => $orders]);
            // Supprimer tous les items 
            foreach ($orders as $order) {
                foreach($order->getItems() as $o)
                {
                    $entityManager->remove($o);
                }
            }
            foreach ($invoices as $invoice) {
                $entityManager->remove($invoice);
            }

            $entityManager->remove($order);
        }
        $entityManager->remove($user);
        $entityManager->flush();
        // Déconnecter l'utilisateur avant la redirection
        $security->logout(false);

        $this->addFlash('info', 'Le compte a bien été supprimé.');
        return $this->redirectToRoute('app_login');
    }

    #[Route('/toggle-api', name: 'app_toggleApi')]
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
            $this->addFlash('success', 'L\'accès API a bien été révoqué.');
            return $this->redirectToRoute('app_getProfile');
        }else{
            $user->setHasApiAccess(1);
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('success', 'L\accès API a bien été activé.');
            return $this->redirectToRoute('app_getProfile');
        }
    }
}