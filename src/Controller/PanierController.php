<?php

namespace App\Controller;

use App\Entity\Contenir;
use App\Entity\Panier;
use App\Entity\Produit;
use App\Repository\ContenirRepository;
use App\Repository\PanierRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/panier")
 */

class PanierController extends AbstractController
{
    /**
     * @Route("/", name="panier_index")
     */
    public function index(EntityManagerInterface $manager, ContenirRepository $contenirRepository): Response
    {
        $lePanier = $manager->getRepository(Panier::class)->findAll();

        if(count($lePanier) == 0){
            $lePanier = new Panier();
            $dateCreation = "2020/11/01";

            $lePanier->setDateCreation(date('d/m/y'));
            $lePanier->setMontantTotal(0);
            $manager->persist($lePanier);
            $manager->flush();

            $montant_total = 0;
            $lesProduits = array();
        } else {
            $lePanier = $lePanier[0];

            $dateCreation = $lePanier->getDateCreation();
            $montant_total = $lePanier->getMontantTotal();

            $lesProduits = $manager->getRepository(Contenir::class)->findAll();
        }

        return $this->render('panier/index.html.twig', [
            'contenirs' => $contenirRepository->findAll(),
            'controller_name' => 'PanierController',
            'panier' => $lePanier,
            'date_creation' => $dateCreation,
            'montant_total' => $montant_total,
            'les_produits' => $lesProduits
        ]);
    }

    /**
     * @Route ("/add/{id}", name="panier_add")
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

        return $this->redirectToRoute('panier_index');
    }

    /**
     * @Route ("/deleteProduitPanier/{id}/{idContenir}", name="panier_delProd")
     *
     * @param EntityManagerInterface $manager
     * @param Produit $produit
     * @param SessionInterface $session
     * @param PanierRepository $panierRepository
     * @return Response
     */
    public function deleteProduitPanier(EntityManagerInterface $manager, Produit $produit, Contenir $idContenir, SessionInterface $session, PanierRepository $panierRepository, ContenirRepository $contenirRepository): Response
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

       /* echo '<pre>';
        dump($session);
        dump($produits);
        dump($contenir);
        echo '</pre>';
        die();*/

        if($produits[$produit->getId()]["quantite"] === 1){
            $contenir = $manager->getRepository(Contenir::class)->find($idContenir->getId());
            unset($produits[$produit->getId()]);
            $manager->remove($contenir);
            $manager->flush();

        }else{
            $produits[$produit->getId()]["quantite"]--;
            $contenir = $manager->getRepository(Contenir::class)->findAll();
            foreach ($contenir as $key => $unProduit){
                if($unProduit->getIdProduit()->getId() == $produit->getId()){
                    $contenir[$key]->setQuantite($contenir[$key]->getQuantite()-1);
                }
            }
            $manager->flush();
        }
        $panier->setMontantTotal($panier->getMontantTotal()-$produit->getTarif());
        $manager->flush();

        $session->set('les_produits',$produits);

        return $this->redirectToRoute('panier_index');
    }
}
