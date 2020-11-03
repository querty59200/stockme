<?php

namespace App\Service\Cart;

use App\Entity\Luggage;
use App\Repository\LuggageRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartService {

    private $session;
    private $luggageRepository;

    public function __construct(SessionInterface $session, LuggageRepository $luggageRepository){
        $this->session = $session;
        $this->luggageRepository = $luggageRepository;
    }

    public function add(Luggage $luggage) : void {

        $cart = $this->session->get('Cart', []);

        if(!empty($cart[$luggage->getId()])){
            $cart[$luggage->getId()]++;
        } else {
            $cart[$luggage->getId()] = 1;
        }

        $this->session->set('Cart', $cart);
    }

    public function remove(Luggage $luggage) : void {
        $cart = $this->session->get('Cart', []);
        if(!empty($cart[$luggage->getId()])) {
            unset($cart[$luggage->getId()]);
        }

        $this->session->set('Cart', $cart);
    }

    public function getCart() : array {
        $cart = $this->session->get('Cart', []);
        $cartWithLuggages = [];

        foreach ($cart as $id => $quantity){
            $cartWithLuggages[] = [
                'luggage' => $this->luggageRepository->find($id),
                'quantity' => $quantity
            ];
        }
        return $cartWithLuggages;
    }

    public function getTotalPrice() : float{

        $total = 0.0;

        foreach ($this->getCart() as $item){
            $totalItem = $item['luggage']->getPrice() * $item['quantity'];
            $total += $totalItem;
        }

        return $total;
    }

}