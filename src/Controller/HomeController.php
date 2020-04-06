<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Produit;
use App\Repository\ProduitRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;


class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(ProduitRepository $pr)
    {
        //1er façon
       // $ListProd = $this -> getDoctrine() -> getRepository(Produit::class)->finAll();
        //seconde façon
        $ListProd = $pr->findAll();
    //    dd($ListProd);
        
        return $this->render('home/index.html.twig', [
            'produits' => $ListProd
        ]);
    }

    
    
        /**
     * @Route("/recherche", name="recherche")
     */
    public function recherche(ProduitRepository $pr, Request $request  )
    {
        
        $motRechercher =$request->query->get("recherche");
        //dd($request);
        if($motRechercher){
        $ListProd = $pr->findByTitreCategorieDescription($motRechercher);
        }else{
            $ListProd=[];
        }
        return $this->render('home/index.html.twig', [
            'produits' => $ListProd,'mot_rechercher '=> $motRechercher
        ]);
        
    }
    
       
 
    
    /**
     * @Route("/test", name="test")
     * @IsGranted("ROLE_DEV")
     */
    
}
