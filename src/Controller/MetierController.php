<?php

declare (strict_types = 1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

final class MetierController extends AbstractController
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
     * @Route("/metier/list", name="metier_list", methods={"GET"})
     */

    public function listMetier(): Response
    {
        return $this->render('metier/list_metier.html.twig', [
            'controller_name' => 'MetierController',
        ]);
    }

    /**
     * @Route("/metier/form", name="metier_form", methods={"GET", "POST"})
     */

    public function formMetier(): Response
    {
        return $this->render('metier/form_metier.html.twig', [
            'controller_name' => 'MetierController',
        ]);
    }
}