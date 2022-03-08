<?php

declare (strict_types = 1);

namespace App\Controller;

use App\Entity\Projet;
use App\Form\ProjetType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

final class ProjetController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/projet/list", name="projet_list", methods={"GET"})
     */

    public function listProjet(): Response
    {
        return $this->render('projet/list_projet.html.twig', [
            'controller_name' => 'ProjetController',
        ]);
    }

    /**
     * @Route("/projet/form", name="projet_form", methods={"GET", "POST"})
     */

    public function formProjet(Request $request): Response
    {
        $projet = new Projet();
        $form = $this->createForm(ProjetType::class, $projet);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $projet->setCreatedAt(new \DateTime());
            $this->em->persist($projet);
            $this->em->flush();

            return $this->redirectToRoute('projet_list');
        }

        return $this->render('projet/form_projet.html.twig', [
            'controller_name' => 'ProjetController',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/projet/fiche", name="projet_fiche", methods={"GET"})
     */

    public function ficheProjet(): Response
    {
        return $this->render('projet/fiche_projet.html.twig', [
            'controller_name' => 'ProjetController',
        ]);
    }
}