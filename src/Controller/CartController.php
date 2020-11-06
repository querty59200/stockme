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
            'total' => $cartService->getTotalPriceAllItems()
        ]);
    }

    // BY ITEM

    /**
     * @Route("/{id}/add", name="cart_add")
     */
    public function addOne(Luggage $luggage, CartService $cartService) : Response {

        $cartService->addOneItemInSession($luggage);

        return $this->json([
            'nbItemsSelected' => $cartService->countItemSelected($luggage),
            'priceTotalByItem' => $cartService->getTotalPrice($luggage),
            'priceTotalForAll' => $cartService->getTotalPriceAllItems(),

            'nbAllItemsSelected' => $cartService->countAllItemsSelected()]
        , 200);
    }
    /**
     * @Route("/{id}/delete", name="cart_delete")
     */
    public function deleteOne(Luggage $luggage, CartService $cartService) : Response {

        // Ote un item en session
        $cartService->deleteOneItemInSession($luggage);

        return $this->json([
                'nbItemsSelected' => $cartService->countItemSelected($luggage),
                'priceTotalByItem' => $cartService->getTotalPrice($luggage),
                'priceTotalForAll' => $cartService->getTotalPriceAllItems(),

                'nbAllItemsSelected' => $cartService->countAllItemsSelected()]
            , 200);
    }

    // FOR ALL

    /**
     * @Route("/{id}/remove", name="cart_remove")
     */
    public function remove(Luggage $luggage, CartService $cartService) : Response {

        $cartService->removeAllSameItems($luggage);
        return $this->redirectToRoute('cart_show');
    }
}

