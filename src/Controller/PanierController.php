<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface as Session;
use App\Repository\ProduitRepository;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/panier")
 */
class PanierController extends AbstractController {

    /**
     * @Route("/", name="panier")
     */
    public function index(Session $session) {
        $panier = $session->get("panier");
        return $this->render('panier/index.html.twig', [
                    'panier' => $panier
        ]);
    }

    /**
     * @Route("/ajouter-panier/{id}", name="ajouter_panier")
     */
    public function AjouterPanier(Session $session, Request $request, ProduitRepository $produitRepository, $id) {

        $produitRajouter = $produitRepository->find($id);
        $panier = $session->get("panier", []);
        $qte = $request->query->get("qte");
        $qte = empty($qte) ? 1 : $qte;
        $existe = false;
        foreach ($panier as $indice => $ligne) {
            if ($produitRajouter->getId() == $ligne["produit"]->getId()) {
                $qte += $ligne["qte"];
                $panier[$indice] = ["produit" => $produitRajouter, "qte" => $qte];
                $existe = true;
            }
        }
        if (!$existe) {
            $panier[] = ["produit" => $produitRajouter, "qte" => $qte];
        }

        $this->addFlash('success',"le produit à été rajouté au panier");
        $session->set("panier", $panier);
        return $this->redirectToRoute("home");
    }

    /**
     * @Route("/viderpanier", name="vider_panier")
     */
    public function viderPanier(Session $session) {


        $session->remove("panier");
        return $this->redirectToRoute("home");
    }

    /**
     * @Route("/supprimer-produit/{id}", name="supprimer_produit_panier")
     */
    public function SupprimerProduit(Session $session, $id) {

        $panier = $session->get("panier");
        foreach ($panier as $indice => $ligne){
            if($ligne["produit"]->getId() ==$id){
                unset($panier[$indice]);
                break;
            }
        }
        $session->set("panier",$panier);
        return $this->redirectToRoute("panier");
    }

    
        /**
     * @Route("/modifier-panier/{id}", name="modifier_panier")
     */
    public function ModifierPanier(Session $session,Request $request, $id) {

        $panier = $session->get("panier");
        $qte = $request->query->get("qte");
        foreach ($panier as $indice => $ligne){
            if($ligne["produit"]->getId() ==$id){
                $panier[$indice]["qte"]= $qte;
                break;
            }
        }
        $session->set("panier",$panier);
        return $this->redirectToRoute("panier");
    }
    
}
