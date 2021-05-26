<?php

namespace App\Controller;

use App\Entity\Chefkok;
use App\Form\ChefkokType;
use App\Form\PizzaChefType;
use App\Repository\ChefkokRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/chefkok")
 */
class ChefkokController extends AbstractController
{
    /**
     * @Route("/", name="chefkok_index", methods={"GET"})
     */
    public function index(ChefkokRepository $chefkokRepository): Response
    {
        return $this->render('chefkok/index.html.twig', [
            'chefkoks' => $chefkokRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="chefkok_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $chefkok = new Chefkok();
        $form = $this->createForm(ChefkokType::class, $chefkok);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($chefkok);
            $entityManager->flush();

            return $this->redirectToRoute('chefkok_index');
        }

        return $this->render('chefkok/new.html.twig', [
            'chefkok' => $chefkok,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="chefkok_show", methods={"GET"})
     */
    public function show(Chefkok $chefkok): Response
    {
        return $this->render('chefkok/show.html.twig', [
            'chefkok' => $chefkok,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="chefkok_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Chefkok $chefkok): Response
    {

        $form = $this->createForm(PizzaChefType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $task = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($task);
            $entityManager->flush();

            return $this->redirectToRoute('task_success');
        }

        return $this->render('chefkok/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="chefkok_delete", methods={"POST"})
     */
    public function delete(Request $request, Chefkok $chefkok): Response
    {
        if ($this->isCsrfTokenValid('delete'.$chefkok->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($chefkok);
            $entityManager->flush();
        }

        return $this->redirectToRoute('chefkok_index');
    }
}
