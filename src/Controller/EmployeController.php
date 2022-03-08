<?php

declare (strict_types = 1);

namespace App\Controller;

use App\Entity\Employe;
use App\Form\EmployeType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

final class EmployeController extends AbstractController
{
    private $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

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

    public function formEmploye(Request $request): Response
    {
        $employe = new Employe();
        $form = $this->createForm(EmployeType::class, $employe);
        $form->handleRequest($request);
        var_dump($form->isSubmitted());

        if($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($employe);
            $this->em->flush();

            return $this->redirectToRoute('employe_list');
        }

        return $this->render('employe/form_employe.html.twig', [
            'form' => $form->createView(),
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