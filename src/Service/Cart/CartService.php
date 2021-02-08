<?php

namespace App\Service\Cart;

use App\Entity\Luggage;
use App\Repository\LuggageRepository;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartService
{

    private $session;
    private $luggageRepository;

    public function __construct(SessionInterface $session, LuggageRepository $luggageRepository)
    {
        $this->session = $session;
        $this->luggageRepository = $luggageRepository;
    }


    // BY ITEM

    public function addOneItemInSession(Luggage $luggage): void
    {

        $cart = $this->session->get('cart', []);

        if (!empty($cart[$luggage->getId()])) {
            $cart[$luggage->getId()]++;
        } else {
            $cart[$luggage->getId()] = 1;
        }

        $this->session->set('cart', $cart);
    }

    public function deleteOneItemInSession(Luggage $luggage): void
    {

        $cart = $this->session->get('cart', []);

        if (!empty($cart[$luggage->getId()]) and $cart[$luggage->getId()] > 0) {
            $cart[$luggage->getId()]--;
        } else {
            $cart[$luggage->getId()] = 0;
        }

        $this->session->set('cart', $cart);
    }

    // By Group

    public function countItemSelected(Luggage $luggage): int
    {

        $cart = $this->session->get('cart', []);

        if (!empty($cart[$luggage->getId()])) {
            return $cart[$luggage->getId()];
        }

        return 0;
    }

    public function getTotalPrice(Luggage $luggage): float
    {

        return number_format($this->countItemSelected($luggage) * $luggage->getPrice(), 2);

    }

    // FOR ALL

    public function countAllItemsSelected(): int
    {

        $cart = $this->session->get('cart', []);

        $nbItems = 0;

        foreach ($cart as $key => $value) {
            if (!empty($key)) {
                $nbItems += $value;
            }
        }
        return $nbItems;
    }

    public function removeAllSameItems(Luggage $luggage): void
    {
        $cart = $this->session->get('cart', []);
        if (!empty($cart[$luggage->getId()])) {
            unset($cart[$luggage->getId()]);
        }

        $this->session->set('cart', $cart);
    }

    public function getTotalPriceAllItems(): float
    {

        $total = 0.0;

        foreach ($this->getCart() as $item) {
            $totalItem = $item['luggage']->getPrice() * $item['quantity'];
            $total += $totalItem;
        }

        return number_format($total, 2);
    }

    public function getCart(): array
    {
        $cart = $this->session->get('cart', []);

        $cartWithLuggages = [];

        foreach ($cart as $id => $quantity) {
            $cartWithLuggages[] = [
                'luggage' => $this->luggageRepository->find($id),
                'quantity' => $quantity
            ];
        }
        return $cartWithLuggages;
    }
}