<?php

namespace App\Controller;

use App\Entity\Luggage;
use App\Form\LuggageType;
use App\Repository\LuggageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/luggage")
 */
class LuggageController extends AbstractController
{
    /**
     * @Route("/", name="luggage_index", methods={"GET"})
     */
    public function index(LuggageRepository $luggageRepository): Response
    {
        return $this->render('luggage/index.html.twig', [
            'luggage' => $luggageRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="luggage_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $luggage = new Luggage();
        $form = $this->createForm(LuggageType::class, $luggage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($luggage);
            $entityManager->flush();

            return $this->redirectToRoute('luggage_index');
        }

        return $this->render('luggage/new.html.twig', [
            'luggage' => $luggage,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="luggage_show", methods={"GET"})
     */
    public function show(Luggage $luggage): Response
    {
        return $this->render('luggage/show.html.twig', [
            'luggage' => $luggage,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="luggage_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Luggage $luggage): Response
    {
        $form = $this->createForm(LuggageType::class, $luggage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('luggage_index');
        }

        return $this->render('luggage/edit.html.twig', [
            'luggage' => $luggage,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="luggage_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Luggage $luggage): Response
    {
        if ($this->isCsrfTokenValid('delete'.$luggage->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($luggage);
            $entityManager->flush();
        }

        return $this->redirectToRoute('luggage_index');
    }
}
