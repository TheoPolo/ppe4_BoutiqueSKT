<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use App\Entity\Produit;
use App\Entity\Tag;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $categorie8 = new Categorie();
        $categorie8->setLibelle("8");
        $manager->persist($categorie8);

        $categorie8125 = new Categorie();
        $categorie8125->setLibelle("8.125");
        $manager->persist($categorie8125);

        $categorie825 = new Categorie();
        $categorie825 ->setLibelle("8.25");
        $manager->persist($categorie825);

        $manager->flush();

        $produitJartBoobs = new Produit();
        $produitJartBoobs->setLibelle("Jart Boobs");
        $produitJartBoobs->setTarif(50);
        $produitJartBoobs->setIdCategorie($categorie8);
        $manager->persist($produitJartBoobs);

        $produitPrimitiveHalloween = new Produit();
        $produitPrimitiveHalloween->setLibelle("Primitive Halloween");
        $produitPrimitiveHalloween->setTarif(60);
        $produitPrimitiveHalloween->setIdCategorie($categorie8);
        $manager->persist($produitPrimitiveHalloween);

        $produitAlmostPingPong = new Produit();
        $produitAlmostPingPong->setLibelle("Almost Ping-Pong");
        $produitAlmostPingPong->setTarif(55);
        $produitAlmostPingPong->setIdCategorie($categorie8125);
        $manager->persist($produitAlmostPingPong);

        $produitBakerEntite = new Produit();
        $produitBakerEntite->setLibelle("Baker Vraiment belle");
        $produitBakerEntite->setTarif(55);
        $produitBakerEntite->setIdCategorie($categorie8125);
        $manager->persist($produitBakerEntite);

        $produitPlanBLune = new Produit();
        $produitPlanBLune->setLibelle("Plan B Lune");
        $produitPlanBLune->setTarif(60);
        $produitPlanBLune->setIdCategorie($categorie825);
        $manager->persist($produitPlanBLune);

        $manager->flush();

        $tagTaille8 = new Tag();
        $tagTaille8->setNom("8");
        $manager->persist($tagTaille8);

        $tagTaille8125 = new Tag();
        $tagTaille8125->setNom("8.125");
        $manager->persist($tagTaille8);

        $tagTaille825 = new tag();
        $tagTaille825->setNom("8.25");
        $manager->persist($tagTaille825);

        $tagJart = new tag();
        $tagJart->setNom("Jart");
        $manager->persist($tagJart);

        $tagAlmost = new tag();
        $tagAlmost->setNom("Almost");
        $manager->persist($tagAlmost);

        $tagBaker = new tag();
        $tagBaker->setNom("Baker");
        $manager->persist($tagBaker);

        $tagPlanB = new tag();
        $tagPlanB->setNom("Plan B");
        $manager->persist($tagPlanB);

        $tagPrimitive = new tag();
        $tagPrimitive->setNom("Primitive");
        $manager->persist($tagPrimitive);

        $manager->flush();
    }
}
