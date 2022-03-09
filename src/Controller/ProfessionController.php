<?php

declare (strict_types = 1);

namespace App\Controller;

use App\Entity\Profession;
Use App\Form\ProfessionType;
use App\Repository\ProfessionRepository;
use Container00xJNnB\PaginatorInterface_82dac15;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;

final class ProfessionController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em, ProfessionRepository $er)
    {
        $this->em = $em;
        $this->er = $er;
    }

    /**
     * @Route("/profession/list", name="profession_list", methods={"GET"})
     */

    public function listProfession(Request $request, PaginatorInterface $paginator): Response
    {
        $professions = $this->er->findAll();
        $filterProfessions = $paginator->paginate(
            $professions,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('profession/list_profession.html.twig', [
            'controller_name' => 'ProfessionController',
            'professions' => $filterProfessions,
        ]);
    }

    /**
     * @Route("/profession/form/{id}", name="profession_form", requirements={"id"="\d+"}, methods={"GET", "POST"})
     */

    public function formProfession(Request $request, int $id): Response
    {
        if($id > 0) {
            $profession = $this->er->find($id);
        } else {
            $profession = new Profession();
        }
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