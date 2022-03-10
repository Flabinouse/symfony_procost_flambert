<?php

declare (strict_types = 1);

namespace App\Controller;

use App\Repository\ProjectRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

final class ValidController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em, ProjectRepository $repository)
    {
        $this->em = $em;
        $this->repository = $repository;
    }

    /**
     * @Route("/project/list/valid/{id}", name="project_valid", requirements={"id"="\d+"}, methods={"GET", "POST"})
     */

    public function listProject(Request $request, int $id): Response
    {
        $project = $this->repository->find($id);
        $project->setDeliveryDate(new \DateTime());
        $this->em->flush();

            return $this->redirectToRoute('project_list');
    }
}