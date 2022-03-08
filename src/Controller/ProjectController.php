<?php

declare (strict_types = 1);

namespace App\Controller;

use App\Entity\Project;
use App\Form\ProjectType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

final class ProjectController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/project/list", name="project_list", methods={"GET"})
     */

    public function listProject(): Response
    {
        return $this->render('project/list_project.html.twig', [
            'controller_name' => 'ProjectController',
        ]);
    }

    /**
     * @Route("/project/form", name="project_form", methods={"GET", "POST"})
     */

    public function formProject(Request $request): Response
    {
        $project = new Project();
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $project->setCreatedAt(new \DateTime());
            $this->em->persist($project);
            $this->em->flush();

            return $this->redirectToRoute('project_list');
        }

        return $this->render('project/form_project.html.twig', [
            'controller_name' => 'ProjectController',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/project/fiche", name="project_fiche", methods={"GET"})
     */

    public function ficheProject(): Response
    {
        return $this->render('project/fiche_project.html.twig', [
            'controller_name' => 'ProjectController',
        ]);
    }
}