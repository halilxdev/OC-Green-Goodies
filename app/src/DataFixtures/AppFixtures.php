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
        $product->setFullDescription("Transformez votre routine d'hygiène avec ce kit complet et écologique. Composé de matériaux recyclés et biodégradables, ce kit comprend une brosse à dents en bambou, un gobelet en fibre de bambou, un savon solide naturel et une trousse de toilette en coton bio. Chaque élément a été soigneusement sélectionné pour réduire votre empreinte carbone tout en vous offrant une expérience d'hygiène optimale. Parfait pour la maison ou les voyages, ce kit vous accompagne dans votre démarche zéro déchet.");
        $product->setPrice(24.99);
        $product->setPicture("78e3e6600f07c28090abf9ac0d263bf4473ba9a6.jpg");

        $manager->persist($product);

        $product = new Product();
        $product->setName("Shot tropical");
        $product->setShortDescription("Fruits frais, pressés à froid");
        $product->setFullDescription("Savourez l'authenticité des tropiques avec ce shot vitaminé préparé à partir de fruits frais pressés à froid. Notre méthode de pressage préserve toutes les vitamines et nutriments essentiels, vous offrant un concentré de bienfaits naturels. Composé de mangue, ananas, fruit de la passion et gingembre bio, ce shot énergisant est sans sucre ajouté, sans conservateur et sans colorant artificiel. Idéal pour booster votre système immunitaire et vous donner l'énergie nécessaire pour bien commencer la journée.");
        $product->setPrice(4.50);
        $product->setPicture("0d36171c14b95ab56656af06d7a69ab2d9ee44d0.jpg");

        $manager->persist($product);

        $product = new Product();
        $product->setName("Gourde en bois");
        $product->setShortDescription("50cl, bois d'olivier");
        $product->setFullDescription("Découvrez l'élégance naturelle avec cette gourde artisanale en bois d'olivier massif. Façonnée à la main par des artisans experts, chaque gourde est unique et révèle les magnifiques veines du bois. D'une capacité de 50cl, elle maintient vos boissons à température ambiante tout en leur apportant les bienfaits naturels du bois d'olivier. Son design ergonomique et sa finition lisse en font un compagnon idéal pour vos activités sportives, vos balades ou votre bureau. Un choix durable et esthétique pour remplacer les bouteilles en plastique.");
        $product->setPrice(16.90);
        $product->setPicture("64e347aa5c542819963e653209f118071a79567b.jpg");

        $manager->persist($product);

        $product = new Product();
        $product->setName("Disques Démaquillants x3");
        $product->setShortDescription("Solution efficace pour vous démaquiller en douceur ");
        $product->setFullDescription("Révolutionnez votre routine beauté avec ce lot de 3 disques démaquillants réutilisables et ultra-doux. Fabriqués en coton bio certifié et bambou, ces disques offrent une alternative écologique et économique aux cotons jetables. Leur texture délicate respecte même les peaux les plus sensibles tout en éliminant efficacement maquillage, impuretés et résidus. Lavables en machine jusqu'à 300 fois, ils vous accompagneront pendant des années. Livrés avec un filet de lavage pratique, ils constituent un geste simple mais significatif pour réduire vos déchets quotidiens.");
        $product->setPrice(19.90);
        $product->setPicture("fb8cafcb83102a01875727a5366e6a6fa9a75445.jpg");

        $manager->persist($product);

        $product = new Product();
        $product->setName("Bougie Lavande & Patchouli");
        $product->setShortDescription("Cire naturelle");
        $product->setFullDescription("Créez une atmosphère apaisante et parfumée avec cette bougie artisanale aux huiles essentielles de lavande et patchouli. Coulée dans de la cire de soja 100% naturelle et non-toxique, elle brûle proprement pendant 45 heures environ. L'alliance de la lavande relaxante et du patchouli envoûtant vous transporte dans un cocon de sérénité, idéal pour vos moments de détente, méditation ou soirées cocooning. Sa mèche en coton naturel assure une combustion uniforme, tandis que son pot en verre peut être réutilisé une fois la bougie terminée.");
        $product->setPrice(32.00);
        $product->setPicture("dc415efac4700f712d7bef2fade2b494d4d2cd98.jpg");

        $manager->persist($product);

        $product = new Product();
        $product->setName("Brosse à dent");
        $product->setShortDescription("Bois de hêtre rouge issu de forêts gérées durablement");
        $product->setFullDescription("Adoptez une hygiène bucco-dentaire respectueuse de l'environnement avec cette brosse à dents en bois de hêtre rouge. Issue de forêts européennes gérées durablement et certifiées FSC, cette brosse allie performance et écologie. Ses poils medium en nylon recyclé offrent un brossage efficace tout en respectant vos gencives. Son manche ergonomique en bois naturel non traité est agréable en main et résiste à l'humidité. Biodégradable en fin de vie (après retrait des poils), elle remplace avantageusement les brosses en plastique traditionnelles.");
        $product->setPrice(5.40);
        $product->setPicture("486b684fedebd52c007e82d992ba79ed0df88597.jpg");

        $manager->persist($product);

        $product = new Product();
        $product->setName("Kit couvert en bois");
        $product->setShortDescription("Revêtement Bio en olivier & sac de transport");
        $product->setFullDescription("Emportez partout avec vous ce kit de couverts nomade en bois d'olivier, la solution parfaite pour dire non aux couverts jetables. Ce set complet comprend une fourchette, un couteau, une cuillère et des baguettes, tous finement polis et traités avec une huile bio protectrice. Le sac de transport en coton bio permet un rangement hygiénique et pratique. Léger, résistant et naturellement antibactérien, ce kit vous accompagne au bureau, en pique-nique ou en voyage, contribuant ainsi à réduire considérablement vos déchets plastiques.");
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
        $product->setFullDescription("Savourez toute la douceur de ce savon artisanal aux huiles essentielles de thé vert, orange douce et girofle. Saponifié à froid selon une méthode traditionnelle, ce savon surgras à 8% nourrit et protège votre peau tout en la parfumant délicatement. Enrichi en beurre de karité bio et huile d'olive vierge, il convient à tous les types de peau, même les plus sensibles. Ses ingrédients 100% naturels et biologiques garantissent un soin authentique sans sulfates ni parabènes. Un véritable moment de bien-être quotidien dans le respect de votre peau et de l'environnement.");
        $product->setPrice(18.90);
        $product->setPicture("b3e02521fa1216c1cf674ce8c25148d240677fed.jpg");

        $manager->persist($product);

        // Création d'un user simple
        $user = new User();
        $user->setEmail("halilxvb@outlook.fr");
        $user->setPassword($this->userPasswordHasher->hashPassword($user, "password"));
        $user->setFirstName("Halil");
        $user->setLastName("Dddddddd");
        $user->setHasApiAccess(true);

        $manager->persist($user);

        // Création d'un user simple
        $user = new User();
        $user->setEmail("j.courbet@gmail.com");
        $user->setPassword($this->userPasswordHasher->hashPassword($user, "password"));
        $user->setFirstName("Julien");
        $user->setLastName("Courbet");

        $manager->persist($user);

        $manager->flush();

    }
}
