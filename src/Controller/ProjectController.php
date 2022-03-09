<?php

declare (strict_types = 1);

namespace App\Controller;

use App\Entity\Project;
use App\Form\ProjectType;
use App\Repository\ProjectRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

final class ProjectController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em, ProjectRepository $repository)
    {
        $this->em = $em;
        $this->repository = $repository;
    }

    /**
     * @Route("/project/list", name="project_list", methods={"GET"})
     */

    public function listProject(): Response
    {
        $projects = $this->repository->findAll();

        return $this->render('project/list_project.html.twig', [
            'controller_name' => 'ProjectController',
            'projects' => $projects,
        ]);
    }

    /**
     * @Route("/project/form/{id}", name="project_form", requirements={"id"="\d+"},methods={"GET", "POST"})
     */

    public function formProject(Request $request, int $id): Response
    {
        if($id > 0) {
            $project = $this->repository->find($id);
        } else {
            $project = new Project();
        }
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
     * @Route("/project/detail/{id}", name="project_detail", requirements={"id"="\d+"}, methods={"GET", "POST"})
     */

    public function detailProject(int $id): Response
    {
        $project = $this->repository->find($id);

        return $this->render('project/detail_project.html.twig', [
            'controller_name' => 'ProjectController',
            'project' => $project,
        ]);
    }
}