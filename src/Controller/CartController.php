<?php

namespace App\Controller;

use App\Entity\Luggage;
use App\Repository\LuggageRepository;
use App\Service\Cart\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/cart")
 */
class CartController extends AbstractController
{
    /**
     * @Route("/", name="cart_show")
     */
    public function index(CartService $cartService): Response
    {
        return $this->render('cart/index.html.twig', [
            'items' => $cartService->getCart(),
            'total' => $cartService->getTotalPrice()
        ]);
    }

    /**
     * @Route("Cart/{id}/add", name="cart_add")
     */
    public function add(Luggage $luggage, CartService $cartService) : Response{

        $cartService->add($luggage);
        return $this->redirectToRoute('luggage');
    }

    /**
     * @Route("Cart/{id}/remove", name="cart_remove")
     */
    public function remove(Luggage $luggage, CartService $cartService) : Response {

        $cartService->remove($luggage);
        return $this->redirectToRoute('cart_show');
    }
}

