<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MainController extends AbstractController
{
    // private $contactManager;
    // private $productRepository;

    // public function __construct(ContactManager $contactManager, ProductRepository $productRepository)
    // {
    //     $this->contactManager = $contactManager;
    //     $this->productRepository = $productRepository;
    // }

    /**
     * @Route("/", name="main_index", methods={"GET"})
     */

    public function index(): Response
    {
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
}