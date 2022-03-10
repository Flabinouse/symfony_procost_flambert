<?php

declare (strict_types = 1);

namespace App\Controller;

use App\Entity\Employee;
use App\Form\EmployeeType;
use App\Entity\Production;
use App\Form\ProductionType;
use App\Repository\EmployeeRepository;
use ContainerFNxgEOQ\PaginatorInterface_82dac15;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;

final class EmployeeController extends AbstractController
{
    private $em;
    private $er;
    
    public function __construct(EntityManagerInterface $em, EmployeeRepository $er)
    {
        $this->em = $em;
        $this->er = $er;
    }

    /**
     * @Route("/employee/list", name="employee_list", methods={"GET"})
     */

    public function listEmployee(Request $request, PaginatorInterface $paginator): Response
    {
        $employees = $this->er->findAll();
        $filterEmployees = $paginator->paginate(
            $employees,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('employee/list_employee.html.twig', [
            'controller_name' => 'EmployeeController',
            'employees' => $filterEmployees,
        ]);
    }

    /**
     * @Route("/employee/form/{id}", name="employee_form", requirements={"id"="\d+"}, methods={"GET", "POST"})
     */

    public function formEmployee(Request $request, int $id): Response
    {
        if($id > 0) {
            $employee = $this->er->find($id);
        } else {
            $employee = new Employee();
        }
        $form = $this->createForm(EmployeeType::class, $employee);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($employee);
            $this->em->flush();

            return $this->redirectToRoute('employee_list');
        }

        return $this->render('employee/form_employee.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/employee/detail/{id}", name="employee_detail", requirements={"id"="\d+"}, methods={"GET", "POST"})
     */

    public function detailEmployee(Request $request, int $id, PaginatorInterface $paginator): Response
    {
        $employee = $this->er->find($id);

        $production = new Production();
        $production->setEmployee($employee);
        $form = $this->createForm(ProductionType::class, $production);
        $form->handleRequest($request);
        
        $filterEmployeeProductions = $paginator->paginate(
            $employee->getProductions(),
            $request->query->getInt('page', 1),
            5
        );

        if($form->isSubmitted() && $form->isValid()) {
            $production->setCreatedAt(new \DateTime());
            $this->em->persist($production);
            $this->em->flush();

            return $this->redirectToRoute('employee_detail', ['id' => $id]);
        }

        return $this->render('employee/detail_employee.html.twig', [
            'controller_name' => 'EmployeeController',
            'employee' => $employee,
            'filterEmployeeProductions' => $filterEmployeeProductions,
            'form' => $form->createView(),
        ]);
    }
}