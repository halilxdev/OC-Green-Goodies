<?php

namespace App\Controller;

use App\Entity\Invoice;
use App\Entity\Order;
use App\Entity\User;
use App\Enum\InvoiceStatus;
use App\Form\InvoiceFormType;
use App\Repository\InvoiceRepository;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class InvoiceController extends AbstractController
{
    #[Route('/confirm-order', name: 'app_confirmOrder')]
    #[IsGranted('ROLE_USER')]
    public function confirmOrder(
        #[CurrentUser()] ?User $user,
        EntityManagerInterface $entityManager,
        Request $request,
        OrderRepository $orderRepository,
    ): Response
    {
        // Récupération de l'User
        $form = $this->createForm(InvoiceFormType::class, $user);
        $form->handleRequest($request);

        // Récupération des infos du panier
        $order = $orderRepository->findOneBy(['UserClass'   =>  $user], ['id' => 'DESC']);

        // Récupération du prix HT + TVA + TTC
        $totalAmount = $order->getTotalPriceNoVAT();
        $VAT = $order->getTotalPriceNoVAT() * 0.2;
        $totalPrice = $totalAmount + $VAT;

        $orderInfos = [
            'totalAmount'           =>  $totalAmount,
            'VAT'                   =>  $VAT,
            'totalPrice'            =>  $totalPrice,
        ];

        // Création de la facture
        if ($form->isSubmitted() && $form->isValid()) {

            $userAddress = $form->get('address')->getData();
            $userZipCode = $form->get('zipcode')->getData();
            $userCity = $form->get('city')->getData();

            $invoice = new Invoice();
            $invoice->setOrderClass($order);

            $invoice->setAddress($userAddress);
            $invoice->setZipCode($userZipCode);
            $invoice->setCity($userCity);

            $invoice->setVat($VAT);
            $invoice->setTotal($totalPrice);

            $invoice->setStatus(InvoiceStatus::Done);

            $entityManager->persist($invoice);

            $entityManager->persist($order);
            $entityManager->flush();

            $newOrder = new Order();
            $newOrder->setUserClass($user);
            $newOrder->setTotalPriceNoVAT(0);

            $entityManager->persist($user);
            $entityManager->persist($newOrder);

            $entityManager->refresh($user);

            $entityManager->flush();

            return $this->redirectToRoute('app_congratsInvoice');
        }

        return $this->render('invoice/informations.html.twig', [
            'InvoiceForm'       =>  $form,
            'order'             =>  $orderInfos,
        ]);
    }

    #[Route('/invoice/congrats', name: 'app_congratsInvoice')]
    #[IsGranted('ROLE_USER')]
    public function congratsInvoice(): Response
    {
        return $this->render('invoice/congrats.html.twig', [
            'controller_name'   =>  'InvoiceController',
        ]);
    }

    #[Route('/invoice/{id}', name: 'app_createInvoice')]
    #[IsGranted('ROLE_USER')]
    public function createInvoice(int $id, InvoiceRepository $invoiceRepository): Response
    {
        $invoice = $invoiceRepository->find($id);
        return $this->render('invoice/invoice.html.twig', [
            'controller_name'   =>  'InvoiceController',
            'invoice'           =>  $invoice,
        ]);
    }
}
