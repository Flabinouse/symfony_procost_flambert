<?php

declare (strict_types = 1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

final class EmployeController extends AbstractController
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
     * @Route("/employe/list", name="employe_list", methods={"GET"})
     */

    public function listEmploye(): Response
    {
        return $this->render('employe/list_employe.html.twig', [
            'controller_name' => 'EmployeController',
        ]);
    }

    /**
     * @Route("/employe/form", name="employe_form", methods={"GET", "POST"})
     */

    public function formEmploye(): Response
    {
        return $this->render('employe/form_employe.html.twig', [
            'controller_name' => 'EmployeController',
        ]);
    }

    /**
     * @Route("/employe/fiche", name="employe_fiche", methods={"GET"})
     */

    public function ficheEmploye(): Response
    {
        return $this->render('employe/fiche_employe.html.twig', [
            'controller_name' => 'EmployeController',
        ]);
    }
}