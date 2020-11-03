<?php

namespace App\Controller;

use App\Entity\Luggage;
use App\Entity\LuggageSearch;
use App\Form\LuggageSearchType;
use App\Form\LuggageType;
use App\Repository\LuggageRepository;
use App\Repository\ReactionRepository;
use Cocur\Slugify\Slugify;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
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
     * @Route("/", name="luggage_index")
     */
    public function index(Request $request,
                          PaginatorInterface $paginator,
                          LuggageRepository $luggageRepository): Response
    {
        $search = new LuggageSearch();
        $form = $this->createForm(LuggageSearchType::class, $search);
        $form->handleRequest($request);


        $paginatedLuggages = $paginator->paginate(
            $luggageRepository->findAllAvailable(),
            $request->query->getInt('page', 1),
            6);


        return $this->render('luggage/index.html.twig', [
            'luggages' => $paginatedLuggages,
            'form' => $form->createView()
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
     * @Route("/{slug}-{id}/show", name="luggage_show", requirements={"slug": "[a-z0-9\-]*"})
     */
    public function show(string $slug, Luggage $luggage, LuggageRepository $luggageRepository): Response
    {
        if($luggage->getSlug() !== $slug){
            return $this->redirectToRoute('luggage_show', [
                'slug' => $luggage->getSlug(),
                'id' => $luggage->getId()],
                301);
        }
        return $this->render('luggage/show.html.twig', [
            'luggage' => $luggageRepository->find($luggage->getId())
        ]);
    }

    /**
     * @Route("/{id}-{slug}/edit", name="luggage_edit", methods={"GET","POST"}, requirements={"slug": "[a-z0-9\-]*"})
     */
    public function edit(Slugify $slugify, Request $request, Luggage $luggage): Response
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

    /**
     * @Route("/{id}/reaction", name="luggage_reaction")
     */
    public function like(Luggage $luggage,
                         EntityManagerInterface $entityManager,
                         ReactionRepository $reactionRepository) : Response
    {
        $user = $this->getUser();

        if(!$user){
            return $this->json([
                'code' => '403',
            ],403);
        }

        if($luggage->isLikedByUser($user)){
            $reaction = $reactionRepository->findOneBy([
                'user' => $user,
                'luggage' => $luggage
            ]);

            $entityManager->remove($reaction);
            $entityManager->flush();

            return $this->json([
                'reactions' => $reactionRepository->count([
                    'luggage' => $luggage])
            ], 200);
        } else {

            $reaction = new Reaction();
            $reaction->setUser($user);
            $reaction->setLuggage($luggage);

            $entityManager->persist($reaction);
            $entityManager->flush();

            return $this->json([
                'reactions' => $reactionRepository->count([
                    'luggage' => $luggage])
            ],200);
        }
    }
}
