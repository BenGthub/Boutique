<?php

namespace App\DataFixtures;
use App\Entity\Details;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface as Dependent;
use Doctrine\Common\Persistence\ObjectManager;

class DetailsFixtures extends BaseFixture implements Dependent
{
    public function loadData(ObjectManager $manager)
    {
         $this->createMany("40", "details", function($num){
       $detailsCommande = new Details;
       $detailsCommande->setCommande($this->getRandomReference("commande"));
       $produit = $this->getRandomReference("produit");
       $detailsCommande->setProduit($produit);
       $quantite = $this->faker->randomNumber(1);
       $detailsCommande->setQuantite($quantite);
       $detailsCommande->setPrix($quantite * $produit->getPrix());
       return $detailsCommande;
               
       
         });
        $manager->flush();
    }
    public function getDependencies(){
        return [ CommandeFixtures::class, ProduitFixtures::class ];
    }
}
