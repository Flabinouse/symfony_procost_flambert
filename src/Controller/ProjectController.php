<?php

declare (strict_types = 1);

namespace App\Controller;

use App\Entity\Project;
use App\Form\ProjectType;
use App\Form\ValidationType;
use App\Repository\ProjectRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;

final class ProjectController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em, ProjectRepository $repository)
    {
        $this->em = $em;
        $this->repository = $repository;
    }

    /**
     * @Route("/project/list", name="project_list", methods={"GET", "POST"})
     */

    public function listProject(Request $request, PaginatorInterface $paginator): Response
    {
        $projects = $this->repository->findAll();
        
        $filterProjects = $paginator->paginate(
            $projects,
            $request->query->getInt('page', 1),
            10
        );

        $form = $this->createForm(ValidationType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $project = $this->repository->find($form->getData()['id']);
            $project->setDeliveryDate(new \DateTime());
            $this->em->persist($project);
            $this->em->flush();

            return $this->redirectToRoute('project_list');
        }

        return $this->render('project/list_project.html.twig', [
            'projects' => $filterProjects,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/project/form/{id}", name="project_form", requirements={"id"="\d+"}, methods={"GET", "POST"})
     */

    public function formProject(Request $request, int $id): Response
    {
        if($id > 0) {
            $project = $this->repository->find($id);
        } else {
            $project = new Project();
            $project->setCreatedAt(new \DateTime());
        }
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $project->setDeliveryDate(NULL);
            $this->em->persist($project);
            $this->em->flush();

            return $this->redirectToRoute('project_list');
        }

        return $this->render('project/form_project.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/project/detail/{id}", name="project_detail", requirements={"id"="\d+"}, methods={"GET", "POST"})
     */

    public function detailProject(Request $request, int $id, PaginatorInterface $paginator): Response
    {
        $project = $this->repository->find($id);

        $statsProject = $this->repository->sumDailyCostEmployee($id);
        $nbEmployee = count($statsProject);

        $filterProjects = $paginator->paginate(
            $statsProject,
            $request->query->getInt('page', 1),
            5
        );

        return $this->render('project/detail_project.html.twig', [
            'project' => $project,       
            'productions' => $filterProjects,
            'nbEmployee' => $nbEmployee,
        ]);
    }
}