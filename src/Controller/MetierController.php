<?php

declare (strict_types = 1);

namespace App\Controller;

use App\Entity\Metier;
Use App\Form\MetierType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

final class MetierController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

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

    public function formMetier(Request $request): Response
    {
        $metier = new Metier();
        $form = $this->createForm(MetierType::class, $metier);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($metier);
            $this->em->flush();

            return $this->redirectToRoute('metier_list');
        }

        return $this->render('metier/form_metier.html.twig', [
            'controller_name' => 'MetierController',
            'form' => $form->createView(),
        ]);
    }
}