<?php

namespace App\DataFixtures;

use App\Entity\Product;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    private $userPasswordHasher;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordHasher = $userPasswordHasher;
    }

    public function load(ObjectManager $manager): void
    {

        // Création de 3 produits
        $product1 = new Product();
        $product1->setName("Kit d'hygiène recyclable");
        $product1->setShortDescription("Pour une salle de bain éco-friendly");
        $product1->setFullDescription("e");
        $product1->setPrice(24.99);
        $product1->setPicture("78e3e6600f07c28090abf9ac0d263bf4473ba9a6.jpg");

        $manager->persist($product1);

        $product2 = new Product();
        $product2->setName("Shot tropical");
        $product2->setShortDescription("Fruits frais, pressés à froid");
        $product2->setFullDescription("e");
        $product2->setPrice(4.50);
        $product2->setPicture("0d36171c14b95ab56656af06d7a69ab2d9ee44d0.jpg");

        $manager->persist($product2);

        $product3 = new Product();
        $product3->setName("Gourde en bois");
        $product3->setShortDescription("50cl, bois d’olivier");
        $product3->setFullDescription("e");
        $product3->setPrice(16.90);
        $product3->setPicture("64e347aa5c542819963e653209f118071a79567b.jpg");

        $manager->persist($product3);

        // Création d'un user simple
        $user = new User();
        $user->setEmail("halilxvb@outlook.fr");
        $user->setRoles(["ROLE_USER"]);
        $user->setPassword($this->userPasswordHasher->hashPassword($user, "password"));
        $user->setFirstName("Halil");
        $user->setLastName("Deniz");
        $user->setHasAPIAccess(false);

        $manager->persist($user);

        $manager->flush();

    }
}
