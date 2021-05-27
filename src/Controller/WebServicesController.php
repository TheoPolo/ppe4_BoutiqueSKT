<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Entity\User;
use App\Repository\ProduitRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Json;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class WebServicesController extends AbstractController
{
    /**
     * @Route("/web/services", name="web_services")
     */
    public function index(): Response
    {
        return $this->render('web_services/index.html.twig', [
            'controller_name' => 'WebServicesController',
        ]);
    }

    /**
     * @Route ("/api/produit", name="produits_show_all")
     */
    public function produits(ProduitRepository $produitRepository): Response{
        return $this->toJson($produitRepository->findAll());
    }

    /**
     * @Route ("/api/produit/{id}", name="produits_show")
     */
    public function produitByID(Produit $produit): Response{
        return $this->toJson([$produit]);
    }

    /**
     * @Route ("/api/user", name="user_show_all")
     */
    public function users(UserRepository $userRepository): Response{
        return $this->toJson($userRepository->findAll());
    }

    /**
     * @Route ("/api/user/{id}", name="user_show")
     */
    public function usersById(User $user): Response{
        return $this->toJson([$user]);
    }

    public function toJson($object): Response{

        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        $reponse = new Response();
        $reponse->setContent($serializer->serialize($object, 'json'));
        $reponse->headers->set('Content-type', 'application/json');
        return $reponse;
    }
}
