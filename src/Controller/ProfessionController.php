<?php

declare (strict_types = 1);

namespace App\Controller;

use App\Entity\Profession;
Use App\Form\ProfessionType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

final class ProfessionController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/profession/list", name="profession_list", methods={"GET"})
     */

    public function listProfession(): Response
    {
        return $this->render('profession/list_profession.html.twig', [
            'controller_name' => 'ProfessionController',
        ]);
    }

    /**
     * @Route("/profession/form", name="profession_form", methods={"GET", "POST"})
     */

    public function formProfession(Request $request): Response
    {
        $profession = new Profession();
        $form = $this->createForm(ProfessionType::class, $profession);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($profession);
            $this->em->flush();

            return $this->redirectToRoute('profession_list');
        }

        return $this->render('profession/form_profession.html.twig', [
            'controller_name' => 'ProfessionController',
            'form' => $form->createView(),
        ]);
    }
}