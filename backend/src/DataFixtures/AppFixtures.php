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

        // Création de 9 produits
        $product = new Product();
        $product->setName("Kit d'hygiène recyclable");
        $product->setShortDescription("Pour une salle de bain éco-friendly");
        $product->setFullDescription("e");
        $product->setPrice(24.99);
        $product->setPicture("78e3e6600f07c28090abf9ac0d263bf4473ba9a6.jpg");

        $manager->persist($product);

        $product = new Product();
        $product->setName("Shot tropical");
        $product->setShortDescription("Fruits frais, pressés à froid");
        $product->setFullDescription("e");
        $product->setPrice(4.50);
        $product->setPicture("0d36171c14b95ab56656af06d7a69ab2d9ee44d0.jpg");

        $manager->persist($product);

        $product = new Product();
        $product->setName("Gourde en bois");
        $product->setShortDescription("50cl, bois d’olivier");
        $product->setFullDescription("e");
        $product->setPrice(16.90);
        $product->setPicture("64e347aa5c542819963e653209f118071a79567b.jpg");

        $manager->persist($product);

        $product = new Product();
        $product->setName("Disques Démaquillants x3");
        $product->setShortDescription("Solution efficace pour vous démaquiller en douceur ");
        $product->setFullDescription("e");
        $product->setPrice(19.90);
        $product->setPicture("fb8cafcb83102a01875727a5366e6a6fa9a75445.jpg");

        $manager->persist($product);

        $product = new Product();
        $product->setName("Bougie Lavande & Patchouli");
        $product->setShortDescription("Cire naturelle");
        $product->setFullDescription("e");
        $product->setPrice(32.00);
        $product->setPicture("dc415efac4700f712d7bef2fade2b494d4d2cd98.jpg");

        $manager->persist($product);

        $product = new Product();
        $product->setName("Brosse à dent");
        $product->setShortDescription("Bois de hêtre rouge issu de forêts gérées durablement");
        $product->setFullDescription("e");
        $product->setPrice(5.40);
        $product->setPicture("486b684fedebd52c007e82d992ba79ed0df88597.jpg");

        $manager->persist($product);

        $product = new Product();
        $product->setName("Kit couvert en bois");
        $product->setShortDescription("Revêtement Bio en olivier & sac de transport");
        $product->setFullDescription("e");
        $product->setPrice(12.30);
        $product->setPicture("0b156bb49499862906fd402eb6ed9de766d7b289.jpg");

        $manager->persist($product);

        $product = new Product();
        $product->setName("Nécessaire, déodorant Bio");
        $product->setShortDescription("50ml déodorant à l’eucalyptus");
        $product->setFullDescription("Déodorant Nécessaire, une formule révolutionnaire composée exclusivement d'ingrédients naturels pour une protection efficace et bienfaisante. Chaque flacon de 50 ml renferme le secret d'une fraîcheur longue durée, sans compromettre votre bien-être ni l'environnement. Conçu avec soin, ce déodorant allie le pouvoir antibactérien des extraits de plantes aux vertus apaisantes des huiles essentielles, assurant une sensation de confort toute la journée. Grâce à sa formule non irritante et respectueuse de votre peau, Nécessaire offre une alternative saine aux déodorants conventionnels, tout en préservant l'équilibre naturel de votre corps.");
        $product->setPrice(8.50);
        $product->setPicture("ba20c61715cd7d442e6e9686d8678f0c1236a01f.jpg");

        $manager->persist($product);

        $product = new Product();
        $product->setName("Savon BIO");
        $product->setShortDescription("Thé, Orange & Girofle");
        $product->setFullDescription("e");
        $product->setPrice(18.90);
        $product->setPicture("b3e02521fa1216c1cf674ce8c25148d240677fed.jpg");

        $manager->persist($product);

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
