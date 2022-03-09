<?php

namespace App\Controller;

use App\Repository\ProductionRepository;
use App\Repository\EmployeeRepository;
use App\Repository\ProjectRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MainController extends AbstractController
{
    private $pr;
    private $er;
    private $prj;

    public function __construct(ProductionRepository $pr, EmployeeRepository $er, ProjectRepository $prj)
    {
        $this->pr = $pr;
        $this->er = $er;
        $this->prj = $prj;
    }

    /**
     * @Route("/", name="main_index", methods={"GET"})
     */

    public function index(): Response
    {
        $productions = $this->pr->findTenProdByDate();
        $prodDays = $this->pr->countProductionDays();
        $nbEmployees = $this->er->countEmployees();
        $nbInProgressProjects = $this->prj->countInProgressProject();
        $nbFinishedProjects = $this->prj->countFinishedProject();
        $projects = $this->prj->findFiveProjByDate();

        $deliveryRate = number_format(($nbFinishedProjects * 100) / ($nbFinishedProjects + $nbInProgressProjects), 2);

        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
            'productions' => $productions,
            'nbEmployees' => $nbEmployees,
            'prodDays' => $prodDays,
            'nbInProgressProjects' => $nbInProgressProjects,
            'nbFinishedProjects' => $nbFinishedProjects,
            'deliveryRate' => $deliveryRate,
            'projects' => $projects,
        ]);
    }
}