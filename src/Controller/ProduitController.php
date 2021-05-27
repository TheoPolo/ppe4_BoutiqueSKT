<?php

namespace App\Controller;

use App\Entity\Contenir;
use App\Entity\Panier;
use App\Entity\Produit;
use App\Form\ProduitType;
use App\Repository\CategorieRepository;
use App\Repository\PanierRepository;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use http\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
/**
 * @Route("/produit")
 */
class ProduitController extends AbstractController
{
    /**
     * @Route("/", name="produit_index", methods={"GET"})
     */
    public function index(ProduitRepository $produitRepository, CategorieRepository $categorieRepository): Response
    {
        return $this->render('produit/index.html.twig', [
            'produits' => $produitRepository->findAll(),
            'categories' => $categorieRepository->findAll(),
        ]);
    }

    /**
     * @Route("/api/{id}", name="api_produit_show")
     * @param Produit $produit
     * @return Response
     */
    public function webserviceById(Produit $produit):Response{
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        $reponse = new Response();
        $reponse->setContent($serializer->serialize($produit, 'json'));
        $reponse->headers->set('Content-Type', 'application/json');
        return $reponse;
    }

    /**
     * @Route("/new", name="produit_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $produit = new Produit();
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($produit);
            $entityManager->flush();

            return $this->redirectToRoute('produit_index');
        }

        return $this->render('produit/new.html.twig', [
            'produit' => $produit,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="produit_show", methods={"GET"})
     */
    public function show(Produit $produit): Response
    {
        return $this->render('produit/show.html.twig', [
            'produit' => $produit,
        ]);
    }


    /**
     * @Route("/{id}", name="produit_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Produit $produit): Response
    {
        if ($this->isCsrfTokenValid('delete' . $produit->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($produit);
            $entityManager->flush();
        }

        return $this->redirectToRoute('produit_index');
    }

    /**
     * @Route ("/add/{id}", name="produit_add")
     */

    public function add(EntityManagerInterface $manager, Produit $produit, SessionInterface $session, PanierRepository $panierRepository): RedirectResponse
    {
        //$session->clear();
        $contenir = new Contenir();
        $produits = $session->get('les_produits', array());

        $lesPaniers = $panierRepository->findAll();
        if (count($lesPaniers) != 0) {
            $panier = $lesPaniers[0];
        } else {
            $panier = new Panier();
            $panier->setDateCreation(new \DateTime(date("Y/m/d")));
            $panier->setMontantTotal(0);
            $manager->persist($panier);
            $manager->flush();
        }

        if (!isset($produits[$produit->getId()])) {
            $produits[$produit->getId()]["objProduit"] = $produit;
            $produits[$produit->getId()]["quantite"] = 1;

            $contenir->setIdProduit($produit);
            $contenir->setIdPanier($panier);
            $contenir->setQuantite(1);
            $manager->persist($contenir);


        } else {
            $produits[$produit->getId()]["quantite"]++;
            $contenir = $manager->getRepository(Contenir::class)->findAll();
            foreach ($contenir as $key => $unProduit) {
                if ($unProduit->getIdProduit()->getId() == $produit->getId()) {
                    $contenir[$key]->setQuantite($contenir[$key]->getQuantite() + 1);
                }
            }
            $manager->flush();
        }

        $panier->setMontantTotal($panier->getMontantTotal() + $produit->getTarif());
        $manager->flush();

        $session->set('les_produits', $produits);

        return $this->redirectToRoute('produit_index');
    }

    /**
     * @Route ("/filter", name="filter")
     * @param Request $request
     * @param ProduitRepository $produitRepository
     * @param CategorieRepository $categorieRepository
     * @return Response
     */
    public function filter(Request $request, ProduitRepository $produitRepository, CategorieRepository $categorieRepository):Response
    {
        $data = $request->request->all();
        $cat = $categorieRepository->findBy(['id' => $data['taille']]);
        $produit = $produitRepository->findBy(['id_categorie' => $cat]);

        return $this->render('produit/index.html.twig', [
            'categories' => $categorieRepository->findAll(),
            'produits' => $produit,
        ]);
    }

}