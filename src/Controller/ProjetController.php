<?php

declare (strict_types = 1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

final class ProjetController extends AbstractController
{
    // private $productRepository;
    // private $brandRepository;
    // private $commentManager;

    // public function __construct(ProductRepository $productRepository, BrandRepository $brandRepository, CommentManager $commentManager)
    // {
    //     $this->productRepository = $productRepository;
    //     $this->brandRepository = $brandRepository;
    //     $this->commentManager = $commentManager;
    // }

    /**
     * @Route("/projet/list", name="projet_list", methods={"GET"})
     */

    public function listProjet(): Response
    {
        return $this->render('projet/list_projet.html.twig', [
            'controller_name' => 'ProjetController',
        ]);
    }

    /**
     * @Route("/projet/form", name="projet_form", methods={"GET", "POST"})
     */

    public function formProjet(): Response
    {
        return $this->render('projet/form_projet.html.twig', [
            'controller_name' => 'ProjetController',
        ]);
    }

    /**
     * @Route("/projet/fiche", name="projet_fiche", methods={"GET"})
     */

    public function ficheProjet(): Response
    {
        return $this->render('projet/fiche_projet.html.twig', [
            'controller_name' => 'ProjetController',
        ]);
    }
}