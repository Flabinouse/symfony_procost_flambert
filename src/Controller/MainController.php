<?php

namespace App\Controller;

use App\Repository\ProductionRepository;
use App\Repository\EmployeeRepository;
use App\Repository\ProjectRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
        $nbInProgressProjects = $this->prj->countInProgressProject();
        $finishedProjects = $this->prj->getFinishedProject();
        $projects = $this->prj->findFiveProjByDate();
        $allEmployeesStats = $this->er->findTopEmployees();

        if(!$productions || !$projects || !$allEmployeesStats || !$prodDays || !$nbInProgressProjects || !$finishedProjects) {
            throw $this->createNotFoundException('404 Not Found');
        }

        $deliveryRate = number_format((count($finishedProjects) * 100) / (count($finishedProjects) + $nbInProgressProjects), 2);

        $nbGainful = 0;
        foreach($finishedProjects as $projet){
            $costProject = $this->prj->costProjectById($projet['id']);
            if($projet['sellPrice'] > (int)$costProject[0]['totalCost']){
                $nbGainful++;
            }
        }

        if(count($finishedProjects) === 0){
            $gainRate = 0;
        } else {
            $gainRate = number_format(($nbGainful * 100) / count($finishedProjects), 2);
        }

        return $this->render('main/index.html.twig', [
            'productions' => $productions,
            'nbEmployees' => count($allEmployeesStats),
            'prodDays' => $prodDays,
            'nbInProgressProjects' => $nbInProgressProjects,
            'nbFinishedProjects' => count($finishedProjects),
            'deliveryRate' => $deliveryRate,
            'projects' => $projects,
            'topEmployees' => $allEmployeesStats[0],
            'gainRate' => $gainRate,
        ]);
    }
}