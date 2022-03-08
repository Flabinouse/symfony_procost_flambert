<?php

declare (strict_types = 1);

namespace App\Controller;

use App\Entity\Employee;
use App\Form\EmployeeType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

final class EmployeeController extends AbstractController
{
    private $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/employee/list", name="employee_list", methods={"GET"})
     */

    public function listEmployee(): Response
    {
        return $this->render('employee/list_employee.html.twig', [
            'controller_name' => 'EmployeeController',
        ]);
    }

    /**
     * @Route("/employee/form", name="employee_form", methods={"GET", "POST"})
     */

    public function formEmployee(Request $request): Response
    {
        $employee = new Employee();
        $form = $this->createForm(EmployeeType::class, $employee);
        $form->handleRequest($request);
        var_dump($form->isSubmitted());

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
     * @Route("/employee/fiche", name="employee_fiche", methods={"GET"})
     */

    public function ficheEmployee(): Response
    {
        return $this->render('employee/fiche_employee.html.twig', [
            'controller_name' => 'EmployeeController',
        ]);
    }
}