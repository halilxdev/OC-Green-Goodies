<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class ApiController extends AbstractController
{

        /**
     * Cette méthode permet de créer un nouvel utilisateur.
     * Exemple de données :
     * {
     *      "email": "jdupont@green-goodies.fr",
     *      "first_name": "Jean",
     *      "last_name": "Dupont",
     *      "password": "password",
     *      "has_api_access": 0
     * }
     * @return JsonResponse
     */
    // #[Route('/api/user', name: 'createUser', methods: ['GET'])]
    // public function createUser(Request $request, SerializerInterface $serializer, EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher): JsonResponse
    // {
    //     $user = $serializer->deserialize($request->getContent(), type: User::class, format: 'json');
    //     $jsonUser = $serializer->serialize($user, 'json');
    //     return new JsonResponse($jsonUser, Response::HTTP_CREATED, [], true);
    // }

    /**
     * Cette méthode permet de récupérer tous les produits
     *
     */
    #[Route('/api/products', name: 'getAllProducts', methods: ['GET'])]
    public function getAllProducts(ProductRepository $productRepository, SerializerInterface $serializer): JsonResponse
    {
        $productList = $productRepository->findAll();
        $jsonProductList = $serializer->serialize($productList, 'json');
        return new JsonResponse($jsonProductList, Response::HTTP_OK, [], true);

        // Intégrer une vérification d'une clé API
        // IF(USER -> ACTIVÉ L'ACCÈS API DEPUIS SON PROFIL)
    }


    #[Route('/api/login', name: 'ApiTest', methods: ['POST'])]
    public function ApiTest(): JsonResponse
    {
        return $this->json([
            'message' => 'welcome to your new controller!',
            'path' => 'src/Controller/BookController.php',
        ]);
    }
}
