<?php

namespace App\Controller;

use App\Entity\Contenir;
use App\Entity\Panier;
use App\Entity\Produit;
use App\Repository\PanierRepository;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\Void_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     */
    public function index(ProduitRepository $produitRepository): Response
    {
        return $this->render('accueil/index.html.twig', [
            'produits' => $produitRepository->findAll(),
        ]);
    }
    /**
     * @Route ("/add/{id}", name="accueil_add")
     */

    public function add(EntityManagerInterface $manager, Produit $produit, SessionInterface $session, PanierRepository $panierRepository) :RedirectResponse
    {
        //$session->clear();
        $contenir = new Contenir();
        $produits = $session->get('les_produits',array());

        $lesPaniers = $panierRepository->findAll();
        if(count($lesPaniers) != 0){
            $panier = $lesPaniers[0];
        }else{
            $panier = new Panier();
            $panier->setDateCreation(new \DateTime(date("Y/m/d")));
            $panier->setMontantTotal(0);
            $manager->persist($panier);
            $manager->flush();
        }

        if(!isset($produits[$produit->getId()])){
            $produits[$produit->getId()]["objProduit"] = $produit;
            $produits[$produit->getId()]["quantite"] = 1;

            $contenir->setIdProduit($produit);
            $contenir->setIdPanier($panier);
            $contenir->setQuantite(1);
            $manager->persist($contenir);


        }else{
            $produits[$produit->getId()]["quantite"]++;
            $contenir = $manager->getRepository(Contenir::class)->findAll();
            foreach ($contenir as $key => $unProduit){
                if($unProduit->getIdProduit()->getId() == $produit->getId()){
                    $contenir[$key]->setQuantite($contenir[$key]->getQuantite()+1);
                }
            }
            $manager->flush();
        }

        $panier->setMontantTotal($panier->getMontantTotal()+$produit->getTarif());
        $manager->flush();

        $session->set('les_produits',$produits);

        return $this->redirectToRoute('accueil');
    }
    
}
