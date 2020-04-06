<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Membre;
class MembreFixtures extends BaseFixture
{
    public function loadData(ObjectManager $manager)
    
    
    {
        
         $membre = new Membre;
        $membre->setEmail("admin@boutique.fr");
        $membre->setPassword(password_hash("admin", PASSWORD_DEFAULT));
        $membre->setNom("Min");
        $membre->setPrenom("Ad");
        $membre->setAdresse("rue Quelque Part");
        $membre->setCodePostal("75000");
        $membre->setVille("Paris");
        $membre->setRoles(["ROLE_ADMIN", "ROLE_MODERATEUR"]);
        $membre->setCivilite("h");
        $membre->setPseudo("Admin");
        $manager->persist($membre);
        // $product = new Product();
        // $manager->persist($product);
        // la methode createMany est defini dans base fixture.
        $this->createMany(10,"membre", function ($num){
        $membre = new Membre;
        $membre->setEmail("membre".$num."@boutique.fr");
        $membre->setPassword(password_hash("admin". $num,PASSWORD_DEFAULT));
        $membre->setNom($this->faker->lastName);
        $membre->setPrenom($this->faker->firstName);
        $membre->setAdresse($this->faker->address);
        $membre->setVille(substr($this->faker->city,0,20));
        $membre->setCodePostal(substr($this->faker->postcode,0,5));
        $membre->setRoles(["ROLE_ADMIN"]);
        $membre->setCivilite($this->faker->randomElement(["h","f","n"]));
        $membre->setPseudo('membre'.$num);
        return $membre;
       
        });
         $manager->flush();
    }
}
