<?php

namespace App\Repository;

use App\Entity\Produit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Produit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Produit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Produit[]    findAll()
 * @method Produit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProduitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Produit::class);
    }

     /**
      * @return Produit[] Returns an array of Produit objects
     */
    
    public function findByTitre($value )
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.titre LIKE  :val')
            ->setParameter('val',"%".$value."%")
            ->orderBy('p.titre', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
       public function findByTitreCategorieDescription($rechercher )
    {
    //version avec EntityManager      
//           $entityManager = $this->getEntityManager();
//           $requete = $entityManager->createQuery("SELECT p FROM App\Entity\Produit p WHERE p.categorie LIKE
//                  '%$rechercher%' OR p.titre LIKE '%$rechercher%' OR p.description LIKE '%$rechercher%' ");        
//           return $requete->getResult();
           
  // Version avec createBuilder         
        return $this->createQueryBuilder('p')
            ->andWhere('p.titre LIKE :val OR p.categorie LIKE :val OR p.couleur LIKE :val')
            ->setParameter('val',"%".$rechercher."%")
            ->orderBy('p.titre', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    /*
    public function findOneBySomeField($value): ?Produit
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
