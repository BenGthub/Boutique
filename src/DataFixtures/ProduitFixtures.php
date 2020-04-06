<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Produit;
class ProduitFixtures extends BaseFixture
{
    public function loadData(ObjectManager $manager)
    {
        
        $this->createMany(50, "produit", function($num){
       $produit = new Produit;
       
       $categorie = $this->faker->randomElement(["pull","Pontalon","veste"]);
       $produit->setCategorie($categorie);
       $produit->setReference("produit$num");
       $produit->setTitre("prod$num");
       $produit->setCouleur($this->faker->colorName(["bleu","vert","jaune"]));
       $produit->setTaille($this->faker->randomElement(["S","M","L","XL"]));
       $produit->setPublic($this->faker->randomElement (["h","f","m"]));
       $produit->setPhoto($categorie. ".jpg");
       $produit->setPrix($this->faker->randomFloat(2,10,150));
       $produit->setStock($this->faker->randomNumber(3));
       return $produit;
        });
        $manager->flush();
    }
}
